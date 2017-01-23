<?php
namespace root\database\mapper;

//使用composer自动加载器
require 'vendor/autoload.php';

class NewsMapper extends \root\database\mapper\Mapper
{
    private $selectByTypeStmt;
    private $deleteStmt;
    private $selectByTypeLimitStmt;
    private $addHitByIdStmt;
    private $recommendNewsStmt;

    function __construct()
    {
        parent::__construct();
        //prepare() 预编译mysql语句
        $this->selectStmt = self::$PDO->prepare("SELECT * FROM news WHERE id = ?");
        $this->selectAllStmt = self::$PDO->prepare("SELECT * FROM news");
        $this->updateStmt = self::$PDO->prepare("UPDATE news SET title = ? , author = ? , content = ? , up_Date = ? , image = ? WHERE id=?");
        $this->insertStmt = self::$PDO -> prepare("INSERT INTO news ( id,title,author,content,add_Date,up_Date,image,type,hits ) VALUES ( null,?,?,?,?,?,?,?,0 )");
        $this->selectByTypeStmt = self::$PDO->prepare("SELECT * FROM news WHERE type=? ORDER BY up_date DESC");
        $this->deleteStmt = self::$PDO->prepare("DELETE FROM news WHERE id = ? ");
        $this->selectByTypeLimitStmt = self::$PDO->prepare("SELECT * FROM news WHERE type = :type ORDER BY up_date DESC LIMIT :limitmin,:limitmax ");
        $this->addHitByIdStmt = self::$PDO->prepare('UPDATE news SET hits = hits + 1 WHERE id = :id; ');
        $this->prevDataStmt = self::$PDO->prepare('SELECT * FROM news WHERE type = :type and id < :id ORDER BY id DESC LIMIT 0,1');
        $this->nextDataStmt = self::$PDO->prepare('SELECT * FROM news WHERE type = :type and id > :id ORDER BY id LIMIT 0,1');
    }


    function getCollection(?array $raw=null) : \root\database\collection\Collection
    {
        //获取场所对象的集合
        return new \root\database\collection\NewsCollection($raw,null);
    }

    protected function doCreateObject (?array $array)
    {
        //创建一个domain对象的实例
        $obj = new \root\logic\domain\News($array['id']);
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

    protected function doInsert(\root\logic\domain\DomainObject $object) : void
    {
        // print "inserting\n";
        //debug_print_backtrace — 打印一条回溯。
        // debug_print_backtrace();
        $date = date("Y-m-d H:i:s");
        $values = array($object->getTitle(),$object->getAuthor(),$object->getContent(),$date,$date,$object->getImage(),$object->getType());
        $this->insertStmt->execute($values);
        //PDO::lastInsertId — 返回最后插入行的ID或序列值
        $id = self::$PDO -> lastInsertId();
        $object->setId($id);
    }

    function update(\root\logic\domain\DomainObject $object) : void
    {
        $values = array ($object->getTitle(),$object->getAuthor(),$object->getContent(),date("Y-m-d H:i:s"),$object->getImage(),$object->getId());
        $this -> updateStmt-> execute($values);
    }

    function delete(\root\logic\domain\DomainObject $object) : void
    {
        $values = array ($object->getId());
        $this -> deleteStmt-> execute($values);
    }

    function selectByType($type)
    {
        $this-> selectByTypeStmt -> execute (array($type));
        return $this->getCollection($this-> selectByTypeStmt ->fetchAll(\PDO::FETCH_ASSOC));
    }

    function selectByTypeLimit($type,$limitmin=0,$limitmax=6)
    {
        $this-> selectByTypeLimitStmt -> bindParam(':type',$type, \PDO::PARAM_STR);
        $this-> selectByTypeLimitStmt -> bindParam(':limitmin',$limitmin, \PDO::PARAM_INT);
        $this-> selectByTypeLimitStmt -> bindParam(':limitmax',$limitmax, \PDO::PARAM_INT);
        $this-> selectByTypeLimitStmt -> execute();
        return $this->getCollection($this-> selectByTypeLimitStmt ->fetchAll(\PDO::FETCH_ASSOC));
    }

    function addHitById($id)
    {
        $this-> addHitByIdStmt -> bindParam(':id',$id, \PDO::PARAM_INT);
        $this-> addHitByIdStmt -> execute();
    }

    function prevData($type,$id)
    {
        $this-> prevDataStmt -> bindParam(':type',$type, \PDO::PARAM_STR);
        $this-> prevDataStmt -> bindParam(':id',$id, \PDO::PARAM_INT);
        $this -> prevDataStmt ->execute();
        $array = $this -> prevDataStmt ->fetch();
        $this-> prevDataStmt ->closeCursor();
        if(!$array) {return null;}
        return self::createObject($array);
    }

    function nextData($type,$id)
    {
        $this-> nextDataStmt -> bindParam(':type',$type, \PDO::PARAM_STR);
        $this-> nextDataStmt -> bindParam(':id',$id, \PDO::PARAM_INT);
        $this -> nextDataStmt ->execute();
        $array = $this -> nextDataStmt ->fetch();
        $this-> nextDataStmt ->closeCursor();
        if(!$array) {return null;}
        return self::createObject($array);
    }

    function selectStmt()
    {
        return $this->selectStmt;
    }

    function selectAllStmt()
    {
        return $this->selectAllStmt;
    }

}
?>