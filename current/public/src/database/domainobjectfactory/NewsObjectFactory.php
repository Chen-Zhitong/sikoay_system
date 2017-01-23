<?php
namespace root\database\domainobjectfactory;

//使用composer自动加载器
require 'vendor/autoload.php';

class NewsObjectFactory extends \root\database\domainobjectfactory\DomainObjectFactory
{
    function targetClass()
    {
        return "\\root\\logic\\domain\\News";
    }

    protected function doCreateObject (?array $array)
    {
        //创建一个domain对象的实例
        $objstr = $this->targetClass();
        $obj = new $objstr($array['id']);
        $obj -> setTitle($array['title']);
        $obj -> setAuthor($array['author']);
        $obj -> setContent($array['content']);
        $obj -> setImage($array['image']);
        $obj -> setType($array['type']);
        $obj -> setAddDate($array['add_Date']);
        $obj -> setUpDate($array['up_Date']);
        $obj -> setHits($array['hits']);
        return $obj;
    }
}
?>