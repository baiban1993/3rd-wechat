<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechatapi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('wechat_auth');
	}

    public function index()
    {
        exit('error');
    }

    /**
     * 微信服务器推送接口
     */
	public function api_component_verify_ticket($tmsecret = '')
	{
		if ( ! $tmsecret) {
			exit('tmsecret为空');
		}
		$query = $this->db->get_where('component', array('tmsecret' => $tmsecret), 1);
		$component = $query->result();
		$component = $component[0];
		if ( ! $component) {
			log_message('error',"api_component_verify_ticket:通讯密码为{$tmsecret}的服务商不存在");
			exit('error');
		}
		$cid = $component->id;
		$token = $component->token;
		$encodingAesKey = $component->encodingAesKey;
		$appId = $component->appid;

		$res = $this->wechat_auth->set_component_verify_ticket($cid, $token, $encodingAesKey, $appId);
		if ( ! R($res)) {
			log_message('error',$res);
		}
		exit($res);

	}

    /**
     * 获取公众号授权url
     */
	public function get_auth_url($aid = '', $cid = '')
	{
		$res = $this->wechat_auth->get_auth_url($aid, $cid);
		if (R($res)) {
			exit($res);
		}
	}


    /**
     * 保存微信授权结果
     */
	public function api_auth_code($aid = '', $appid = '', $key = '')
	{
		if ( ! $appid OR ! $aid OR ! $key) {
			exit('参数不全');
		}
		$auth_code = $this->input->get('auth_code');
		$auth_code = $this->security->xss_clean($auth_code);	/*XSS过滤*/
		$expires_time = $this->input->get('expires_in') - 200;

		$query = $this->db->get_where('component', array('appid' => $appid), 1);
        $component = $query->result();
        $component = $component[0];
        if ( ! $component) {
            log_message('error','api_auth_code:ComponentAppId为{$appid}的服务商不存在');
            exit("ComponentAppId为{$appid}的服务商不存在");
        }

        $query = $this->db->get_where('account', array('id' => $aid), 1);
        $account = $query->result();
        if ( ! $account) {
            log_message('error','api_auth_code:ID为{$aid}的公众号不存在');
            exit("ID为{$aid}的公众号不存在");
        }

        if (md5($appid . 't!m@w#e$c%h^a&t' . $aid . $component->encodingAesKey) != $key) {
        	log_message('error','api_auth_code:匹配失败');
            exit("回调地址失效，请重新通过平台申请授权");
        }

        $cid = $component->id;
        $res = $this->wechat_auth->set_auth_code($aid, $cid, $auth_code, $expires_time);
        if ( ! R($res)) {
        	log_message('error', "api_auth_code:{$res}");
        	exit("系统出错:{$res}，请联系管理员");
        } else {
        	$res = $this->wechat_auth->set_authorization_code($aid, $component->appid, $component->access_token, $auth_code);
        	if ( ! R($res)) {
        		exit("系统出错:{$res}，请联系管理员");
        	} else {
        		$res = $this->wechat_auth->set_authorizer_info($aid, $component->appid, $component->access_token, $res['appid']);
        		exit('绑定成功');
        	}


        }

	}


	public function test()
	{
		$ret = $this->wechat_auth->get_component_access_token(1);
		if ( R ($ret)) {
			$component_access_token = $ret;
			$res = $this->wechat_auth->get_authorizer_info(1, 'wx85f893b8b3d7fd03', $component_access_token,'wxca852967699c450c');
		}

	}
}
