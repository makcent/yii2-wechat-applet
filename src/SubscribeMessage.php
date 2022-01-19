<?php

namespace makcent\wechat\applet;

class SubscribeMessage extends Instance
{
    /**
     * 组合模板并添加至帐号下的个人模板库
     * @param array $params
     * @return array
     */
    public function addTemplate(array $params) : array
    {
        return $this->request('wxaapi/newtmpl/addtemplate',[
            'access_token' => self::$ACCESS_TOKEN,
        ],$params);
    }

    /**
     * 删除帐号下的个人模板
     * @param array $params
     * @return array
     */
    public function deleteTemplate(array $params) : array
    {
        return $this->request('wxaapi/newtmpl/deltemplate',[
            'access_token' => self::$ACCESS_TOKEN,
        ],$params);
    }

    /**
     * 获取小程序账号的类目
     * @return array
     */
    public function getCategory() : array
    {
        return $this->request('wxaapi/newtmpl/getcategory',[
            'access_token' => self::$ACCESS_TOKEN,
        ]);
    }

    /**
     * 获取模板标题下的关键词列表
     * @param string $tid
     * @return array
     */
    public function getPubTemplateKeyWordsById(string $tid) : array
    {
        return $this->request('wxaapi/newtmpl/getpubtemplatekeywords',[
            'access_token' => self::$ACCESS_TOKEN,
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
     * @return array
     */
    public function getTemplateList() : array
    {
        return $this->request('wxaapi/newtmpl/gettemplate',[
            'access_token' => self::$ACCESS_TOKEN
        ]);
    }

    /**
     * 发送订阅消息
     * @param array $params
     * @return array
     */
    public function send(array $params):array
    {
        return  $this->request('cgi-bin/message/subscribe/send',[
            'access_token' => self::$ACCESS_TOKEN
        ],$params);

    }
}