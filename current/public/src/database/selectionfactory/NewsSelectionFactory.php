<?php
namespace root\database\selectionfactory;

//使用composer自动加载器
require 'vendor/autoload.php';

class NewsSelectionFactory extends \root\database\selectionfactory\SelectionFactory
{
    /*
     *选择工厂
     *作用在于组装sql选择语句
     *子类仅重定义newUpdate()
     *返回一个查询字符串数组以及要使用的值
     *
     *buildWhere()参数为IdentityObject
     *通过IdentityObject::getComps()来获取所需信息
     *用于创建一个WHERE子句并构建一系列值
     *
     */

    function newSelection(\root\database\identityobject\IdentityObject $obj)
    {
        $fields = implode(',',$obj->getObjectFields());
        $core = "SELECT $fields FROM news";
        list ($where,$values) = $this->buildWhere($obj);
        return array($core." ".$where,$values);
    }
}