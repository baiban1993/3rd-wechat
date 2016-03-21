<?php

class Money extends CI_Model {

    private $uid = '';

    public function __construct()
    {
        parent::__construct();
        $this->uid = $this->session->uid;
    }

    public function get_money()($uid = '')
    {
        $uid = $uid ? $uid : $this->uid;

        $res = $this->db->where('id', $uid)->get('user');
        $res = $res->result_array();
        return $res[0]['money'];
    }

}