<?php

namespace makcent\wechat\applet\helpers;

use makcent\wechat\applet\helpers\FormatHelper;

class RequestHelper
{
    /**
     * 单个请求
     * @param $url
     * @param $params
     * @headers $headers
     * @return mixed
     */
    public static function curl($url, $params = array(),$headers = false)
    {
        return static::mutil(array(array( 'url' => $url, 'params' => $params)), $headers)[0];
    }

    /**
     * 下载流媒体文件
     * @param $url
     * @param $filename
     * @return void
     */
    public static function curlStreamFile($url,$filename)
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
    public static function mutil($request,$headers = false)
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
                if (curl_errno($done['handle'])) {
                    $res = FormatHelper::ret(1,'curl错误:' . curl_error($done['handle']));
                } else {
                    if (200 !== curl_getinfo($done['handle'], CURLINFO_HTTP_CODE)) {
                        $res = FormatHelper::ret(1,'curl错误:' . curl_error($done['handle']));
                    }else{
                        $res = curl_multi_getcontent($done['handle']);

                        if ($headers) {
                            $header_size = curl_getinfo($done['handle'],CURLINFO_HEADER_SIZE);
                            $header_info = substr($res,0,$header_size);
                            $res = substr($res,$header_size);
                        }

                        $json = @json_decode($res, true);
                        $result = is_array($json) ? $json : $res;
                        $res = FormatHelper::ret(0,'获取成功',$headers ? array(
                            'headers' => $header_info,
                            'content' => $result
                        ) : $result) ;
                    }
                }
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