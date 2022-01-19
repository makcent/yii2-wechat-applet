<?php

namespace makcent\wechat\applet;

class Wxacode extends Instance
{
    /**
     * 获取小程序码，适用于需要的码数量极多的业务场景
     * @param array $params
     * @return array
     */
    public function getUnlimited(array $params) : array
    {
        return $this->request('wxa/getwxacodeunlimit',['access_token' => self::$ACCESS_TOKEN], json_encode($params,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取小程序码，适用于需要的码数量较少的业务场景
     * @param array $params
     * @return array
     */
    public function get(array $params) : array
    {
        return $this->request('wxa/getwxacode',['access_token' => self::$ACCESS_TOKEN],json_encode($params,JSON_UNESCAPED_UNICODE));
    }

    /**
     * 获取小程序二维码，适用于需要的码数量较少的业务场景
     * @param array $params
     * @return array
     */
    public function createQRCode(array $params) : array
    {
        return $this->request('cgi-bin/wxaapp/createwxaqrcode',['access_token' => self::$ACCESS_TOKEN],json_encode($params,JSON_UNESCAPED_UNICODE));
    }
}