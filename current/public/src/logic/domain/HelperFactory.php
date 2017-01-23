<?php
namespace root\logic\domain;

//使用composer自动加载器
require 'vendor/autoload.php';

class HelperFactory
{
    private static $instance;

    private function __construct() {}

    public static function getCollection(string $type,array $raw) : \root\database\collection\Collection
    {
        $dofact = self::getDofact($type);
        $collectionName = "\\root\\database\\collection\\{$type}Collection";
        return new $collectionName($raw,$dofact);
    }

    public static function getFinder(string $type) : \root\database\DomainObjectAssembler
    {
        $PersistenceFactory = new \root\database\PersistenceFactory($type);
        return $PersistenceFactory->getFinder();
    }

    public static function getDofact(string $type) : \root\database\domainobjectfactory\DomainObjectFactory
    {
        $dofactname = "\\root\\database\\domainobjectfactory\\{$type}ObjectFactory";
        return new $dofactname();
    }

}
?>
