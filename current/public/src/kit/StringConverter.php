<?php
namespace root\kit;

//使用composer自动加载器
require 'vendor/autoload.php';

class StringConverter
{
    //   echo \root\kit\StringConverter::exportLevelStr($detailsObj->getLevel());
    private static $NEWSSTR = array("hearthLife"=>"健康生活方式","hearthFood" => "食疗养生中心","hearthManage"=>"健康管理中心","doctorGuidance"=>"临床营养指导中心","tumourCure"=>"肿瘤防治中心","hearthMentality"=>"心理健康咨询中心","womanGuidance"=>"妇幼健康指导中心");
    private static $VERIFICATIONSTR = array("pass"=>"已审核","not_audit" => "未提交审核","in_review"=>"正在审核","not_pass"=>"未通过审核");
    private static $LEVELSTR = array("common" => "普通会员","expert" => "高级会员","super"=>"超级会员");
    private static $SERVERLEVELSTR = array("common" => "普通服务商","expert" => "高级服务商","super"=>"超级服务商");
    private static $SEXSTR = array("M" => "男","W" => "女");
    private static $WEEKSTR = array("周日"=>'Sun',"周一" => "Mon","周二" =>"Tue",'周三' => "Wed","周四" => 'Thu','周五' => 'Fri','周六' => 'Sat',"Sun"=>'周日',"Mon" => "周一","Tue" =>"周二",'Wed' => "周三","Thu" => '周四','Fri' => '周五','Sat' => '周六');
    private static $INDENTSTR = array("non_payment" => "等待付款","payment" => "等待服务","confirmServe"=>"服务完成","completeServe" => "等待评价","completed" => "已完成订单","refund" => "退款审核中..","completeRefund" => "完成退款","complain"=>"投诉处理中","complainOver"=>"投诉已处理","close"=>"交易关闭");
    private static $SERVETYPE = array("shop"=>"到店服务","home"=>"上门服务","phone"=>'电话服务',"on_line"=>"在线服务");
    private static $SERVESTATUS = array("not_audit"=>"未审核","in_review"=>"正在审核","not_pass"=>'未通过审核',"shelves"=>"上架中","sold_out" => "已下架","delete"=>"已删除");
    private static $PAYMENTMETHODSTR = array("alipay"=>"支付宝支付","wxpay"=>"微信支付","balance"=>'余额支付');
    private static $JOURNALTYPESTR = array("top_up"=>"账户充值","drawings"=>"提款","expense"=>'消费',"income"=>'收入');

    private function __construct() {}

    static function exportNewsStr(String $str)
    {
        // 验证类别
        if($str==null) {return null;}
        return self::$NEWSSTR[$str];
    }
    static function exportVerificationStr(String $str)
    {
        // 验证类别
        if($str==null) {return null;}
        return self::$VERIFICATIONSTR[$str];
    }

    static function exportLevelStr(String $str)
    {
        // 等级类别
        if($str==null) {return null;}
        return self::$LEVELSTR[$str];
    }
    static function exportServerLevelStr(String $str)
    {
        // 等级类别
        if($str==null) {return null;}
        return self::$SERVERLEVELSTR[$str];
    }
    static function exportSexStr($str)
    {
        // 性别类别
        if($str==null) {return null;}
        return self::$SEXSTR[$str];
    }

    static function exportWeekStr($str)
    {
        // 周末中文转英文类别
        if($str==null) {return null;}
        return self::$WEEKSTR[$str];
    }

    static function exportIndentStatusStr($str)
    {
        // 订单状态转换
        if($str==null) {return null;}
        return self::$INDENTSTR[$str];
    }

    static function exportServeTypeStr($str)
    {
        if($str==null) {return null;}
        return self::$SERVETYPE[$str];
    }

    static function exportServeStatusStr($str)
    {
        if($str==null) {return null;}
        return self::$SERVESTATUS[$str];
    }

    static function exportPaymentMethodStr(String $str)
    {
        // 验证类别
        if($str==null) {return null;}
        return self::$PAYMENTMETHODSTR[$str];
    }

    static function exportJournalTypeStr(String $str)
    {
        // 验证类别
        if($str==null) {return null;}
        return self::$JOURNALTYPESTR[$str];
    }
}