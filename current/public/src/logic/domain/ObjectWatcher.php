<?php
namespace root\logic\domain;

//使用composer自动加载器
require 'vendor/autoload.php';

class ObjectWatcher
{
    //这个类叫标识映射，目的在于将对象按引用传递，而不是每个都实例化一个新的对象
    private $all=array();
    private static $instance;

    private function __construct() {}

    static function instance()
    {
        if(!self::$instance) {
            self::$instance = new ObjectWatcher();
        }
        return self::$instance;
    }

    function globalKey(\root\logic\domain\DomainObject $obj)
    {
        //获取这个对象的全局标识
        $key = get_class($obj).".".$obj->getId();
        return $key;
    }

    static function add(\root\logic\domain\DomainObject $obj)
    {
        $inst = self::instance();
        $inst -> all[$inst->globalKey($obj)] = $obj;
    }

    static function exists($classname,$id)
    {
        $inst = self::instance();
        $key = "$classname.$id";
        if(isset($inst->all[$key])) {
            return $inst->all[$key];
        }
        return null;
    }
}
?>