<?php

function S($addon = NULL)
{
    if (is_array($addon)) {
        $code = SUCCESS_ARRAY;
        return array($code, $addon);
    } else if (is_string($addon)) {
        $code = SUCCESS_STRING;
        return array($code, $addon);
    } else {
        $code = SUCCESS;
        return array($code);
    }
}

function E($addon = NULL)
{
    if (is_array($addon)) {
        $code = ERROR_ARRAY;
        return array($code, $addon);
    } else if (is_string($addon)) {
        $code = ERROR_STRING;
        return array($code, $addon);
    } else {
        $code = ERROR;
        return array($code);
    }
}

function R(&$res)
{
    if ($res[0] == SUCCESS) {
        return true;
    } else if ($res[0] == ERROR) {
        return false;
    } else if ($res[0] == SUCCESS_STRING OR $res[0] == SUCCESS_ARRAY) {
        $res = $res[1];
        return true;
    } else if ($res[0] == ERROR_STRING OR $res[0] == ERROR_ARRAY) {
        $res = $res[1];
        return false;
    }
}

function Pager($total, $nowpage, $uri)
{
    $totalpage = intval($total / 15) + 1;
    $str = '';
    if ($totalpage <= 5) {
        $start = 1;
        $end = $totalpage;
    } else if ($nowpage >= ($totalpage - 2) ) {
        $start = $totalpage - 4;
        $end = $totalpage;
    } else {
        $start = $nowpage - 2;
        $end = $nowpage + 2;
    }

    $str .= '<div class="am-fr"><ul class="am-pagination"><li><a href="' . $uri . '"">第一页</a></li>';
    for ($i = $start; $i <= $end; $i++) {
        $str .= ($i == $nowpage) ? "<li class=\"am-active\"><a href=\"{$uri}{$i}\">{$i}</a></li>" : "<li><a href=\"{$uri}{$i}\">{$i}</a></li>";
        };
    $str .= '<li><a href="' . $uri . $totalpage . '">最后一页</a></li></ul></div>
    ';
    return $str;
}



function success($message, $redirect = '', $heading = '成功', $status_code = 200)
{
    $CI = & get_instance();
    set_status_header($status_code);
    $data = array('message' => $message, 'heading' => $heading, 'redirect'=>$redirect);
    $html = $CI->load->view('/errors/success', $data, true);
    exit($html);
}

function error($message, $redirect = '', $heading = '失败', $status_code = 200)
{
    $CI = & get_instance();
    set_status_header($status_code);
    $data = array('message' => $message, 'heading' => $heading, 'redirect'=>$redirect);
    $html = $CI->load->view('/errors/error', $data, true);
    exit($html);
}