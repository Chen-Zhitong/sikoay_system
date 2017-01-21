<?php
namespace root\logic\base;

//使用composer自动加载器
require 'vendor/autoload.php';

class ApplicationRegistry extends Registry
{
    //注册表类的派生类
    //应用级别的注册表类
    //这个类使用序列化来存储和获取每个属性的值。

    private static $instance;
    private $freezedir = "data";
    private $values = array();
    private $mtimes = array();

    private function __construct() {}

    public static function instance()
    {
        //单例模式
        if(!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key)
    {
        //从已经参数化的文件中读取
        $path = $this -> freezedir . DIRECTORY_SEPARATOR . $key;
        if (file_exists($path)) {
            clearstatcache();     //清除文件状态缓存
            $mtime = filemtime($path);
            if( !isset($this->mtime[$key])) {
                $this->mtimes[$key] = 0;
            }
            if ( $mtime > $this->mtimes[$key]) {
                //file_get_contents()将整个文件读入一个字符串
                $data = file_get_contents($path);
                $this -> mtimes[$key]=$mtime;
                //unserialize() 对单一的已序列化的变量进行操作，
                //将其转换回 PHP 的值。
                return ($this->values[$key]=unserialize($data));
            }
        }
        if (isset($this->values[$key])) {
            return $this->values[$key];
        }
        return null;
    }

    protected function set($key,$val) {
        $this -> values[$key] = $val;
        $path = $this->freezedir . DIRECTORY_SEPARATOR . $key;
        //file_put_contents将一个字符串写入文件
        file_put_contents( $path, serialize($val));
        $this->mtimes[$key] = time();
    }

    public static function getControllerMap()
    {
        return self::instance() -> get('ControllerMap');
    }

    public static function setControllerMap($map)
    {
        return self::instance() -> set('ControllerMap',$map);
    }

    public static function appController()
    {

        $appMap = self::getControllerMap();
        return new \root\logic\controller\AppController($appMap);
    }
}
?>