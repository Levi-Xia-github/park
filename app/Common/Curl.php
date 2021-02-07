
<?php
class  Common_Curl{
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

    public static function post($url,  $data = [],$header = ["Content-type:application/json;charset=utf-8", "Accept:application/json"])
    {
        //初始化
        $url = str_replace(' ','+',$url);
        $ch = curl_init();
        //设置桥接(抓包)
        //curl_setopt($ch, CURLOPT_PROXY, '127.0.0.1:8888');
        //设置请求地址
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch,CURLOPT_TIMEOUT,3);
        curl_setopt($ch, CURLOPT_POST, 1);
        //设置请求方法
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        //设置请求头
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        //设置请求数据
        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
        }
        //设置curl_exec()的返回值以字符串返回
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        $res = json_decode($res);
        curl_close($ch); 
        return $res;
    }
}