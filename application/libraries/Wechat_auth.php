<?php
/**
 * 微信开放平台类
 * by 林蓬飞
 * date 2015.10.22
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Wechat_auth {

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    /**
     * post提交json数据
     */
    private function httpPost($url, $post_data) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        $res = curl_exec($curl);
        curl_close($curl);

    return $res;
    }
    /**
     * post提交xml数据
     */
    private function httpPostXml($url, $post_data) {
        $curl = curl_init();
        $header[] = "Content-type: text/xml";        /*定义content-type为xml,注意是数组*/
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    /**
     * 监听微信推送协议
     */
    public function set_component_verify_ticket($cid, $token, $encodingAesKey, $appId)
    {
        if ( ! $token OR ! $encodingAesKey OR ! $appId OR !isset($_GET['msg_signature']) OR ! isset($_GET['timestamp']) OR ! isset($_GET['nonce'])) {
            return E('设置微信推送协议数据不全');
        }

        include APPPATH.'third_party/wxBizMsgCrypt/wxBizMsgCrypt.php';
        $pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);

        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $object = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $msg_sign = $_GET['msg_signature'];
        $timeStamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $encrypt = $object->Encrypt;
        $format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
        $from_xml = sprintf($format, $encrypt);

        $decode_xml = '';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $decode_xml);
        if ($errCode == 0) {
            $object = simplexml_load_string($decode_xml, 'SimpleXMLElement', LIBXML_NOCDATA);
            $ComponentVerifyTicket = $object->ComponentVerifyTicket;
            $CreateTime = $object->CreateTime;
            $data = array(
                'verify_ticket' =>  "$ComponentVerifyTicket",
                'VT_create_time'=>  "$CreateTime"
                );
            $res = $this->CI->db->where("id = {$cid}")->update('component', $data);
            if ($res) {
                exit('success');

            }else{
                exit('数据插入数据表失败');
            }
        } else {
            return E('协议解密失败');
        }
    }

    /**
     * 获取第三方平台令牌
     */
    public function get_component_access_token($cid)
    {
        $query = $this->CI->db->get_where('component', array('id' => $cid), 1);
        $component = $query->result();
        $component = $component[0];
        /*如果access_token仍然有效，那么直接返回*/
        if ($component->AT_expires_time > time()) {
            return S($component->access_token);
        }

        /*如果access_token已经失效，那么重新获取*/
        $cid = $component->id;
        $component_verify_ticket = $component->verify_ticket;
        $component_appid = $component->appid;
        $component_appsecret = $component->appsecret;

        $url = "https://api.weixin.qq.com/cgi-bin/component/api_component_token";
        $post_data = json_encode(array('component_appid'=>$component_appid,'component_appsecret'=>$component_appsecret,'component_verify_ticket'=>$component_verify_ticket));
        $ret = json_decode($this->httpPost($url, $post_data), true);
        if ( ! isset($ret['errcode'])) {
            $data = array(
                'access_token' => $ret['component_access_token'],
                'AT_expires_time'   =>  time() + $ret['expires_in'] - 200   /*为了防止时延误差*/
            );
            $res = $this->CI->db->where('id',$cid)->update('component', $data);
            return S($ret['component_access_token']);
        }
        log_message('error', $ret['errmsg']);
        return E($ret['errmsg']);
    }

    /**
     * 获取第三方平台预授权码
     */
    public function get_pre_auth_code($cid)
    {
        $query = $this->CI->db->get_where('component', array('id' => $cid), 1);
        $component = $query->result();
        $component = $component[0];

        /*如果pre_auth_code仍然有效，那么直接返回*/
        if ($component->PAC_expires_time > time()) {
            return S($component->pre_auth_code);
        }

        /*如果pre_auth_code已经失效，那么重新获取*/
        $cid = $component->id;
        $component_appid = $component->appid;
        $res = $this->get_component_access_token($cid);      /*获取*/
        if ( ! R($res)) {
            return E($res);
        }
        $component_access_token = $res;
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_create_preauthcode?component_access_token=".$component_access_token;
        $post_data = json_encode(array('component_appid'=>$component_appid));
        $ret = json_decode($this->httpPost($url, $post_data), true);

        if ( ! isset($ret['errcode'])) {
            $data = array(
                'pre_auth_code' => $ret['pre_auth_code'],
                'PAC_expires_time'   =>  time() + $ret['expires_in'] - 200   /*为了防止时延误差*/
            );
            $res = $this->CI->db->where('id',$cid)->update('component', $data);
            return S($ret['pre_auth_code']);
        }

        log_message('error', $ret['errmsg']);
        return E('错误：' . $ret['errmsg']);
    }


    /**
     * 获取授权网址
     */
    public function get_auth_url($aid, $cid)
    {
        $query = $this->CI->db->get_where('component', array('id' => $cid), 1);
        $component = $query->result();
        /*如果数据库中不存在对应ID的用户，则报错*/
        if ( ! $component) {
            return E('ID不存在');
        }
        $component = $component[0];

        $cid = $component->id;
        $component_appid = $component->appid;
        $res = $this->get_pre_auth_code($cid);
        if ( ! R($res)) {
            return E($res);
        }
        $pre_auth_code = $res;
        $this->CI->load->helper('url');
        $key = md5($component->appid . 't!m@w#e$c%h^a&t' . $aid . $component->encodingAesKey);
        $redirect = urlencode(site_url('system/wechatapi/api_auth_code/' . $aid . '/' . $component->appid . '/' .$key));

        $url = "https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid={$component_appid}&pre_auth_code={$pre_auth_code}&redirect_uri={$redirect}";
        return S($url);
    }


    public function set_auth_code($aid, $cid, $auth_code, $expires_time)
    {
        $expires_time = time() + 3400;
        $data = array(
            'cid'   =>  $cid,
            'auth_code' =>  $auth_code,
            'AC_expires_time'  =>  $expires_time
            );
        $ret = $this->CI->db->where('id',$aid)->update('account', $data);;
        if ( ! $ret) {
            log_message('error', 'set_auth_code:数据插入数据表失败');
            return E('数据插入数据表失败');
        } else {
            return S();
        }
    }

    public function set_authorization_code($aid, $component_appid, $component_access_token, $auth_code)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_query_auth?component_access_token=".$component_access_token;
        $post_data = json_encode(array('component_appid'=>$component_appid, 'authorization_code'=>$auth_code));
        $ret = json_decode($this->httpPost($url, $post_data), true);

        if ( ! isset($ret['errcode'])) {
            $ret = $ret['authorization_info'];
            $data = array(
                'appid' => $ret['authorizer_appid'],
                'access_token'  =>  $ret['authorizer_access_token'],
                'expires_time'  =>  time() + $ret['expires_in'] - 200,
                'refresh_token'  =>  $ret['authorizer_refresh_token'],
                'func_info'   => json_encode(array_keys($ret['func_info']))
            );
            $res = $this->CI->db->where('id',$aid)->update('account', $data);
            if ( ! $res) {
                log_message('error', 'set_authorization_code:数据插入数据表失败');
                return E('数据插入数据表失败');
            }
            return S($data);
        }
        log_message('error', $ret['errmsg']);
        return E('错误：' . $ret['errmsg']);
    }

    public function refresh_access_token($aid, $component_appid, $component_access_token, $authorizer_appid, $authorizer_refresh_token)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?component_access_token=".$component_access_token;
        $post_data = json_encode(array('component_appid'=>$component_appid,'authorizer_appid'=>$authorizer_appid,'authorizer_refresh_token'=>$authorizer_refresh_token));
        $ret = json_decode($this->httpPost($url, $post_data), true);
        var_dump($ret);
        if ( ! isset($ret['errcode'])) {
            $data = array(
                'access_token'  =>  $ret['authorizer_access_token'],
                'expires_time'  =>  time() + $ret['expires_in'] - 200,
                'refresh_token'  =>  $ret['authorizer_refresh_token']
            );
            $ret = $this->CI->db->where('id',$aid)->update('account', $data);
            if ( ! $ret) {
                log_message('error', 'refresh_access_token:数据插入数据表失败');
                return E('数据插入数据表失败');
            }
            return S($data);
        } else {
            return E('刷新公众号access_token失败');
        }
    }

    public function set_authorizer_info($aid, $component_appid, $component_access_token, $authorizer_appid)
    {
        $url = "https://api.weixin.qq.com/cgi-bin/component/api_get_authorizer_info?component_access_token=".$component_access_token;
        $post_data = json_encode(array('component_appid'=>$component_appid,'authorizer_appid'=>$authorizer_appid));
        $ret = json_decode($this->httpPost($url, $post_data), true);

        if ( ! isset($ret['errcode'])) {
            $ret = $ret['authorizer_info'];
            $data = array(
                'nick_name' => $ret['nick_name'],
                'head_img'  =>  $ret['head_img'],
                'service_type_info'  => $ret['service_type_info']['id'],
                'verify_type_info'  =>  $ret['verify_type_info']['id'],
                'user_name' => $ret['user_name'],
                'alias' => $ret['alias'],
                'qrcode_url' => $ret['qrcode_url'],
                'business_info' => json_encode($ret['business_info'], true),
            );
            $ret = $this->CI->db->where('id',$aid)->update('account', $data);
            if ( ! $ret) {
                log_message('error', 'get_authorizer_info:数据插入数据表失败');
                return E('数据插入数据表失败');
            }
            return S($data);
        }
        log_message('error', $ret['errmsg']);
        return E('错误：' . $ret['errmsg']);
    }

}
