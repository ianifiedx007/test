<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function login() {
        $this->load->view('auth/login');
    }

    public function login_process() {
        header('Content-Type: application/json');

        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $this->load->model('User_model');
        $user = $this->User_model->get_user($email, $password);

        if ($user) {
            $this->session->set_userdata([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role
            ]);

            echo json_encode([
                "status" => "success",
                "role" => $user->role,
                "redirect_url" => ($user->role == '1') 
                    ? site_url('jobmoderator/dashboard') 
                    : (($user->role == '3') 
                        ? site_url('jobposter/dashboard') 
                        : site_url('jobseeker/dashboard'))
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Invalid email or password."
            ]);
        }
    }


    public function logout() {
        $this->session->sess_destroy();
        redirect('auth/login');
    }
}
?>
