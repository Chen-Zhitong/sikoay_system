<?php
namespace root\logic\command;

//使用composer自动加载器
require 'vendor/autoload.php';

class CommandResolver
{
    //这个类用于查找请求中包含的cmd参数
    //假设参数被找到，并与命令目录中的类文件所匹配
    //而且文件中包含了cmd类，则该方法返回相应类的实例
    private static $base_cmd;
    private static $default_cmd;

    function __construct()
    {
        if (!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass("\\root\\logic\\command\\Command");
            self::$default_cmd = new \root\logic\command\DefaultCommand();
        }
    }

    function getCommand( \root\logic\controller\Request $request)
    {
        //获取命令请求内容
        $cmd = $request->getProperty('cmd');
        $sep = DIRECTORY_SEPARATOR;
        //如果命令请求内容为空，则调用默认的命令行
        if(! $cmd) {
            return self::$default_cmd;
        }
        $cmd = str_replace( array('.',$sep),"",$cmd); //用 空 替换命令行中的分隔符号和.
        $filepath = "src{$sep}logic{$sep}command{$sep}{$cmd}.php"; //command文件路径
        $classname = "root\\logic\\command\\{$cmd}"; //command类名
        if (file_exists($filepath)) {
            @require_once("$filepath");
            if ( class_exists($classname)) {
                $cmd_class = new ReflectionClass($classname);
                if ($cmd_class -> isSubClassOf( self::$base_cmd)) {
                    return $cmd_class->newInstance();
                } else {
                    $request->addFeedback("command '$cmd' is not a Command");
                }
            }
        }

        $request->addFeedback("command '$cmd' not found");
        return clone self::$default_cmd;
    }
}
?>
