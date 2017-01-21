<?php
namespace root\kit;
use Intervention\Image\ImageManagerStatic as Image;
//使用composer自动加载器
require 'vendor/autoload.php';

class VerifyImage
{
    private function __construct() {}
    private static $str;
    public static function createVerImage() : array
    {
        self::$str = self::makeStr(); // 保存随机生成字符串

        // 用Intervention\Image生成验证码图片
        $manager = new \Intervention\Image\ImageManager(array('driver' => 'imagick'));

        $img = Image::cache(function($image) {
            $image->make('html_src/cache/foo.jpg')->resize(100, 42);
            $image->text(self::$str,50,10,function($font) {
                $font->file('./html_src/cache/ttf/segoesc.ttf');
                $font->size(30);
                $font->color('#'.rand(155555,599999));
                $font->align('center');
                $font->valign('top');
            });
            for($i=0;$i<10; $i++ ){
                $image->line(rand(0,40), rand(25,100), rand(0,200), rand(0,10), function ($draw) {
                    $draw->color('#'.rand(100000,999999));
                });
            }
            for($i=0;$i<450; $i++ ){
                $image->pixel('#'.rand(100000,999999), rand(0,100), rand(0,50));
            }

        }, 10,false);

        return array($img,self::$str); // 返回为$img[0]图片流,$img[1]验证字符串
    }

    private static function makeStr() : string
    {
        // 这个函数生成验证字符串
        $length = 4;            // 字符数量
        $str="ABCDEFGHIJKLMNOPQRSTUVWXYZ";

        $result="";

        for($i=0;$i<$length;$i++){
            $num[$i]=rand(0,25);
            $result .= $str[$num[$i]];
        }

        return $result;
    }
}
?>