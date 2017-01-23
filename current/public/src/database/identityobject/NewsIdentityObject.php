<?php
namespace root\database\identityobject;

//使用composer自动加载器
require 'vendor/autoload.php';

class NewsIdentityObject extends \root\database\identityobject\IdentityObject
{
    /*
     *标识对象类
     *子类重定义构造函数中的$enforce
     *可以限制组装sql语句时的字段
     *使用方法:
     *$idobj->field("name")->eq("The Good Show")
            ->field("start")->gt(time()) ->lt(time()+(24*60*60));
     */
    function __construct($field=null)
    {
        parent::__construct($field,
                            array('id','title','author','add_Date','up_Date','content','image','type','hits'));
    }
}