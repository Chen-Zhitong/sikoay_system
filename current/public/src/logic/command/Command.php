<?php
namespace root\logic\command;

//使用composer自动加载器
require 'vendor/autoload.php';

abstract class Command
{
    //现在你只需要注意doExecute()方法返回一个状态标志
    //而抽象基类Command将状态标志保存在属性中
    //命令对象被调用并且设置了状态后，系统应该如何响应？
    //这完全有配置文件决定。
    //根据之前的XML文件，如果返回CMD_OK，转向机制会促使类被实例化。
    //通过这种方式，当请求包含cmd=AddVenue时，整个事件链会被触发。
    //如果请求包含了cmd=QuickAddVeue，则转向不会发生，而是直接显示quickaddvenue视图

    private static $STATUS_STRINGS = array (
        // ststem
        'CMD_DEFAULT' => 0,
        'CMD_OK' => 1,
        'CMD_ERROR' => 2,
        'CMD_INSUFFICIENT_DATA' => 3,
        'CMD_EXIST' => 4,
        'CMD_NULL' => 5,
        'CMD_NOT_LOGIN' => 6,
        'CMD_DATAEXPORT'=>27,
        //center
        'Center' => 7,
        'Client' => 8,
        'Company' => 9,
        'Server' => 10,
        'Notice' => 11,
        'OrderList' => 12,
        'ServeList' => 13,
        'EditServeList' => 23,
        'InsertServe' => 24,
        'EditServe' => 25,
        'Collect' => 14,
        'Money' => 15,
        'PartTimeJob' => 16,
        'MyFamily' => 17,
        'Info' => 18,
        'InfoUpdate' => 19,
        'VerificationInfo' => 20,
        'VerificationInfoOk'=>21,
        'VerificationInfoUpdate' => 22 ,
        'IndentDetails' => 32,
        'ComplainSubmit' => 33,
        'ComplainVerifi' => 34,
        'ComplainComplete' => 35,
        'CommentSubmit' => 36,
        'BindPhone' => 39,
        'EmailSubscription' => 40,
        'EmailUpdate' => 41,
        'ChangePassword' => 42,
        'verifiphonecode' => 43,
        'resetpassword' => 44,
        'forgetpasswordok' => 45,
        'ServeRecord' => 46,
        'ServeCancelList' => 48,
        'ComplainClientSubmit' => 49,
        'ComplainClientVerifi' => 50,
        'ComplainClientComplete' => 51,
        'Schedule' => 52,
        'ArticleList' => 53,
        'ArticleInsert' => 55,
        'ArticleEdit' => 56,
        // main
        'details' => 28,
        'shoppingcart' => 29,
        'singleorderconfirm' => 30,
        'confirmpayment' => 31,
        'topupconfirm' => 37,
        'topupconfirmpayment' => 38,
        'insert' => 47,
        'alipayreturn' =>57,
        //admin
        'ManageDetails' => 60,
        'ManageUpdateStatus' => 61,

    );
    private $status = 0;
    //final 使得其子类无法覆盖这个方法
    final function __construct() {}

    function execute( \root\logic\controller\Request $request )
    {
        //实际的command子类实现doExecute
        //子类的doExcute返回一个状态标志
        $this->status = $this->doExecute($request);
        $request -> setLastCommand($this);
    }

    function getStatus()
    {
        return $this->status;
    }

    static function statuses($str = 'CMD_DEFAULT')
    {
        if(empty($str)) {$str ="CMD_DEFAULT";}
        //将字符串转化为状态数
        return self::$STATUS_STRINGS[$str];
    }

    abstract function doExecute( \root\logic\controller\Request $request );
}
?>