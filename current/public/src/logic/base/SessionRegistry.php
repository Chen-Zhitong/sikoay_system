<?php
namespace root\logic\base;

//使用composer自动加载器
require 'vendor/autoload.php';

class SessionRegistry extends Registry
{
    //注册表类的派生类
    //会话级别的注册表只使用PHP内置的会话支持

    private static $instance;

    //不允许实例化这个类,并且开始一个会话
    private function __construct()
    {
        session_start();
    }

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
        if(isset($_SESSION[__CLASS__][$key])) {
            return $_SESSION[__CLASS__][$key];
        }
        return null;
    }

    protected function set($key,$val)
    {
        $_SESSION[__CLASS__][$key] = $val;
    }

    public function setComplex(Conmplex $complex)
    {
        self::instance()->set('complex',$complex);
    }

    public function getComplex()
    {
        return self::instance() -> get('complex');
    }

    public static function setVerNumber(array $num)
    {
        self::instance() -> set('VerNumber',$num);
    }

    public static function getVerNumber()
    {
        return self::instance() -> get('VerNumber');
    }

    public static function setVerErrorTotal(int $num)
    {
        self::instance() -> set('VerErrorTotal',$num);
    }

    public static function getVerErrorTotal()
    {
        if(self::instance() -> get('VerErrorTotal')==null){
            self::instance() -> set('VerErrorTotal',0);
        }
        return self::instance() -> get('VerErrorTotal');
    }

    public static function setChangeAccount(string $num)
    {
        self::instance() -> set('ChangeAccount',$num);
    }

    public static function getChangeAccount()
    {
        return self::instance() -> get('ChangeAccount');
    }

    public static function setErrorMsg(string $str)
    {
        self::instance() -> set('ErrorMsg',$str);
    }

    public static function getErrorMsg()
    {
        return self::instance() -> get('ErrorMsg');
    }

    public static function setUserAccount(\root\logic\domain\UserAccount $user=null)
    {
        self::instance() -> set('UserAccount',$user);
    }

    public static function getUserAccount()
    {
        return self::instance() -> get('UserAccount');
    }

    public static function setAdmin( \root\logic\domain\Admin $admin=null)
    {
        self::instance() -> set('admin',$admin);
    }

    public static function getAdmin()
    {
        return self::instance() -> get('admin');
    }

    public static function setAdminNav(array $nav)
    {
        self::instance() -> set('adminNav',$nav);
    }

    public static function getAdminNav()
    {
        return self::instance() -> get('adminNav');
    }

    public static function setMainNav(string $nav)
    {
        self::instance() -> set('mainNav',$nav);
    }

    public static function getMainNav()
    {
        return self::instance() -> get('mainNav');
    }

    public static function setArticleId(int $id)
    {
        self::instance() -> set('articleId',$id);
    }

    public static function getArticleId()
    {
        return self::instance() -> get('articleId');
    }

    public static function setHearthTestId(int $id)
    {
        self::instance() -> set('HearthTestId',$id);
    }

    public static function getHearthTestId()
    {
        return self::instance() -> get('HearthTestId');
    }

    public static function setHearthTestQuestionId(int $id)
    {
        self::instance() -> set('HearthTestQuestionId',$id);
    }

    public static function getHearthTestQuestionId()
    {
        return self::instance() -> get('HearthTestQuestionId');
    }

    public static function setHearthTestQuestionType(string $type)
    {
        self::instance() -> set('HearthTestQuestionType',$type);
    }

    public static function getHearthTestQuestionType()
    {
        return self::instance() -> get('HearthTestQuestionType');
    }

    public static function setHearthTestAnswerId(int $id)
    {
        self::instance() -> set('HearthTestAnswerId',$id);
    }

    public static function getHearthTestAnswerId()
    {
        return self::instance() -> get('HearthTestAnswerId');
    }

    public static function getNewsBrowsingHistory()
    {
        return self::instance() -> get('newsBrowsingHistory');
    }

    public static function setNewsBrowsingHistory(array $bh)
    {
        self::instance() -> set('newsBrowsingHistory',$bh);
    }


    public static function setNoticeId(string $id)
    {
        self::instance() -> set('noticeId',$id);
    }

    public static function getNoticeId() : string
    {
        return self::instance() -> get('noticeId');
    }

    public static function setServeProvince(string $province=null)
    {
        self::instance() -> set('province',$province);
    }

    public static function getServeProvince()
    {
        return self::instance() -> get('province');
    }

    public static function setServeType(string $type=null)
    {
        self::instance() -> set('type',$type);
    }

    public static function getServeType()
    {
        return self::instance() -> get('type');
    }

    public static function setServePriceDuration(array $priceDuration=null)
    {
        self::instance() -> set('priceDuration',$priceDuration);
    }

    public static function getServePriceDuration()
    {
        return self::instance() -> get('priceDuration');
    }

    public static function setServeTotal(int $total=null)
    {
        self::instance() -> set('total',$total);
    }

    public static function getServeTotal()
    {
        return self::instance() -> get('total');
    }

}
?>