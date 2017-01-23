<?php
namespace root\database\identityobject;

//使用composer自动加载器
require 'vendor/autoload.php';

class Field
{
    /*
     *接受并保存字段名.
     *通过addTest()方法,创建operator和value的元素数组
     */
    protected $name=null;
    protected $operator=null;
    protected $comps=array();
    protected $incomplete=false;

    // 设置字段名,例如age
    function __construct(string $name)
    {
        $this->name=$name;
    }

    // 添加操作符和值(例如 > 40)到$comps属性中
    function addTest(string $operator,string $value) : void
    {
        $this->comps[] = array('name'=>$this->name,
                               'operator' => $operator,'value'=>$value);
    }

    // comps是一个数组,因此我们有多种方法来检查字段
    function getComps() : array
    {
        return $this->comps;
    }

    // 如果$comps为空,则我们有比较字段并且本字段不能用于数据库查询
    function isIncomplete() : bool
    {
        return empty($this->comps);
    }
}
