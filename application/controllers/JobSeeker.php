<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JobSeeker extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Job_model');

        if ($this->session->userdata('role') != 2) {
            redirect('auth/login'); // Redirect to login page if not authorized
        }
    }

    public function dashboard() {
        // Fetch jobs from the database (Approved Jobs)
        $db_jobs = $this->Job_model->get_jobs_by_status('approved');
        $db_jobs = json_decode(json_encode($db_jobs), true);

        $xml_url = "https://mrge-group-gmbh.jobs.personio.de/xml"; // Replace with actual XML URL
        $xml_data = file_get_contents($xml_url); 

        if ($xml_data === false) {
            show_error("Failed to fetch jobs data.");
            return;
        }

        $xml = simplexml_load_string($xml_data);

        if ($xml === false) {
            show_error("Invalid XML format.");
            return;
        }

        $xml_jobs = [];
        foreach ($xml->position as $position) {
            $description = "";
            if (isset($position->jobDescriptions->jobDescription[0]->value)) {
                $description = strip_tags((string)$position->jobDescriptions->jobDescription[0]->value);
            }

            $xml_jobs[] = [
                'id'            => (string)$position->id,
                'company'       => (string)$position->subcompany,
                'office'        => (string)$position->office,
                'department'    => (string)$position->department,
                'category'      => (string)$position->recruitingCategory,
                'title'         => (string)$position->name,
                'description'   => $description,
                'employmentType'=> (string)$position->employmentType,
                'seniority'     => (string)$position->seniority,
                'schedule'      => (string)$position->schedule,
                'experience'    => (string)$position->yearsOfExperience,
                'keywords'      => (string)$position->keywords,
                'is_external'      => true,
                'createdAt'     => (string)$position->createdAt
            ];
        }

        // Merge database jobs with XML jobs
        $jobs = array_merge($db_jobs, $xml_jobs);

        // Sort jobs alphabetically by title
        usort($jobs, function($a, $b) {
            return strcmp($a['title'], $b['title']);
        });

        $data['jobs'] = $jobs;
        $this->load->view('job_listing', $data);
    }
}
?>
