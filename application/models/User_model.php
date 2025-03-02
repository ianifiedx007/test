<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_user($email, $password) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            $user = $query->row();
            if ($password === $user->password) {
                return $user;
            }
        }
        return false;
    }
}
?>
