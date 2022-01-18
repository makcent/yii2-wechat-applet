<?php

namespace makcent\wechat\applet;

class SubscribeMessage extends Instance
{
    /**
     * 组合模板并添加至帐号下的个人模板库
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function addTemplate(string $access_token, array $params) : array
    {
        return $this->request('wxaapi/newtmpl/addtemplate',[
            'access_token' => $access_token,
        ],$params);
    }

    /**
     * 删除帐号下的个人模板
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function deleteTemplate(string $access_token, array $params) : array
    {
        return $this->request('wxaapi/newtmpl/deltemplate',[
            'access_token' => $access_token,
        ],$params);
    }

    /**
     * 获取小程序账号的类目
     * @param string $access_token
     * @return array
     */
    public function getCategory(string $access_token) : array
    {
        return $this->request('wxaapi/newtmpl/getcategory',[
            'access_token' => $access_token,
        ]);
    }

    /**
     * 获取模板标题下的关键词列表
     * @param string $access_token
     * @param string $tid
     * @return array
     */
    public function getPubTemplateKeyWordsById(string $access_token, string $tid) : array
    {
        return $this->request('wxaapi/newtmpl/getpubtemplatekeywords',[
            'access_token' => $access_token,
            'tid'          => $tid
        ]);
    }

    /**
     * 获取帐号所属类目下的公共模板标题
     * @param array $params
     * @return array
     */
    public function getPubTemplateTitleList(array $params) : array
    {
        return $this->request('wxaapi/newtmpl/getpubtemplatetitles',$params);
    }

    /**
     * 获取当前帐号下的个人模板列表
     * @param string $access_token
     * @return array
     */
    public function getTemplateList(string $access_token) : array
    {
        return $this->request('wxaapi/newtmpl/gettemplate',[
            'access_token' => $access_token
        ]);
    }

    /**
     * 发送订阅消息
     * @param string $access_token
     * @param array $params
     * @return array
     */
    public function send(string $access_token, array $params):array
    {
        return  $this->request('cgi-bin/message/subscribe/send',[
            'access_token' => $access_token
        ],$params);

    }
}