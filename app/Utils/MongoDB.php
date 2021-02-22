<?php


namespace app\Utils;
//示例化方式
// $db = Common_MongoDB::i();         // 使用配置self::$_config[self::$def]
// $collname = "record";
class  MongoDB{
 //--------------  定义变量  --------------//
 private static $ins = [];
 private static $def = "default";
 private $_conn = null;
 private $_db = null;
 private static $_config = [
     "default" => [
         "url" => "mongodb://127.0.0.1:27017", 
         "dbname" => "pic"
        ],
 ];

 /**
  * 创建实例
  * @param string $confkey
  * @return \mongodb
  */
 static function i($confkey = NULL)
 {
     if (!$confkey) {
         $confkey = self::$def;
     }
     if (!isset(self::$ins[$confkey]) && ($conf = self::$_config[$confkey])) {
         $m = new MongoDB($conf);
         self::$ins[$confkey] = $m;
     }
     return self::$ins[$confkey];
 }


 /**
  * 构造方法
  * 单例模式
  */
 private function __construct(array $conf)
 {
     $this->_conn = new MongoDB\Driver\Manager($conf["url"] . "/{$conf["dbname"]}");
     $this->_db = $conf["dbname"];
 }


 /**
  * 插入数据
  * @param string $collname
  * @param array $documents [["name"=>"values", ...], ...]
  * @param array $writeOps ["ordered"=>boolean,"writeConcern"=>array]
  * @return \MongoDB\Driver\Cursor
  */
 function insert($collname, array $documents, array $writeOps = [])
 {
     $cmd = [
         "insert" => $collname,
         "documents" => $documents,
     ];
     $cmd += $writeOps;
     return $this->command($cmd);
 }


 /**
  * 删除数据
  * @param string $collname
  * @param array $deletes [["q"=>query,"limit"=>int], ...]
  * @param array $writeOps ["ordered"=>boolean,"writeConcern"=>array]
  * @return \MongoDB\Driver\Cursor
  */
 function del($collname, array $deletes, array $writeOps = [])
 {
     foreach ($deletes as &$_) {
         if (isset($_["q"]) && !$_["q"]) {
             $_["q"] = (object)[];
         }
         if (isset($_["limit"]) && !$_["limit"]) {
             $_["limit"] = 0;
         }
     }
     $cmd = [
         "delete" => $collname,
         "deletes" => $deletes,
     ];
     $cmd += $writeOps;
     return $this->command($cmd);
 }


 /**
  * 更新数据
  * @param string $collname
  * @param array $updates [["q"=>query,"u"=>update,"upsert"=>boolean,"multi"=>boolean], ...]
  * @param array $writeOps ["ordered"=>boolean,"writeConcern"=>array]
  * @return \MongoDB\Driver\Cursor
  */
 function update($collname, array $updates, array $writeOps = [])
 {
     $cmd = [
         "update" => $collname,
         "updates" => $updates,
     ];
     $cmd += $writeOps;
     return $this->command($cmd);
 }


 /**
  * 查询
  * @param string $collname
  * @param array $filter [query]     参数详情请参见文档。
  * @return \MongoDB\Driver\Cursor
  */
 function query($collname, array $filter, array $writeOps = [])
 {
     $cmd = [
         "find" => $collname,
         "filter" => $filter
     ];
     $cmd += $writeOps;
     return $this->command($cmd);
 }


 /**
  * 执行MongoDB命令
  * @param array $param
  * @return \MongoDB\Driver\Cursor
  */
 function command(array $param)
 {
     $cmd = new MongoDB\Driver\Command($param);
     return $this->_conn->executeCommand($this->_db, $cmd);
 }


 /**
  * 获取当前mongoDB Manager
  * @return MongoDB\Driver\Manager
  */
 function getMongoManager()
 {
     return $this->_conn;
 }
}

/*
调用示例
$rows = [
   ["chatId" => "123_456","sendUserId"=>123,"receiverUserId"=>456,"msg" => "这是第一条消息123->456","type" =>"normal", "time" => time()],
   ["chatId" => "123_456","sendUserId"=>123,"receiverUserId"=>456,"msg" => "这是第二条消息123->456","type" =>"normal", "time" => time()],
   ["chatId" => "123_456","sendUserId"=>123,"receiverUserId"=>456,"msg" => "这是第三条消息123->456","type" =>"normal", "time" => time()],
   ["chatId" => "456_123","sendUserId"=>456,"receiverUserId"=>123,"msg" => "这是第一条消息456->123","type" =>"normal", "time" => time()],
   ["chatId" => "456_123","sendUserId"=>456,"receiverUserId"=>123,"msg" => "这是第二条消息456->123","type" =>"normal", "time" => time()],
   ["chatId" => "456_123","sendUserId"=>456,"receiverUserId"=>123,"msg" => "这是第三条消息456->123","type" =>"normal", "time" => time()],
];
$rs = $db->insert($collname, $rows);
print_r($rs->toArray());

$filter = [
   'chatId' => [
       '$eq' => '123_456'
   ],
];
$queryWriteOps = [
   "projection" => ["_id"   => 0],
   "sort"       => ["time" => -1],
];
$rs = $db->query($collname, $filter, $queryWriteOps);
print_r($rs->toArray());
$filter = [
   'chatId' => [ '$eq' => '123_456' ],
];
$queryWriteOps = [
   "projection" => ["_id"   => 0],
   "sort"       => ["time" => -1],
];
$hs = $db->query($collname, $filter, $queryWriteOps);
$hs_array = $hs->toArray();

print_r(json_decode(json_encode($hs_array),true));

*/