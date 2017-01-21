<?php
namespace root\database\collection;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class Collection implements \Iterator
{
    //collection 集合类，用于查找多行信息，虚基类
    //这是一个迭代器类

    //实现了Iterator接口，其中封装了一个数组
    //Iterator接口定义的方法
    //rewind() 指向列表开头处
    //current() 返回当前指针处的元素
    //key() 返回当前的键
    //next() 返回当前指向的元素，并将指针向前移动一步
    //valid() 确定当前指针处有一个元素

    //调用方法
    //$collection = \root\logic\domain\HelperFactory::getCollection("News");
    //$collection -> add (new \root\logic\domain\News(1));
    //$collection -> add (new \root\logic\domain\News(2));
    //$collection -> add (new \root\logic\domain\News(3));

    //需要在每个领域类提供一个特定的实现
    protected $mapper;
    protected $total = 0;
    protected $raw = array();

    private $result;
    private $pointer = 0;
    private $objects = array();

    function __construct(array $raw = null,\root\database\mapper\Mapper $mapper=null)
    {
        //调用构造方法时可以不使用参数，也可以使用两个参数（最终被转化为一组对象的原始数据和一个映射器的引用）
        //如果没有传递参数给构造方法，那么类的数据为空，但可以使用add()方法添加数据到集合中
        if(!is_null($raw) && !is_null($mapper)) {
            $this->raw = $raw;
            $this->total = count($raw);
        }
        $this->mapper =$mapper;
    }

    function add (\root\logic\domain\DomainObject $object)
    {
        $class = $this->targetClass();
        if(!($object instanceof $class)) {
            //确认输入对象是否和目标对象的类相同
            throw new Exception("This is a {$class} collection");
        }
        $this->notifyAccess();
        $this->objects[$this->total] = $object;
        $this->total++;
    }

    abstract function targetClass();

    protected function notifyAccess()
    {
        //通知， 使用 存取 接近
        //暂时留空
        //在延迟加载模式中
    }

    private function getRow($num)
    {
        //类中有两个数组：$objects和$raw.
        //如果客户需要一个特定的元素，getRow()方法先在$objects中查找是否被实例化，如果是返回它
        //否则，getRow()方法在$raw中查找原始数据。
        //只有Mapper对象存在时,才会显示$raw数据，所以相应的行数可以传递给之前遇到的Mapper::createobject()方法
        //它返回一个缓存在$objects数组中具有相应索引的DomainObject对象.最新创建的DomainObject对象被返回给用户
        $this->notifyAccess();
        if ($num >= $this->total || $num < 0) {
            return null;
        }
        if(isset($this->objects[$num])) {
            return $this->objects[$num];
        }
        if(isset($this->raw[$num])) {
            $this -> objects[$num] = $this->mapper->createObject($this->raw[$num]);
            return $this->objects[$num];
        }
    }

    public function rewind()
    {
        $this->pointer=0;
    }

    public function current()
    {
        //将获取数据对象的职责委托给getRow完成
        return $this->getRow($this->pointer);
    }

    public function key()
    {
        return $this->pointer;
    }

    public function next()
    {
        $row = $this->getRow($this->pointer);
        if($row) {$this->pointer++;}
        return $row;
    }

    public function valid()
    {
        return(!is_null($this->current()));
    }

    public function getTotal()
    {
        $this->notifyAccess();
        return $this->total;
    }
}
?>