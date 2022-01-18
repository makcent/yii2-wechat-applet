<?php

namespace makcent\wechat\applet;

class Redpacketcover extends Instance
{
    /**
     * 本接口用于获得指定用户可以领取的红包封面链接。获取参数ctoken参考微信红包封面开放平台
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function createActivityId(string $access_token, array $params) : array
    {
        return $this->request('redpacketcover/wxapp/cover_url/get_by_tokene',[
            'access_token' => $access_token,
        ],$params);
    }

}