<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Index extends CI_Controller {

	private $data = array();

	public function __construct()
	{
		parent::__construct();

        if ( ! $this->session->uid OR ! $this->user->get_uid($this->session->uid)) {
			exit('请登录');
		}

		$data_sidebar = array(
			'class'		=>	__CLASS__,
			'is_component'	=>	$this->user->is_component(),
			'is_developer'	=>	$this->user->is_developer(),
			);
		$this->data = array(
			'header'	=>	$this->load->view('/mgr/header', null, true),
			'footer'	=>	$this->load->view('/mgr/footer', null, true),
			'sidebar'	=>	$this->load->view('/mgr/sidebar', $data_sidebar, true),
							);


	}

	public function index()
	{

		$this->load->view('/mgr/index',$this->data);

	}
}
