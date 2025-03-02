<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Job_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function is_job_first_post($email) {
        $this->db->where('email', $email);
        return $this->db->count_all_results('jobs') === 0;
    }

    public function insert_job($email, $title, $description) {
        $is_first_post = $this->is_job_first_post($email);

        $status = 'pending';

        if (!$is_first_post) {
            $this->db->where('email', $email);
            $this->db->where('status', 'approved');
            $first_approved = $this->db->count_all_results('jobs') > 0;

            if ($first_approved) {
                $status = 'approved';
            }
        }

        $data = [
            'email' => $email,
            'title' => $title,
            'description' => $description,
            'status' => $status
        ];

        $this->db->insert('jobs', $data);
        return $this->db->insert_id();
    }

    public function notify_moderator($job_id, $title, $description) {
        $data = [
            'job_id' => $job_id,
            'title' => $title,
            'description' => $description
        ];
        return $this->db->insert('moderator_notifications', $data);
    }

    public function get_jobs_by_status($status, $email = "") {
        $this->db->select('jobs.*');
        $this->db->from('jobs');
        if($status == "pending"){
            $this->db->join('moderator_notifications', 'jobs.id = moderator_notifications.job_id', 'inner');
        }else{
            $this->db->join('moderator_notifications', 'jobs.id = moderator_notifications.job_id', 'left');
        }
        if($status != "all"){
            $this->db->where('jobs.status', $status); 
        }
        if($email != ""){
            $this->db->where('jobs.email', $email); 
        }
        return $this->db->get()->result();
    }

    public function update_job_status($job_id, $status) {
        return $this->db->where('id', $job_id)->update('jobs', ['status' => $status]);
    }

    public function get_job_by_id($job_id) {
        $this->db->where('id', $job_id);
        $query = $this->db->get('jobs');

        if ($query->num_rows() > 0) {
            $job = $query->row_array();
            $job['is_external'] = false;
            return $job;
        }
    }
}
