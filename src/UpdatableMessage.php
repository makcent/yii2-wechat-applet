<?php

namespace makcent\wechat\applet;

class UpdatableMessage extends Instance
{
    /**
     * 创建被分享动态消息或私密消息的 activity_id
     * @param string $access_token
     * @param string $unionid
     * @return array
     */
    public function createActivityId(string $access_token, string $unionid) : array
    {
        return $this->request('cgi-bin/message/wxopen/activityid/create',[
            'access_token' => $access_token,
            'unionid'      => $unionid,
        ]);
    }


    /**
     * 修改被分享的动态消息。
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function setUpdatableMsg(string $access_token, array $params) : array
    {
        return $this->request('cgi-bin/message/wxopen/updatablemsg/send',[
            'access_token' => $access_token
        ],$params);
    }

}