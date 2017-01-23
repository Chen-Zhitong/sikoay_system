<?php
namespace root\database\deletefactory;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class DeleteFactory
{
    /*
     *删除工厂
     *作用在于组装sql删除语句
     *子类仅重定义newDelete()
     *返回一个查询字符串数组以及要使用的值
     *
     *buildStatemet()参数为表名,包含字段名及其值的数组 以及查询条件关联数组
     *该方法将这三个参数组合起来以创建一个Delete语句
     *
     */

    abstract function newDelete( \root\logic\domain\DomainObject $obj);

    protected function buildStatement(string $table,int $id) : array
    {
        $terms = array();
        $query  = "DELETE FROM {$table} WHERE";
        $cond = array();
        $query .= " id = ?";
        $terms[] = $id;
        return array($query,$terms);
    }
}