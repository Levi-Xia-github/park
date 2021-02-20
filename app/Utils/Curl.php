<?php


namespace app\Utils;

class  Curl{
    /**
     * 多种请求方法封装
     * 
     * @param string   $url      请求地址
     * @param array    $header   请求头
     * @param array    $data     请求体
     * 
     * @return mixd 
     */
    public static function get($url,  $data = [],$header = ["Content-type:application/json;charset=utf-8", "Accept:application/json"])
    {
        if(!empty($data)){
            $check = strpos($url, '?');  
            if($check !== false){
                $url .= "&";
            }else{
                $url .= "?";
            }
            $url .= http_build_query($data);
        }
        //初始化
        $ch = curl_init();
        //设置桥接(抓包)
        //curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        //设置请求地址
        curl_setopt($ch, CURLOPT_URL, $url);
        // 检查ssl证书
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // 从检查本地证书检查是否ssl加密
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $url);
        //设置请求方法
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        //设置请求头
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        // //设置请求数据
        // if (!empty($data)) {
        //     curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        // }
        //设置curl_exec()的返回值以字符串返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        curl_close($ch); 
        $res = json_decode($res);
        return $res;
    }

    public static function post( $url, $data=[] ,$header = ["Content-type:application/json;charset=utf-8", "Accept:application/json"] ) {

        //初始化
        $curl = curl_init();
        //设置抓取的url
        curl_setopt($curl, CURLOPT_URL, $url);
        //设置头文件的信息作为数据流输出
        curl_setopt($curl, CURLOPT_HEADER, 0);
        //设置获取的信息以文件流的形式返回，而不是直接输出。
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        // 超时设置
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);

        // 超时设置，以毫秒为单位
        // curl_setopt($curl, CURLOPT_TIMEOUT_MS, 500);

        // 设置请求头
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE );

        //设置post方式提交
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        //执行命令
        $data = curl_exec($curl);

        // 显示错误信息
        if (curl_error($curl)) {
            print "Error: " . curl_error($curl);
        } else {
            // 打印返回的内容
            var_dump($data);
            curl_close($curl);
        }
    }
}