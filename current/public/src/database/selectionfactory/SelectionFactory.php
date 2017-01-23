<?php
namespace root\database\selectionfactory;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class SelectionFactory
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
     *不论是创建WHERE子句还是构建值,都返回一个包含两个元素的数组
     *
     */

    abstract function newSelection(\root\database\identityobject\IdentityObject $obj);

    function buildWhere(\root\database\identityobject\IdentityObject $obj) : array
    {
        if($obj->isVoid()) {
            return array("",array());
        }
        $compstrings = array();
        $values = array();
        foreach($obj->getComps() as $comp){
            $compstrings[] = "{$comp['name']} {$comp['operator']} ?";
            $values[] = $comp['value'];
        }
        $where = "WHERE " . implode(" AND",$compstrings);
        return array($where,$values);
    }
}