<?php

namespace makcent\wechat\applet;

class Phonenumber extends Instance
{
    /**
     * code换取用户手机号。 每个code只能使用一次，code的有效期为5min
     * @param array $params
     * @return array
     */
    public function getPhoneNumber(sarray $params) : array
    {
        return $this->request('wxa/business/getuserphonenumbere',[
            'access_token' => self::$ACCESS_TOKEN,
        ],$params);
    }
}