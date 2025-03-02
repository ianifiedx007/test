<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JobPoster extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        if ($this->session->userdata('role') != 3) {
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $this->load->model('Job_model');
        $status = $this->input->get('status') ?? 'all';
        $email = $this->session->userdata('email');
        $data['status'] = $status;
        $data['jobs'] = $this->Job_model->get_jobs_by_status($status, $email);
        $this->load->view('job_poster', $data);
    }
}
?>