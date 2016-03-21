<?php

class User extends CI_Model {

    private $userinfo = array();

    public function __construct()
    {
        parent::__construct();
        $_SESSION['uid'] = 1;
        $uid = $this->session->uid;
        if ($uid) {
            $res = $this->db->where('id', $uid)->get('user');
            $res = $res->result_array();
            $this->userinfo = isset($res[0]) ? $res[0] : false;
        }
    }

    public function get_total()
    {
        $num = $this->db->count_all_results('user');
        return $num;
    }

    public function get_uid($uid = '')
    {
        if ($uid) {
            $res = $this->db->where('id', $uid)->get('user');
            $res = $res->result_array();
            return $res[0];
        }
        return $this->userinfo;

    }

    public function is_component($uid = '')
    {
        if ($uid) {
            $res = $this->db->where('id', $uid)->get('user');
            $res = $res->result_array();
            return $res[0]['is_component'];
        }
        return $this->userinfo['is_component'];
    }

    public function is_developer($uid = '')
    {
        if ($uid) {
            $res = $this->db->where('id', $uid)->get('user');
            $res = $res->result_array();
            return $res[0]['is_developer'];
        }
        return $this->userinfo['is_developer'];
    }

    public function get_money($uid = '')
    {
        if ($uid) {
            $res = $this->db->where('id', $uid)->get('user');
            $res = $res->result_array();
            return $res[0]['money'];
        }
        return $this->userinfo['money'];
    }

    public function get_app_total($uid = '')
    {
        $uid = $uid ? $uid : $this->session->uid;

        $num = $this->db->where(array('uid'=>$uid, 'enable' => 1))->count_all_results('app');
        return $num;
    }

    public function get_component_total($uid = '')
    {
        $uid = $uid ? $uid : $this->session->uid;

        $num = $this->db->where('uid', $uid)->count_all_results('component');
        return $num;
    }

}