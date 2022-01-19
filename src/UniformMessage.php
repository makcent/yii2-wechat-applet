<?php
namespace makcent\wechat\applet;

class UniformMessage extends Instance
{
    /**
     * 下发小程序和公众号统一的服务消息
     * @param array $params
     * @return array
     */
    public function send(array $params) : array
    {
        return $this->request('cgi-bin/message/wxopen/template/uniform_send',[
            'access_token' => self::$ACCESS_TOKEN
        ],$params);
    }
}
