<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Componentclass extends CI_Controller {

    private $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('component');

        if ( ! $this->session->uid OR ! $this->user->get_uid($this->session->uid)) {
            exit('请登录');
        }

        if ( ! $this->user->is_component()) {
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
        $res = $this->component->get_list($page);
        $this->data['clist'] = $res;
        $this->data['total'] = $this->component->get_total();
        $this->data['nowpage'] = $page;

        $this->load->view('/mgr/component-list',$this->data);
    }

    public function detail($cid = 0)
    {
        if ($cid) {
            $this->data['item'] = $this->component->get_cid($cid);
        }
        //var_dump($this->wechat_auth->get_auth_url(1,1));
        $this->load->view('/mgr/component-detail',$this->data);
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
            $res = $this->component->save($this->input->post());
            if (R($res)) {
                success('第三方平台信息保存成功', ROOTPATH . "componentclass/detail/" . $this->input->post('id'));
            } else {
                error($res, ROOTPATH . "componentclass/detail/" . $this->input->post('id'));
            }

        }
    }

    public function del($cid = '')
    {
        if ( ! $cid || !is_int($cid)) {
            $res = $this->component->del($cid);
            if ( ! R($res)) {
                error($res, ROOTPATH . "componentclass/showlist/", '错误', 404);
            } else {
                success('删除成功', ROOTPATH . "componentclass/showlist/");
            }
        } else {
            error('该ID不合法', ROOTPATH . "componentclass/showlist/", '错误', 404);
        }

    }
}
