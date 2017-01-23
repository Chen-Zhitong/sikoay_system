<?php
//使用composer自动加载器
require 'vendor/autoload.php';

class NewsTest extends PHPUnit_Framework_TestCase
{
    public function testObject()
    {
        //        debug_print_backtrace();
        //$faker = \Faker\Factory::create();
        //$news = new \root\logic\domain\News(null,$faker->title,$faker->name,$faker->text,$faker->image,'notice');
        $factory = new \root\database\PersistenceFactory('News');

        //testinset
        $news = new \root\logic\domain\News(null,'title','name','text','image','notice',date("Y-m-d H:i:s"),date("Y-m-d H:i:s"));
        $this->assertInstanceOf('\root\database\DomainObjectAssembler',$news->finder());
        \root\logic\domain\ObjectWatcher::instance() -> performOperations();
        $this->assertTrue($news->getId() > -1,'news对象插入错误'); // 原始id为-1

        // testfind
        $idobj = $factory -> getIdentityObj() -> field('id') -> eq($news->getId());
        $this->assertEquals($news->finder()->find($idobj)->getTotal(),1,'news对象查找错误');

        //testUpdate And findOne
        $time = time();
        $news -> setTitle($time);
        \root\logic\domain\ObjectWatcher::instance() -> performOperations();
        $this->assertEquals($news->finder()->findOne($idobj)->getTitle(),$time,'news对象更新错误');

        // testDelete
        $news -> markDeleted();
        \root\logic\domain\ObjectWatcher::instance() -> performOperations();
        $this->assertEquals($news->finder()->find($idobj)->getTotal(),0,'news对象查找错误');
    }
}
?>
