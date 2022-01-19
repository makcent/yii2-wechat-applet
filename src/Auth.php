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
        return $this->request('sns/jscode2session',[
            'appid' => $this->appid,
            'secret'=> $this->secret,
            'js_code'=> $loginCode,
            'grant_type'=> 'authorization_code'
        ]);
    }

    /**
     * 检查加密信息是否由微信生成（当前只支持手机号加密数据）
     * @param array $params
     * @return array
     */
    public function checkEncryptedData(array $params) : array
    {
        return $this->request('wxa/business/checkencryptedmsg',['access_token' => self::$ACCESS_TOKEN], $params);
    }

    /**
     * 用户支付完成后，获取该用户的 UnionId，无需用户授权
     * @param string $openid
     * @return array
     */
    public function getPaidUnionId(string $openid) : array
    {
        return $this->request('wxa/getpaidunionid',[
            'access_token' => self::$ACCESS_TOKEN,
            'openid'       => $openid,
        ]);
    }

    /**
     * 通过 wx.pluginLogin 接口获得插件用户标志凭证 code 后传到开发者服务器，
     * 开发者服务器调用此接口换取插件用户的唯一标识 openpid。
     * @param array $params
     * @return array
     */
    public function getPluginOpenPId(array $params) : array
    {
        return $this->request('wxa/getpluginopenpid',[
            'access_token' => self::$ACCESS_TOKEN,
            'openid'       => $openid,
        ],$params);
    }

    /**
     * 获取access_token
     * @return array
     */
    public function getAccessToken()
    {
        return $this->request('cgi-bin/token',[
            'grant_type' => 'client_credential',
            'appid'      => $this->appid,
            'secret'     => $this->secret
        ]);
    }
}