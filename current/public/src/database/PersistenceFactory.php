<?php
namespace root\database;

//使用composer自动加载器
require 'vendor/autoload.php';

class PersistenceFactory
{
    /*
     *固定工厂
     *负责连接数据库执行查询
     *负责管理SelectionFactory和UpdateFactory对象
     *当执行SELECT查询时,他也使用Collection类,或者直接使用DomainObjectFactory
     */
    private $type;
    private $identityObj;
    private $dofact;
    private $collection;
    private $selectionfactory;
    private $updatefactory;

    function __construct(string $type)
    {
        $this->type =$type;
    }

    function getFinder() : \root\database\DomainObjectAssembler
    {
        return new \root\database\DomainObjectAssembler($this);
    }

    function getIdentityObj() : \root\database\identityobject\IdentityObject
    {
        if(!isset($this->identityObj)){
            $identityObjname = "\\root\\database\\identityobject\\{$this->type}IdentityObject";
            $this->identityObj = new $identityObjname();
        }
        return $this->identityObj;
    }

    function getDofact() : \root\database\domainobjectfactory\DomainObjectFactory
    {
        if(!isset($this->dofact)){
            $this->dofact = \root\logic\domain\HelperFactory::getDofact($this->type);
        }
        return $this->dofact;
    }

    function getCollection(array $raw) : \root\database\collection\Collection
    {
        if(!isset($this->collection)){
            $this->collection = \root\logic\domain\HelperFactory::getCollection($this->type,$raw);
        }
        return $this->collection;
    }

    function getSelectionFactory() : \root\database\selectionfactory\SelectionFactory
    {
        if(!isset($this->selectionfactory)){
            $selectionfactoryname = "\\root\\database\\selectionfactory\\{$this->type}SelectionFactory";
            $this->selectionfactory = new $selectionfactoryname();
        }
        return $this->selectionfactory;
    }

    function getUpdateFactory() : \root\database\updatefactory\UpdateFactory
    {
        if(!isset($this->updatefactory)){
            $updatefactoryname = "\\root\\database\\updatefactory\\{$this->type}UpdateFactory";
            $this->updatefactory = new $updatefactoryname();
        }
        return $this->updatefactory;
    }

    function getDeleteFactory() : \root\database\deletefactory\DeleteFactory
    {
        if(!isset($this->deletefactory)){
            $deletefactoryname = "\\root\\database\\deletefactory\\{$this->type}DeleteFactory";
            $this->deletefactory = new $deletefactoryname();
        }
        return $this->deletefactory;
    }
}