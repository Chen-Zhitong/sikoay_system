<?php
namespace root\database\mapper;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class Mapper
{
    //数据映射器的虚基类
    protected static $PDO;

    function __construct()
    {
        //在数据映射器的内部实例化PDO对象
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

    private function getFromMap(?int $id) : ?\root\logic\domain\DomainObject
    {
        //调用ObjectWatcher的便捷语法
        return \root\logic\domain\ObjectWatcher::exists($this->getCollection()->targetClass(),$id);
    }

    private function addToMap(\root\logic\domain\DomainObject $obj) : void
    {
        //调用Objectwatcher的便捷语法
        \root\logic\domain\ObjectWatcher::add($obj);
    }

    function find($id)  : ?\root\logic\domain\DomainObject
    {
        if(!is_numeric($id)) {return null;} // 如果不为数字或数字字符串
        //检查标识映射
        $old = $this->getFromMap($id);
        if($old) {return $old;}
        //数据库操作
        $this->selectStmt()->execute(array($id));
        //fetch()从结果集中获取下一行
        $array = $this->selectStmt()->fetch();
        //closeCursor()关闭游标，使语句能再次被执行
        $this->selectStmt()->closeCursor();
        if(!is_array($array)) {return null;}
        if(!isset($array['id'])) {return null;}
        $object = $this->dofact()->createObject($array);
        return $object;
    }

    function dofact() : \root\database\domainobjectfactory\DomainObjectFactory
    {

        $pattern = '/[A-Za-z]+$/';
        preg_match($pattern, $this->getCollection()->targetClass(), $matches);
        $type = $matches[0];
        return \root\logic\domain\HelperFactory::getDofact($type);
    }

    function insert(\root\logic\domain\DomainObject $obj) : void
    {
        $this->doInsert($obj);
        //用新的id更新insert.$obj
        //添加标记进入标识映射
        $this->addToMap($obj);
    }

    function delete(\root\logic\domain\DomainObject $obj) : void
    {
        // 默认删除为抛出错误
        throw new \Exception('这个对象不允许删除操作');
    }

    function findAll() : \root\database\collection\Collection
    {
        //注意调用类中的getCollection()
        $this->selectAllStmt() ->execute();
        return $this->getCollection($this->selectAllStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }

    function BeginTransaction() : void
    {
        // 开始一个事务
        self::$PDO -> beginTransaction();
    }

    function Commit() : void
    {
        // 提交一个事务
        self::$PDO -> commit();
    }

    function RollBack() : void
    {
        // 回滚一个事务
        self::$PDO -> rollBack();
    }

    abstract function update(\root\logic\domain\DomainObject $object);
    protected abstract function doInsert(\root\logic\domain\DomainObject $object);
    protected abstract function selectStmt();
    protected abstract function getCollection(?array $raw=null);
    protected abstract function selectAllStmt();//用于用的数据的所有行预编译语句
}