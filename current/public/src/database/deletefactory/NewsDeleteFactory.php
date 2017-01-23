<?php
namespace root\database\deletefactory;

//使用composer自动加载器
require 'vendor/autoload.php';

class NewsDeleteFactory extends \root\database\deletefactory\DeleteFactory
{
    /*
     *删除工厂子类
     *子类仅重定义newDelete()
     */

    function newDelete( \root\logic\domain\DomainObject $obj)
    {
        return $this->buildStatement("news",$obj->getId());
    }
}