<?php
namespace root\logic\controller;

//使用composer自动加载器
require 'vendor/autoload.php';

class Request
{
    //这个类的作用为 存储和获取网页传递过来的请求
    //        $vercode = $request -> getProperty('vercode');

    private $properties;    //内容
    private $feedback = array();    //回馈

    function __construct()
    {
        $this -> init();
        \root\logic\base\RequestRegistry::setRequest($this);    //RequestRegisty,请求级别的注册表类
    }

    function init()
    {
        //如果设置了访问页面的请求方法
        if ( isset( $_SERVER['REQUEST_METHOD'])) {
            $this->properties = $_REQUEST;
            return;
        }
        //将键值分解，并调用setProperty存储键值
        foreach( $_SERVER['argv'] as $arg) {
            if ( strpos($arg ,'=')) {
                list ($key,$val) = explode ("=",$arg);
                $val = htmlspecialchars($val); // 转换为html实体
                $this -> setProperty($key,$val);
            }
        }
    }

    function getProperty($key)
    {
        if (isset ( $this->properties[$key])){
            return $this->properties[$key];
        }
    }

    function setProperty($key,$val)
    {
        $this->properties[$key] = $val;
    }

    function addFeedback($msg)
    {
        array_push ($this->feedback,$msg);
    }

    function getFeedback()
    {
        return $this->feedback;
    }

    function getFeedbackString ($separator = "\n")
    {
        return implode($separator, $this->feedback);
    }

    function getCommand()
    {
        if (isset ( $this->properties['Command'])){
            return $this->properties['Command'];
        }
    }

    function setCommand($val)
    {
        $this->properties['Command'] = $val;
    }

    function setLastCommand ($val)
    {
        $this->properties['lastcommand'] = $val;
    }
    function getLastCommand()
    {
        if (isset ( $this->properties['lastcommand'])){
            return $this->properties['lastcommand'];
        }
    }

    function getObject($object)
    {
        if (isset ( $this->properties[$object])){
            return $this->properties[$object];
        }
    }

    function setObject($object,$val)
    {
        $this->properties[$object] = $val;
    }
}
?>
