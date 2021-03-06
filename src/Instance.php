<?php
namespace makcent\wechat\applet;

use yii\base\BaseObject;
use yii\base\UnknownClassException;

class Instance extends BaseObject
{
    public $appid = 'appid';
    public $secret= 'secret';
    public static $ACCESS_TOKEN = '';

    /**
     * 组装请求参数
     * @param string $url
     * @param array $params
     * @return string
     */
    private function getRequestUrl(string $url, array $params = []): string
    {
        return "https://api.weixin.qq.com/{$url}?".http_build_query($params);
    }

    /**
     * 设置access_token
     * @param $access_token
     * @return $this
     */
    public function setAccessToken($access_token)
    {
        self::$ACCESS_TOKEN = $access_token;
        return $this;
    }

    /**
     * 发送请求
     * @param string $url
     * @param array $query
     * @param array $params
     * @param string $header
     * @return array
     */
    protected function request(string $url, array $query = [], array $params = [], string $header = '') : array
    {
        return $this->curl($this->getRequestUrl($url,$query), $params, $header);
    }

    /**
     * 实例化操作对象
     * @param $object
     * @return BaseObject
     * @throws UnknownClassException
     */
    public function __get($object) : BaseObject
    {
        $classname = "\\makcent\wechat\\applet\\".ucfirst($object);
        if (!class_exists($classname)) {
            throw new UnknownClassException("Unable to find '$className'. Namespace missing?");
        }

        return new $classname([
            'appid' => $this->appid,
            'secret'=> $this->secret,
        ]);
    }

    /**
     * 单个请求
     * @param $url
     * @param $params
     * @headers $headers
     * @return mixed
     */
    private function curl($url, $params = array(),$headers = false)
    {
        return $this->mutil(array(array( 'url' => $url, 'params' => $params)), $headers)[0];
    }

    /**
     * 下载流媒体文件
     * @param $url
     * @param $filename
     * @return void
     */
    protected function curlStreamFile($url,$filename)
    {
        set_time_limit(0);
        $urlHandle = fopen($url,"rb");
        $fileHandle = fopen($filename,"wb");
        while(! feof($urlHandle)) {
            fwrite($fileHandle, fread($urlHandle, 1024*8), 1024*8);
        }
        fclose($urlHandle);
        fclose($fileHandle);
    }

    /**
     * 批量爬虫
     * @param $request
     * @return mixed
     */
    private function mutil($request,$headers = false)
    {
        $curl_mutil = array();
        foreach ($request as $key => $param) {
            $curl_mutil[$key] = curl_init();
            curl_setopt($curl_mutil[$key], CURLOPT_URL, $param['url']);
            curl_setopt($curl_mutil[$key], CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl_mutil[$key], CURLOPT_CONNECTTIMEOUT, 5);
            curl_setopt($curl_mutil[$key], CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($curl_mutil[$key], CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($curl_mutil[$key], CURLOPT_TIMEOUT, 30);
            if($headers) curl_setopt($curl_mutil[$key],CURLOPT_HEADER,true);
            if (isset($param['params']) && !empty($param['params'])) {
                curl_setopt($curl_mutil[$key], CURLOPT_POST, 1);
                curl_setopt($curl_mutil[$key], CURLOPT_POSTFIELDS, $param['params']);
            }
        }

        //添加批量资源
        $mutil_init = curl_multi_init();
        foreach ($curl_mutil as $key => $curl){
            curl_multi_add_handle($mutil_init, $curl);
        }

        //关联资源ID
        foreach ($curl_mutil as $key => $value) {
            $curl_mutil[(int)$value] = $key;
        }

        $active = null;
        do {
            while(($mrc = curl_multi_exec($mutil_init,$active)) == CURLM_CALL_MULTI_PERFORM);
            if($mrc != CURLM_OK){
                break;
            }
            while ($done = curl_multi_info_read($mutil_init)) {
                $res = curl_multi_getcontent($done['handle']);
                if ($headers) {
                    $header_size = curl_getinfo($done['handle'],CURLINFO_HEADER_SIZE);
                    $header_info = substr($res,0,$header_size);
                    $res = substr($res,$header_size);
                }
                $json = @json_decode($res, true);
                $result = is_array($json) ? $json : $res;
                $res = ($headers ? array('headers' => $header_info, 'content' => $result) : $result);
                curl_multi_remove_handle($mutil_init, $done['handle']);
                curl_close($done['handle']);
                $request[$curl_mutil[(int)$done['handle']]] = $res;
            }

            if ($active > 0) {
                curl_multi_select($mutil_init);
            }
        }while($active);

        curl_multi_close($mutil_init);

        return $request;
    }
}