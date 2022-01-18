<?php

namespace makcent\wechat\applet\helpers;

class FormatHelper
{
    /**
     * 格式化响应
     * @param $status
     * @param $message
     * @param array $result
     * @return array
     */
    public static function ret($status, $message, $result = [])
    {
        return [
            'status' => $status,
            'message'=> $message,
            'result' => $result,
        ];
    }

}