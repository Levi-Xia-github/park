<?php


namespace app\controller;


use app\Base\BaseAction;
use app\Service\Common\PicServerSerice;
use app\Utils\MongoDB;

class PicServer extends BaseAction
{
    public function index()
    {

        $_servicePicServer = new PicServerSerice();

        $imgfile = $_FILES['imgfile'];
        $submitbtn = $_POST['submitbtn'];
//        if ($submitbtn == ’OK’ and is_array($imgfile)) {
            $name = $imgfile['name'];  //取得图片名称
            $type = $imgfile['type']; //取得图片类型
            $size = $imgfile['size'];  //取得图片长度
            $tmpfile = $imgfile['tmp_name'];  //图片上传上来到临时文件的路径

            if ($tmpfile and is_uploaded_file($tmpfile)) {  //判断上传文件是否为空，文件是不是上传的文件
                //读取图片流
                $file = fopen($tmpfile, "rb");
                $imgdata = "0x" . bin2hex(fread($file, $size));  //bin2hex()将二进制数据转换成十六进制表示
                fclose($file);

                $mg = new MongoDB();
                 $db = mg::i();
                 $collname = "pic";
                $rows = [
                    [
                        'name' => $name,
                        'type' => $type,
                        'imgdata' => $imgdata,
                        'fkey' => 'xadasdasdfqfqf',
                    ],
                ];
                $rs = $db->insert($collname, $rows);
            }
        }
//    }
}