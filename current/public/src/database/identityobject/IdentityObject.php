<?php
namespace root\database\identityobject;

//使用composer自动加载器
require 'vendor/autoload.php';

class IdentityObject
{
    /*
     *标识对象类
     *作用在于组装并存储Sql语句
     *子类重定义构造函数中的$enforce
     *可以限制组装sql语句时的字段
     *使用方法:
     *$idobj->field("name")->eq("The Good Show")
            ->field("start")->gt(time()) ->lt(time()+(24*60*60));
     */
    protected $currentfield=null;
    protected $fields = array();
    private $and=null;
    private $enforce=array();

    //标识对象实例化时可以不带参数,也可以以字段名为参数
    function __construct($field=nuill,?array $enforce=null)
    {
        if(! is_null($enforce)){
            $this->enforce = $enforce;
        }
        if(! is_null($field)){
            $this->field($field);
        }
    }

    // 需要的字段名称
    function getObjectFields() : ?array
    {
        return $this->enforce;
    }

    // 使用一个新字段
    // 如果当前字段不完整,将抛出一个错误
    // 例如,age而不是age > 40
    // 本方法返回当前对象的引用
    // 所以我们可以使用流程语法
    function field(string $fieldname) : \root\database\identityobject\IdentityObject
    {
        if(!$this->isVoid() && $this->currentfield->isIncomplete()) {
            throw new \Exception("Incomplete field");
        }
        $this->enforceField($fieldname);
        if(isset($this->fields[$fieldname])){
            $this->currentfield = $this->fields[$fieldname];
        }else{
            $this->currentfield = new \root\database\identityobject\Field($fieldname);
            $this->fields[$fieldname]=$this->currentfield;
        }
        return $this;
    }

    // 标识对象是否已经设置了字段
    function isVoid() : bool
    {
        return empty($this->fields);
    }

    // 传入字段名称是否合法
    function enforceField(string $fieldname) : void
    {
        if(! in_array($fieldname,$this->enforce) &&
           ! empty($this->enforce)) {
            $forcelist = implode(', ',$this->enforce);
            throw new \Exception("{$fieldname} not a legal field ($forcelist)");
        }
    }

    // 给当前字段添加一个相等操作符
    // 例如'age' 变成 age=40
    // 本方法返回当前对象的引用(通过operator())
    function eq(string $value) : \root\database\identityobject\IdentityObject
    {
        return $this->operator( "=" ,$value);
    }

    // 小于
    function lt(string $value) : \root\database\identityobject\IdentityObject
    {
        return $this->operator( "<" ,$value);
    }

    // 大于
    function gt(string $value) : \root\database\identityobject\IdentityObject
    {
        return $this->operator( ">" ,$value);
    }

    // 操作符的方法是否的到了当前字段并添加了操作符和测试值
    private function operator(string $symbol,$value) : \root\database\identityobject\IdentityObject
    {
        if($this->isVoid()){
            throw new \Exception("no object field defined");
        }
        $this->currentfield->addTest($symbol,$value);
        return $this;
    }

    // 以关联数组形式返回目前创建的所有对比
    function getComps() : array
    {
        $ret = array();
        foreach($this->fields as $key => $field){
            $ret = array_merge($ret,$field->getComps());
        }
        return $ret;
    }
}