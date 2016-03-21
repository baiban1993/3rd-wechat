<?php

class Component extends CI_Model {

    private $component_list = array();

    public function __construct()
    {
        parent::__construct();
    }

    public function get_total($uid = '')
    {
        $uid = $uid ? $uid : $this->session->uid;

        $num = $this->db->where('uid', $uid)->count_all_results('component');
        return $num;
    }

    public function get_list($page = 1, $uid = '')
    {
        $uid = $uid ? $uid : $this->session->uid;

        $res = $this->db->limit(15, 15 * ($page - 1) )->where('uid', $uid)->get('component');
        $res = $res->result_array();
        return $res;
    }

    public function get_cid($cid, $uid = '')
    {
        $uid = $uid ? $uid : $this->session->uid;

        $res = $this->db->where(array('uid' => $uid, 'id' => $cid))->get('component');
        $res = $res->result_array();
        return isset($res[0]) ? $res[0] : false;

    }

    public function save($data)
    {
        if ($data['id']) {
            $cid = $data['id'];
            unset($data['id']);
            $this->db->where('id', $cid)->set($data)->update('component');
            if ( ! $this->db->affected_rows()) {
                return E('数据更新失败，或者所提交的数据与之前并无改动。');
            }
        } else {
            $data['uid'] = $this->session->uid;
            unset($data['id']);
            $res = $this->db->insert('component', $data);
            if ( ! $res) {
                return E('数据插入失败，请检查您的输入或通知管理员。');
            }
        }
        return S();
    }

    public function del($cid)
    {
        $uid = $this->session->uid;
        $this->db->delete('component', array('id' => $cid, 'uid' => $uid));
        $res = $this->db->affected_rows();
        if ( ! $res) {
            return E('数据删除失败，可能该ID不存在或它并不属于您所有。');
        }
        return S();
    }
}