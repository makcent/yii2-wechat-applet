<?php

namespace makcent\wechat\applet;

class UpdatableMessage extends Instance
{
    /**
     * 创建被分享动态消息或私密消息的 activity_id
     * @param string $unionid
     * @return array
     */
    public function createActivityId(string $unionid) : array
    {
        return $this->request('cgi-bin/message/wxopen/activityid/create',[
            'access_token' => self::$ACCESS_TOKEN,
            'unionid'      => $unionid,
        ]);
    }


    /**
     * 修改被分享的动态消息。
     * @param array $params
     * @return array
     */
    public function setUpdatableMsg(array $params) : array
    {
        return $this->request('cgi-bin/message/wxopen/updatablemsg/send',[
            'access_token' => self::$ACCESS_TOKEN
        ],$params);
    }

}