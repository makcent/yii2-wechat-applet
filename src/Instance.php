<?php
namespace makcent\wechat\applet;

use yii\base\Component;
use makcent\wechat\applet\helpers\RequestHelper;

class Instance extends Component
{
    public $appid = 'appid';
    public $secret= 'secret';

    /**
     * 组装请求参数
     * @param string $url
     * @param array $params
     * @return string
     */
    protected function getRequestUrl(string $url, array $params = []): string
    {
        return "https://api.weixin.qq.com/{$url}?".http_build_query($params);
    }

    /**
     * 获取access_token
     * @return array
     */
    public function getAccessToken()
    {
        return $this->send('cgi-bin/token',[
            'grant_type' => 'client_credential',
            'appid'      => $this->appid,
            'secret'     => $this->secret
        ]);
    }

    /**
     * 发送请求
     * @param string $url
     * @param array $query
     * @param array $params
     * @param boolean $encode
     * @return array
     */
    protected function send(string $url, array $query = [], array $params = [], boolean $encode = false) : array
    {
        return RequestHelper::curl(
            static::getRequestPathByName($url,$query),
            $encode ? $params : json_encode($params)
        );
    }

    /**
     * 获取操作对象
     * @param string $classname
     * @return mixed
     */
    public function query(string $classname)
    {
        $classname = "\\makcent\wechat\\applet\\".ucfirst($classname);
        return new $classname([
            'appid' => $this->appid,
            'secret'=> $this->secret,
        ]);
    }
}