<?php
namespace root\logic\controller;

//使用composer自动加载器
require 'vendor/autoload.php';

class Controller
{
    //控制器的核心部分

    private $applicationHelper; //应用助手
    private function __construct() {}

    public static function run()
    {
        $instance = new \root\logic\controller\Controller();
        $instance -> init();
        $instance -> handleRequest(); //处理请求
    }

    public function init()
    {
        $applicationHelper = \root\logic\controller\ApplicationHelper::instance();
        $applicationHelper->init();
    }

    public function handleRequest()
    {
        //处理请求的方法
        $request = new \root\logic\controller\Request();
        $app_c = \root\logic\base\ApplicationRegistry::appController();
        while($cmd = $app_c -> getCommand($request)) {
            //重复执行请求直到获取到forward,转向到最后
            $cmd-> execute($request);
        }
        //等Command处理完毕，没有转向之后
        // 调用
        \root\logic\domain\ObjectWatcher::instance() -> performOperations();
        //调用AppController来获取视图
        $this-> invokeView ($app_c -> getView($request));
    }

    function invokeView($target)
    {
        include("src/view/$target.php");
        exit;
    }
}
?>