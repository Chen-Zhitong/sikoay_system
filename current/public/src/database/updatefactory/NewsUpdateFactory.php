<?php
namespace root\database\updatefactory;

//使用composer自动加载器
require 'vendor/autoload.php';

class NewsUpdateFactory extends \root\database\updatefactory\UpdateFactory
{
    /*
     *更新工厂子类
     *子类仅重定义newUpdate()
     */

    function newUpdate( \root\logic\domain\DomainObject $obj)
    {
        $id = $obj->getId();
        $cond = null;
        $values['title'] = $obj->getTitle();
        $values['author'] = $obj->getAuthor();
        $values['content'] = $obj->getContent();
        $values['up_Date'] = $obj->getUpDate();
        $values['image'] = $obj->getImage();
        $values['hits'] = $obj->getHits();
        if($id>-1) {
            $cond['id'] = $id;
        } else {
            $values['type'] = $obj->getType();
            $values['add_Date'] = $obj->getAddDate();
        }
        return $this->buildStatement("news",$values,$cond);
    }
}