<?php
namespace root\database\collection;

//使用composer自动加载器
require 'vendor/autoload.php';

class NewsCollection extends \root\database\collection\Collection
{
    function targetClass()
    {
        return "\\root\\logic\\domain\\News";
    }
}
?>