<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class JobModerator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        if ($this->session->userdata('role') != 1) {
            redirect('auth/login');
        }
    }

    public function dashboard() {
        $this->load->model('Job_model');
        $status = $this->input->get('status') ?? 'pending';
        $data['status'] = $status;
        $data['jobs'] = $this->Job_model->get_jobs_by_status($status);
        $this->load->view('job_board', $data);
    }
}
?>