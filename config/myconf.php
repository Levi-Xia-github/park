<?php

$remoteRedis = array(
    'ip' => '39.97.184.172',
    'port'   => '6379'
);
$localRedis = array(
    'ip' => '127.0.0.1',
    'port'   => '6379'
);

$localMongoDB = array(
    'ip' => 'localhost',
    'port' => '27017',
);

return [
    'remoteRedis' => $remoteRedis,
    'localRedis' => $localRedis,
    'localMongoDB' => $localMongoDB,
];