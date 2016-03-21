<?php
/**
 * 定义视图全局变量
 * by 林蓬飞
 * date 2015.10.23
 */
class vars
{
    public function __construct(){

        /*网站基本信息*/
        $this->CI = & get_instance();
        $query = $this->CI->db->get('website');
        $website = $query->result();
        $website = $website[0];
        $this->CI->load->vars($website);
    }


}