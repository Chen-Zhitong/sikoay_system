<?php
namespace root\logic\controller;

//使用composer自动加载器
require 'vendor/autoload.php';

class ApplicationHelper
{
    //这个类的作用是读取配置文件中的数据并使客户端代码可以访问这些数据。

    private static $instance;
    private $config = "src/logic/controller/root_options.xml";

    private function __construct() {}

    public static function instance()
    {
        if (! self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function init()
    {
        $dsn = \root\logic\base\ApplicationRegistry::getControllerMap();
        //如果dsn为null则调用getOptions缓存值
        if (!is_null($dsn)) {
            return;
        }
        $this -> getOptions();
    }

    private function getOptions()
    {
        $this -> ensure(file_exists($this->config),"Could not find options file");

        $options = @SimpleXml_load_file( $this->config );


        print get_class($options);

        //  设置 ControllaerMap
        $map = new \ root\logic\controller\ControllerMap();

        //设置默认视图
        foreach ($options->view as $default_view) {
            //消除两边空格
            $stat_str = trim($default_view['status']);
            //将状态字符转化为状态数
            $status = \root\logic\command\Command::statuses($stat_str);

            //将命令与状态视图绑定
            $map -> addView('DefaultCommand',$status,(string)$default_view);
        }
        //  设置其他值

        //设置 命令->转向 或 命令->视图  命令->状态->视图  命令->状态->转向
        foreach($options->command as $command) {

            var_dump((string)$command['name']);

            if($command->classroot){
                print($command->classroot['name']);
                $map -> addClassroot((string)$command['name'],(string)$command->classroot['name']);
            }
            if($command->view){
                $map -> addView((string)$command['name'],0,(string)$command->view);
            }
            if($command->forward){
                $map -> addForward((string)$command['name'],0,(string)$command->forward);
            }
            if($command->status){
                foreach($command->status as $status){
                    //消除两边空格
                    $stat_str = trim($status['value']);
                    //将状态字符转化为状态数
                    $stat = \root\logic\command\Command::statuses($stat_str);
                    if($status->view){
                        $map -> addView((string)$command['name'],$stat,(string)$status->view);}
                    if($status->forward){
                        $map -> addForward((string)$command['name'],$stat,(string)$status->forward);
                    }
                }
            }
        }

        \root\logic\base\ApplicationRegistry::setControllerMap($map);
    }

    private function ensure($expr,$message)
    {
        if(!$expr) {
            throw new \root\logic\base\AppException($message);
        }
    }
}
?>