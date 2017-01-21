<?php
namespace root\logic\command;

//使用composer自动加载器
require 'vendor/autoload.php';

class DefaultCommand extends \root\logic\command\Command
{
    //Command 子类
    //具体的command子类实现doExecute()，返回状态，由基类处理
    function doExecute( \root\logic\controller\Request $request )
    {
        $request -> addFeedback("Welcome to root");
        //返回状态
        return self::statuses('CMD_DEFAULT');
    }
}
?>
