<?php

namespace makcent\wechat\applet;

class Shortlink extends Instance
{
    /**
     * 获取小程序 Short Link，适用于微信内拉起小程序的业务场景。目前只开放给电商类目(具体包含以下一级类目：电商平台、商家自营、跨境电商)。
     * 通过该接口，可以选择生成到期失效和永久有效的小程序短链，详见获取 Short Link。
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function generate(string $access_token, array $params):array
    {
        return  $this->request('wxa/genwxashortlink',[
            'access_token' => $access_token
        ],$params);
    }

}