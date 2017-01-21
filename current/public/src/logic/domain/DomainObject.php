<?php
namespace root\logic\domain;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class DomainObject
{
    //领域模型虚基类
    private $id;

    function __construct($id=null)
    {
        $this->id = $id;
    }

    function getId()
    {
        return $this->id;
    }

    function setId($id)
    {
        $this->id = $id;
    }

    static function getCollection($type)
    {
        return \root\logic\domain\HelperFactory::getCollection($type);
        //对于HelperFactory的调用可以用于获得集合或者映射器
    }

    function collection()
    {
        // int preg_match ( string $pattern , string $subject [, array &$matches [, int $flags = 0 [, int $offset = 0 ]]] )
        // 如果提供了参数matches，它将被填充为搜索结果。 $matches[0]将包含完整模式匹配到的文本， $matches[1] 将包含第一个捕获子组匹配到的文本，以此类推。

        $subject = get_class($this);
        $pattern = '/[A-Za-z]+$/';
        preg_match($pattern, $subject, $matches);
        //        throw new \Exception($matches[0]);
        return self::getCollection($matches[0]);
    }

}
?>