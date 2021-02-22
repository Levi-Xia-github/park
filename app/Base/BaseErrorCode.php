<?php


namespace app\Base;

// 公共错误码
class BaseErrorCode {
    // 预定义 XXX
    const SUCC                 = 0;
    const PARAM_ERROR          = 101;
    const METHOD_NOT_EXIST     = 102;
    const REQUEST_ERROR        = 103;

    const USER_NOT_LOGIN       = 201;
    const USER_NOT_REGISTER    = 202;

    const JSON_FORMAT_ERROR    = 301;

    const UNKNOWN              = 999;

    const DB_QUERY_ERROR = 1001;

    public static $codes = array(
        0 => 'ok',
        101 => 'param error',
        102 => 'method not exist',
        103 => "网速缓慢…",

        201 => '请先登录',
        202 => '请先注册',

        301 => 'json数据格式错误',

        999 => 'unknown error',

        1001 => 'db query failed',

    );
}

