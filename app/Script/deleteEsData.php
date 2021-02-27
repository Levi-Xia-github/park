<?php


//ES的处理脚本


require "../../vendor/autoload.php";

$es = \Elasticsearch\ClientBuilder::create()->setHosts(['127.0.0.1:9200'])->build();

//删除数据
function delete(){
    $ids = [100000010];
    foreach ($ids as $id){
        $params = [
            'index' => 'park',
            'type' => '_doc',
            'id' => $id
        ];
        $response = $es->delete($params);
    }
}
delete();

