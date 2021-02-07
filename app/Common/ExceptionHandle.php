<?php
//ExceptionHandle.phpr文件  抛出不可预知异常
namespace app\Common;
use app\Base\BaseErrorCode;
use think\db\exception\DbException;
use think\exception\Handle;
use app\Base\BaseException;
use think\Response;
use Throwable;
use Exception;

class ExceptionHandle  extends Handle
{
    private $errCode;
    private $errMsg;

    public function render($request, Throwable $e): Response
    {
        if(env('APP_DEBUG', true)){
            return parent::render($request, $e);
        }

        if($e instanceof BaseException){
            $this->errMsg=$e->errMsg;
            $this->errCode=$e->errCode;
        }
        //数据库错误
        elseif($e instanceof DbException){
            $this->errCode = BaseErrorCode::DB_QUERY_ERROR;
            $this->errMsg = strval(@BaseErrorCode::$codes[$this->errCode]);
        }
        else{
            $this->errMsg='服务器错误,请稍后再试';
            $this->errCode=9999;
        }

        return self::Result($this->errCode,$this->errMsg);
    }

    public static function Result($errCode,$errMsg){
        $data = [
            'errCode' => $errCode,
            'errMsg' => $errMsg,
            'data'  => '',
        ];
        return json($data);
    }
}
