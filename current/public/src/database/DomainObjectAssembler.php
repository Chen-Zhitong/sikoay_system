<?php
namespace root\database;

//使用composer自动加载器
require 'vendor/autoload.php';

class DomainObjectAssembler
{
    /*
     *领域对象组装器
     *用于缓存和处理数据库连接
     */
    protected static $PDO;
    protected $statements = array(); // 缓存sql语句

    function __construct(\root\database\PersistenceFactory $factory)
    {
        $this->factory = $factory;
        if(!isset(self::$PDO)) {
            $dsn = 'mysql:dbname=huayujy;host=127.0.0.1';
            $user = 'huayujy';
            $password = 'hyjy2017.';

            try {
                self::$PDO = new \PDO($dsn,$user,$password);
            } catch (\PDOException $e) {
                echo 'Connection failed: ' . $e->getMessage();
            }

            self::$PDO->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
        }
    }

    function getStatement(string $str) : \PDOStatement
    {
        if(!isset($this->statements[$str])) {
            $this->statements[$str] = self::$PDO->prepare($str);
        }
        return $this->statements[$str];
    }

    function findOne(\root\database\identityobject\IdentityObject $idobj) : ?\root\logic\domain\DomainObject
    {
        $collection = $this->find($idobj);
        return $collection -> next();
    }

    function find(\root\database\identityobject\IdentityObject $idobj) : \root\database\collection\Collection
    {
        $selfact = $this->factory->getSelectionFactory();
        list($selection,$values) = $selfact-> newSelection($idobj);
        $stmt = $this->getStatement($selection);
        $stmt->execute($values);
        $raw = $stmt->fetchAll();
        return $this->factory->getCollection($raw);
    }

    function insert(\root\logic\domain\DomainObject $obj) : void
    {
        $upfact = $this->factory->getUpdateFactory();
        list($update,$values) = $upfact->newUpdate($obj);
        $stmt = $this->getStatement($update);
        $stmt->execute($values);
        if($obj->getId() < 0) {
            $obj->setId(self::$PDO->lastInsertId());
        }
        $obj->markClean();
    }

    function delete(\root\logic\domain\DomainObject $obj) : void
    {
        $defact = $this->factory->getDeleteFactory();
        list($delete,$values) = $defact->newDelete($obj);
        $stmt = $this->getStatement($delete);
        $stmt->execute($values);
    }
}