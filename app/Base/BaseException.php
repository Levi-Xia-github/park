<?php
namespace app\Base;

use think\Exception;


class BaseException extends Exception
{
    const WARNING = 'warning';
    const DEBUG = 'debug';
    const TRACE = 'trace';
    const FATAL = 'fatal';
    const NOTICE = 'notice';

    // 错误码
    public $errCode;
    // 错误码对应说明
    public $errMsg;

    public function __construct($errCode = 0) {
        $this->errCode = $errCode;
        if (isset(BaseErrorCode::$codes[$errCode])) {
            $this->errMsg = strval(@BaseErrorCode::$codes[$errCode]);
        } else {
            $this->errCode = 9998;
            $this->errMsg = '未定义错误';
        }
    }
}