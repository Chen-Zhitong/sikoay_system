<?php
namespace root\logic\domain;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class DomainObject
{
    /*
      领域模型虚基类
      1.finder() 返回对应Mapper对象
      2.collection() 返回对应collection对象
      3.添加工作单元模式,与ObjectWatcher类配合
     */
    private $id = -1;

    function __construct(?int $id)
    {
        if(is_null($id)){
            $this -> markNew();
        } else {
            $this->id = $id;
        }
    }

    function markNew() : void
    {
        \root\logic\domain\ObjectWatcher::addNew($this);
    }

    function markDeleted() : void
    {
        \root\logic\domain\ObjectWatcher::addDelete($this);
    }

    function markDirty() : void
    {
        \root\logic\domain\ObjectWatcher::addDirty($this);
    }

    function markClean() : void
    {
        \root\logic\domain\ObjectWatcher::addClean($this);
    }

    function getId() : int
    {
        return $this->id;
    }

    function setId($id) : void
    {
        $this->id = $id;
    }

    function finder() : \root\database\DomainObjectAssembler
    {
        $subject = get_class($this);
        $pattern = '/[A-Za-z]+$/';
        preg_match($pattern, $subject, $matches);
        return self::getFinder($matches[0]);
    }

    static function getFinder(string $type) : \root\database\DomainObjectAssembler
    {
        return \root\logic\domain\HelperFactory::getFinder($type);
    }

    function collection() : \root\database\collection\Collection
    {
        $subject = get_class($this);
        $pattern = '/[A-Za-z]+$/';
        preg_match($pattern, $subject, $matches);
        return self::getCollection($matches[0]);
    }

    static function getCollection(string $type) : \root\database\collection\Collection
    {
        return \root\logic\domain\HelperFactory::getCollection($type);
        //对于HelperFactory的调用可以用于获得集合或者映射器
    }

}
?>