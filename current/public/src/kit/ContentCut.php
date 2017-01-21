<?php
namespace root\kit;

//使用composer自动加载器
require 'vendor/autoload.php';

class ContentCut
{
    // 用于各种内容的剪切
    //  echo \root\kit\ContentCut::cut($content,50);

    private function __construct() {}

    static function cut(string $str=null,int $num=30)
    {
        $result = strip_tags($str);
        if(strlen($result) > $num) {
            $result  = substr($result,0,$num).'...';
        }
        return $result;
    }

    static function phoneFormat(string $phone = null )
    {
        if($phone == null) {return null;}
        if(strlen($phone) == 11) {
            $result = substr($phone,0,3).'****'.substr($phone,7,4);
        }
        return $result;
    }

    static function IdentityNumberFormat(string $num = null)
    {
        if($num == null) {return null;}
        if(strlen($num) == 18) {
            $result = substr($num,0,3).'***********'.substr($num,14,4);
        } else if(strlen($num) == 15) {
            $result = substr($num,0,3).'********'.substr($num,11,4);
        }
        return $result;
    }


}