<?php
namespace root\logic\controller;

//使用composer自动加载器
require 'vendor/autoload.php';

class AppController
{
    /**
     *这个类的作用为解析ControllerMap
     *并根据Command来转向或者分发视图等
     */
    private static $base_cmd;
    private static $default_cmd;
    private $controllerMap;
    private $invoked = array();    //调用记录

    function __construct(\root\logic\controller\ControllerMap $map)
    {
        $this->controllerMap = $map;
        if (!self::$base_cmd) {
            self::$base_cmd = new \ReflectionClass("\\root\\logic\\command\\Command");
            self::$default_cmd = new \root\logic\command\DefaultCommand();
        }
    }

    function getView(\root\logic\controller\Request $req)
    {
        $view = $this->getResource($req,"View");
        return $view;
    }

    function getForward(\root\logic\controller\Request $req)
    {
        $forward = $this->getResource($req,"Forward");
        if($forward) {
            $req->setProperty('cmd',$forward);
        }
        return $forward;
    }

    private function getResource(\root\logic\controller\Request $req,$res)
    {
        //getResource执行查找操作，用于转向或选择视图（getForward()和getView()）
        //会优先找具体命令字符串和状态标志组合，然后才搜索通用的组合
        //得到前一个命令及其执行状态
        $cmd_str = $req->getProperty('cmd');
        $previous = $req->getLastCommand();
        $status = $previous->getStatus();
        if(! $status) {$status = 0;}
        $acquire = "get$res";
        //得到一个命令的资源及其状态
        //$acquire是一个组合字符串是'getView'or'getForward'
        //如果是getForward就是获取当前命令中的转向，和之前的执行状态
        //根据配置文件中匹配的状态和命令来转向
        $resource = $this->controllerMap->$acquire($cmd_str,$status);

        //查找命令并且状态为0的资源
        if(!$resource) {
            $resource = $this->controllerMap->$acquire($cmd_str,0);
        }
        //或者'default'命令和命令状态
        if(!$resource) {
            $resource = $this->controllerMap->$acquire('DefaultCommand',$status);
        }
        //其他情况获取'default'失败，状态为0
        if(!$resource){
            $resource = $this->controllerMap->$acquire('DefaultCommand',0);
        }
        return $resource;
    }

    function getCommand(\root\logic\controller\Request $req)
    {
        //getCommand()负责返回转向中需要使用的所有命令
        //工作流程是这样：
        //当请求第一次被接受到，就会生成一个Cmd属性
        //本次请求之前没有任何command执行过
        //request对象存储着这个过程相关的信息。
        //如果cmd没有被赋值，则类方法使用默认值，并返回默认command类
        //$cmd字符串变量被传递给resolveCommand()，该方法用于得到一个command对象
        //当请求第二次调用getCommand()方法时，Request对象将持有一个对之前执行过的command对象的引用
        //这时getCommand()将根据该命令和状态标志盘对是否需要转向（转向通过getForward()实现）
        //如果getForward()方法找到一个匹配的对象，会返回一个字符串。
        //该字符串可解析成一个命令对象并供控制器使用
        //getCommand()中另需要注意的一点就是通过盘对来避免死循环
        //在添加元素时，如果该元素已经存在，那么该命令已经被获取过，就必须抛出异常
        $previous= $req->getLastCommand();
        if(!$previous) {
            //这是本次请求的第一个命令

            $cmd = $req->getProperty('cmd');
            if(!$cmd) {
                //如果无法得到命令，那么使用默认命令
                $req->setProperty('cmd','DefaultCommand');
                return self::$default_cmd;
            }
        } else {
            //之前已经执行过一个命令了
            //查看是否需要转向
            //如果不需要直接返回null

            //调用getForward处理转向
            $cmd = $this->getForward($req);
            if(!$cmd) {return null;}
        }

        //如果得到命令则解析命令
        //在cmd变量中保存着命令名称，并将其解析为Command对象
        $cmd_obj = $this->resolveCommand($cmd);
        if( !$cmd_obj){
            throw new \root\logic\base\AppException("couldn`t resolve '$cmd' ");
        }

        $cmd_class = get_class($cmd_obj);
        if(isset($this->invoked[$cmd_class])) {
            //getCommand()中另需要注意的一点就是通过盘对来避免死循环
            //在添加元素时，如果该元素已经存在，那么该命令已经被获取过，就必须抛出异常
            throw new \root\logic\base\AppException("circular forwarding");
        }

        $this->invoked[$cmd_class] = 1;
        //返回command对象
        return $cmd_obj;
    }

    function resolveCommand($cmd)
    {
        //用于得到一个command对象
        $classroot = $this-> controllerMap -> getClassroot ($cmd);
        $filepath = "src/logic/command/{$classroot}.php";
        $classname = "\\root\\logic\\command\\{$classroot}";
        if (file_exists($filepath)) {
            require_once($filepath);
            if (class_exists($classname)) {
                $cmd_class = new \ReflectionClass($classname);
                if($cmd_class->isSubClassOf(self::$base_cmd)) {
                    return $cmd_class->newInstance();
                }
            }
        }
        return null;
    }
}
?>