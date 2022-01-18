<?php

namespace makcent\wechat\applet;

class Auth extends Instance
{
    /**
     * 登录凭证校验
     * @param string $loginCode
     * @return array
     */
    public function code2Session(string  $loginCode): array
    {
        return $this->send('sns/jscode2session',[
            'appid' => $this->appid,
            'secret'=> $this->secret,
            'js_code'=> $loginCode,
            'grant_type'=> 'authorization_code'
        ]);
    }

}