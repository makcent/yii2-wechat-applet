<?php

namespace makcent\wechat\applet\helpers;

class Phonenumber extends Instance
{
    /**
     * code换取用户手机号。 每个code只能使用一次，code的有效期为5min
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function getPhoneNumber(string $access_token, array $params) : array
    {
        return $this->request('wxa/business/getuserphonenumbere',[
            'access_token' => $access_token,
        ],$params);
    }
}