<?php
namespace root\database\updatefactory;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class UpdateFactory
{
    /*
     *更新工厂
     *作用在于组装sql更新/插入语句
     *子类仅重定义newUpdate()
     *返回一个查询字符串数组以及要使用的值
     *
     *buildStatemet()参数为表名,包含字段名及其值的数组 以及查询条件关联数组
     *该方法将这三个参数组合起来以创建一个Update/Inser语句
     *
     */

    abstract function newUpdate( \root\logic\domain\DomainObject $obj);

    protected function buildStatement(string $table,array $fields,?array $conditions=null) : array
    {
        $terms = array();
        if(!is_null($conditions)){
            $query  = "UPDATE {$table} SET ";
            $query .= implode(" = ?,", array_keys($fields)). "= ?";
            $terms = array_values($fields);
            $cond = array();
            $query .= " WHERE ";
            foreach($conditions as $key=>$val){
                $cond[]="$key = ?";
                $terms[] = $val;
            }
            $query .= implode(" AND ",$cond);
        } else {
            $query  = "INSERT INTO {$table} (";
            $query .= implode(",",array_keys($fields));
            $query .= ") VALUES (";
            foreach ( $fields as $name => $value) {
                $terms[] = $value;
                $qs[]='?';
            }
            $query .= implode(",",$qs);
            $query .= ")";
        }
        return array($query,$terms);
    }
}