<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Developerclass extends CI_Controller {

    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('developer');

        if ( ! $this->session->uid OR ! $this->user->get_uid($this->session->uid)) {
            exit('请登录');
        }

        if ( ! $this->user->is_developer()) {
            exit('您无权访问');
        }

        $data_sidebar = array(
            'class'     =>  __CLASS__,
            'is_component'  =>  $this->user->is_component(),
            'is_developer'  =>  $this->user->is_developer(),
            );
        $this->data = array(
            'header'    =>  $this->load->view('/mgr/header', null, true),
            'footer'    =>  $this->load->view('/mgr/footer', null, true),
            'sidebar'   =>  $this->load->view('/mgr/sidebar', $data_sidebar, true),
                            );


    }

    public function index()
    {

        $this->load->view('/mgr/index',$this->data);

    }

    public function showlist($page = 1)
    {
        $res = $this->developer->get_list($page);
        $this->data['clist'] = $res;
        $this->data['total'] = $this->developer->get_total();
        $this->data['nowpage'] = $page;

        $this->load->view('/mgr/developer-list',$this->data);
    }

    public function detail($cid = 0)
    {
        if ($cid) {
            $this->data['item'] = $this->developer->get_cid($cid);
        }
        //var_dump($this->wechat_auth->get_auth_url(1,1));
        $this->load->view('/mgr/developer-detail',$this->data);
    }

    public function save()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('id', 'id', 'integer');
        $this->form_validation->set_rules('name', 'name', 'required');
        $this->form_validation->set_rules('tmsecret', 'tmsecret', 'required|alpha_numeric|min_length[5]|max_length[16]');
        $this->form_validation->set_rules('type', 'type', 'required|max_length[1]|integer');
        $this->form_validation->set_rules('appid', 'appid', 'required|alpha_numeric');
        $this->form_validation->set_rules('appsecret', 'appsecret', 'required|alpha_numeric');
        $this->form_validation->set_rules('encodingAesKey', 'encodingAesKey', 'required|alpha_numeric');
        $this->form_validation->set_rules('token', 'token', 'required');


        if ($this->form_validation->run() == false)
        {
            error('您提交的表单不满足要求，请检查后重试。');
        }
        else
        {
            $res = $this->developer->save($this->input->post());
            if (R($res)) {
                success('第三方平台信息保存成功', ROOTPATH . "developerclass/detail/" . $this->input->post('id'));
            } else {
                error($res, ROOTPATH . "developerclass/detail/" . $this->input->post('id'));
            }

        }
    }

    public function del($cid = '')
    {
        if ( ! $cid || !is_int($cid)) {
            $res = $this->developer->del($cid);
            if ( ! R($res)) {
                error($res, ROOTPATH . "developerclass/showlist/", '错误', 404);
            } else {
                success('删除成功', ROOTPATH . "developerclass/showlist/");
            }
        } else {
            error('该ID不合法', ROOTPATH . "developerclass/showlist/", '错误', 404);
        }

    }
}
