<?php

use app\Common\ExceptionHandle;
use app\Request;

return [
    'think\Request'          => Request::class,
    'think\exception\Handle'  => ExceptionHandle::class,
];