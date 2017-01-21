<?php
namespace root\logic\base;

//使用composer自动加载器
require 'vendor/autoload.php';

class RequestRegistry extends Registry
{
    //注册表的派生类
    //这个类为请求注册表类
    // \root\logic\base\RequestRegistry::getRequest();



    private $values = array();
    private static $instance;

    //不允许实例化这个类
    private function __construct() {}

    public static function instance()
    {
        //单例模式
        if ( ! isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    protected function get($key)
    {
        if (isset($this->values[$key])) {
            return $this ->values[$key];
        }
        return null;
    }

    protected function set($key,$val)
    {
        $this -> values[$key] = $val;
    }

    public static function getRequest()
    {
        return self::instance() -> get('request');
    }

    public static function setRequest( \root\logic\controller\Request $request)
    {
        return self::instance() -> set('request',$request);
    }

    public static function getTotal() : int
    {
        if(!self::instance() -> get('total')){
            self::setTotal(0);
        }
        return self::instance() -> get('total');
    }

    public static function setTotal( int $total)
    {
        return self::instance() -> set('total',$total);
    }

    public static function getErrorMsg() : string
    {
        if(!self::instance() -> get('errormsg')){
            self::setErrorMsg('');
        }
        return self::instance() -> get('errormsg');
    }

    public static function setErrorMsg( string $error)
    {
        return self::instance() -> set('errormsg',$error);
    }

    public static function getDataExport() : string
    {
        if(!self::instance() -> get('dataexport')){
            self::setDataExport('');
        }
        return self::instance() -> get('dataexport');
    }

    public static function setDataExport( string $data)
    {
        return self::instance() -> set('dataexport',$data);
    }

    public static function getCenterNav() : string
    {
        if(!self::instance() -> get('centerNav')){
            self::setCenterNav('平台公告');
        }
        return self::instance() -> get('centerNav');
    }

    public static function setCenterNav( string $nav)
    {
        assert(in_array($nav,array('平台公告','我的收藏','订单记录','我的财富','我要兼职','添加家庭成员','个人中心','安全中心','绑定手机','订阅邮件')),'CenterNav设置错误');
        return self::instance() -> set('centerNav',$nav);
    }


}
?>