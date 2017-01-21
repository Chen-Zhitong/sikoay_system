<?php
namespace root\logic\controller;

//使用composer自动加载器
require 'vendor/autoload.php';

class ControllerMap
{
    //这个类由三个数组封装而成
    private $viewMap = array();//视图
    private $forwardMap = array();//下一个界面到哪儿,转向
    private $classrootMap = array();//命令句柄

    function addClassroot( $command,$classroot)
    {
        $this->classrootMap[$command]=$classroot;
    }

    function getClassroot( $command)
    {
        if(isset($this->classrootMap[$command])){
            return $this->classrootMap[$command];
        }
        return $command;
    }

    function addView($command='default',$status=0,$view)
    {
        $this->viewMap[$command][$status]=$view;
    }

    function getView($command,$status)
    {
        if(isset($this->viewMap[$command][$status])) {
            return $this->viewMap[$command][$status];
        }
        return null;
    }

    function addForward($command,$status=0,$newCommand)
    {
        $this->forwardMap[$command][$status]=$newCommand;
    }

    function getForward($command,$status)
    {
        if(isset($this->forwardMap[$command][$status])) {
            return $this->forwardMap[$command][$status];
        }
        return null;
    }
}
?>