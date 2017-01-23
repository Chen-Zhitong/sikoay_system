<?php
namespace root\logic\domain;

//使用composer自动加载器
require 'vendor/autoload.php';

class News extends \root\logic\domain\DomainObject
{
    private $title;
    private $author;
    private $content;
    private $addDate;
    private $upDate;
    private $image;
    private $type;
    private $hits = 0;

    function __construct($id=null,$title=null,$author=null,$content=null,$image=null,$type='notice',$addDate=null,$upDate=null,$hits=0)
    {
        $this -> title = $title;
        $this -> author = $author;
        $this -> content = $content;
        $this -> image = $image;
        assert(in_array($type,array("notice","news","activity")),'新闻类型错误');
        $this -> type = $type;
        $this -> hits = $hits;
        $this -> addDate = $addDate;
        $this -> upDate = $upDate;
        parent::__construct($id);
    }

    function getTitle()
    {
        return $this->title;
    }

    function setTitle($title)
    {
        $this->title = $title;
        $this->markDirty();
    }

    function getAuthor()
    {
        return $this->author;
    }

    function setAuthor($author)
    {
        $this->author = $author;
        $this->markDirty();
    }

    function getContent()
    {
        return $this->content;
    }

    function setContent($content)
    {
        $this->content = $content;
        $this->markDirty();
    }

    function getImage()
    {
        return $this->image;
    }

    function setImage($image)
    {
        $this->image = $image;
        $this->markDirty();
    }

    function getType()
    {
        return $this->type;
    }

    function setType($type)
    {
        assert(in_array($type,array("notice","news","activity")),'新闻类型错误');
        $this->type = $type;
        $this->markDirty();
    }

    function getAddDate()
    {
        return $this->addDate;
    }

    function setAddDate($addDate)
    {
        $this->addDate = $addDate;
        $this->markDirty();
    }

    function getUpDate()
    {
        return $this->upDate;
    }

    function setUpDate($upDate)
    {
        $this->upDate = $upDate;
        $this->markDirty();
    }

    function getHits()
    {
        return $this->hits;
    }

    function setHits($hits)
    {
        $this->hits = $hits;
        $this->markDirty();
    }

    function getTypeStr()
    {
        return $this->TYPESTR[$this->getType()];
    }
}


?>