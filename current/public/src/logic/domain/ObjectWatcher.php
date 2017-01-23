<?php
namespace root\logic\domain;

//使用composer自动加载器
require 'vendor/autoload.php';

class ObjectWatcher
{
    /*
      1.这个类叫标识映射，目的在于将对象按引用传递，而不是每个都实例化一个新的对象
      2.工作单元功能,将对象标记为各个状态,然后在控制器类中调用performOperations(),统一进行数据库操作
      3.标记对象的操作再DomainObject及子类中进行
     */
    private $all=array();
    private $dirty=array();
    private $new=array();
    private $delete=array();    // 删除暂未使用
    private static $instance;

    private function __construct() {}

    static function instance() : \root\logic\domain\ObjectWatcher
    {
        if(!self::$instance) {
            self::$instance = new \root\logic\domain\ObjectWatcher();
        }
        return self::$instance;
    }

    function globalKey(\root\logic\domain\DomainObject $obj) : string
    {
        //获取这个对象的全局标识(classname.id)
        $key = get_class($obj).".".$obj->getId();
        return $key;
    }

    static function add(\root\logic\domain\DomainObject $obj) : void
    {
        $inst = self::instance();
        $inst -> all[$inst->globalKey($obj)] = $obj;
    }

    static function exists($classname,$id) : ?\root\logic\domain\DomainObject
    {
        $inst = self::instance();
        $key = "$classname.$id";
        if(isset($inst->all[$key])) {
            return $inst->all[$key];
        }
        return null;
    }

    //工作单元操作 ↓ ↓ ↓ ↓ ↓
    static function addDelete(\root\logic\domain\DomainObject $obj) : void
    {
        $self = self::instance();
        unset($self->all[$self->globalKey($obj)]);
        unset($self->dirty[$self->globalKey($obj)]);
        $self->delete[$self->globalKey($obj)] = $obj;
    }

    static function addDirty(\root\logic\domain\DomainObject $obj) : void
    {


        $inst = self::instance();
        if(!in_array($obj,$inst->new,true)) {
            $inst -> dirty[$inst->globalKey($obj)] = $obj;
        }
    }

    static function addNew(\root\logic\domain\DomainObject $obj) : void
    {
        $inst = self::instance();
        // 此对象没有Id
        $inst -> new[] = $obj;
    }

    static function addClean(\root\logic\domain\DomainObject $obj) : void
    {
        $self = self::instance();
        unset($self->delete[$self->globalKey($obj)]);
        unset($self->dirty[$self->globalKey($obj)]);
        // array_filte:用回调函数过滤数组中的单元
        $self -> new = array_filter($self->new, function ($a) use ($obj) { return !($a===$obj);});
    }

    function performOperations() : void
    {
        foreach($this->dirty as $key =>$obj){
            $obj -> finder() ->insert($obj);
        }
        foreach($this->new as $key=>$obj) {
            $obj -> finder() -> insert($obj);
        }
        foreach($this->delete as $key=>$obj) {
            $obj -> finder() -> delete($obj);
        }

        $this->dirty = array();
        $this->new = array();
        $this->delete = array();
    }
}
?>