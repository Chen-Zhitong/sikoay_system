<?php
namespace root\logic\domain;

//使用composer自动加载器
require 'vendor/autoload.php';

class HelperFactory
{
    private static $instance;

    private function __construct() {}

    public static function getCollection($type)
    {
        //用于获取不同类型的collection
        //获取对应的Mapper传递给collection，再返回collection
        $mappername = "\\root\\database\\mapper\\{$type}Mapper";
        $mapper = new $mappername;
        $collectionName = "\\root\\database\\collection\\{$type}Collection";
        return new $collectionName(null,$mapper);
    }

    public static function getMapper($type)
    {
        //用于获取不同类型的collection
        //获取对应的Mapper传递给collection，再返回collection
        $mappername = "\\root\\database\\mapper\\{$type}Mapper";
        return new $mappername();
    }
}
?>
