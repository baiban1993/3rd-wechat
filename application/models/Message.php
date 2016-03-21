<?php

class Message extends CI_Model {

    private $uid = '';

    public function __construct()
    {
        parent::__construct();
        $this->uid = $this->session->uid;
    }

    public function get_new_message()
    {
        $new = $this->db->where('uid', $this->uid)->count_all_results('message');
        return $new;
    }


}