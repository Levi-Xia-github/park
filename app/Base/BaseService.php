<?php

namespace app\Base;

class BaseService
{
    public function success($data)
    {
        $output = [];
        $output['errCode'] = 0;
        $output['errMsg'] = 'ok';
        $output['data'] = $data;
        return json($output);
    }
}