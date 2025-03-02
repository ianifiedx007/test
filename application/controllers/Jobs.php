<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Jobs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Job_model');
        $this->load->helper('url');
        $this->load->library('session');
    }

    // Load the Job Posting Form
    public function job_form() {
        $this->load->view('post_job'); // This loads the form view
    }

    // Handle Job Posting
    public function post_job() {
        header('Content-Type: application/json');

        $email = $this->session->userdata('email');
        $title = $this->input->post('title');
        $description = $this->input->post('description');

        // Check if all fields are filled
        if (!$email || !$title || !$description) {
            echo json_encode(["status" => "error", "message" => "All fields are required!"]);
            return;
        }

        $is_first_post = $this->Job_model->is_job_first_post($email);
        $job_id = $this->Job_model->insert_job($email, $title, $description);

        if ($job_id) {
            if ($is_first_post) {
                $this->Job_model->notify_moderator($job_id, $title, $description);
            }

            echo json_encode(["status" => "success", "message" => "Job posted successfully!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to post job!"]);
        }
    }

    public function approve($job_id) {
        if ($this->Job_model->update_job_status($job_id, 'approved')) {
            $this->session->set_flashdata('success', 'Job approved successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to approve job.');
        }
        redirect('jobmoderator/dashboard');
    }

    /**
     * Mark a job as spam
     *
     * @param int $job_id
     */
    public function spam($job_id) {
        if ($this->Job_model->update_job_status($job_id, 'spam')) {
            $this->session->set_flashdata('success', 'Job marked as spam successfully.');
        } else {
            $this->session->set_flashdata('error', 'Failed to mark job as spam.');
        }
        redirect('jobmoderator/dashboard');
    }

    public function details($id){
        $job = $this->Job_model->get_job_by_id($id);
        $data['job'] = $job;
        $this->load->view('job_details', $data);

    }

    public function details_xml($id){
        $xml_url = "https://mrge-group-gmbh.jobs.personio.de/xml";
        $xml_data = file_get_contents($xml_url);

        if ($xml_data !== false) {
            $xml = simplexml_load_string($xml_data);
            if ($xml !== false) {
                foreach ($xml->position as $position) {
                    if ((string) $position->id === $id) {
                        $job = [
                            'id'            => (string) $position->id,
                            'company'       => (string) $position->subcompany,
                            'office'        => (string) $position->office,
                            'department'    => (string) $position->department,
                            'category'      => (string) $position->recruitingCategory,
                            'title'         => (string) $position->name,
                            'description'   => strip_tags((string) $position->jobDescriptions->jobDescription[0]->value),
                            'employmentType'=> (string) $position->employmentType,
                            'seniority'     => (string) $position->seniority,
                            'schedule'      => (string) $position->schedule,
                            'experience'    => (string) $position->yearsOfExperience,
                            'keywords'      => (string) $position->keywords,
                            'createdAt'     => (string) $position->createdAt,
                            'is_external'   => true,
                            'external_url'  => isset($position->externalUrl) ? (string) $position->externalUrl : '#'
                        ];
                        break;
                    }
                }
            }
        }
        $data['job'] = $job;
        $this->load->view('job_details', $data);
    }
}
