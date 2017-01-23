<?php
namespace root\database\domainobjectfactory;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class DomainObjectFactory
{
    private function getFromMap(?int $id) : ?\root\logic\domain\DomainObject
    {
        //调用ObjectWatcher的便捷语法
        return \root\logic\domain\ObjectWatcher::exists($this->targetClass(),$id);
    }

    private function addToMap(\root\logic\domain\DomainObject $obj) : void
    {
        //调用Objectwatcher的便捷语法
        \root\logic\domain\ObjectWatcher::add($obj);
    }

    function createObject(array $array) : ?\root\logic\domain\DomainObject
    {
        $old = $this->getFromMap($array['id']);
        if($old) {return $old;}
        //创建对象
        $obj=$this->doCreateObject($array);
        $this -> addToMap($obj); // 添加标记进入标识映射
        $obj -> markClean();     // 将对象标记为干净
        return $obj;
    }

    protected abstract function doCreateObject(?array $array);
    abstract function targetClass();
}