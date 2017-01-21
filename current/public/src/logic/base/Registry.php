<?php
namespace root\logic\base;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class Registry
{
    //Registry ------ 注册表类的基类
    //拥有两个抽象方法 get() 和 set() 用于获取的设置注册表类

    abstract protected function get($key);
    abstract protected function set($key,$val);
}
?>