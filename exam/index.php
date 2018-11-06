<?php
$page_start_time = microtime(TRUE);
define('APPNAME','exam');
//引入重要的文件
require_once(dirname(__file__)).'/../include/common.inc.php';
require_once(DEDEINC.'/request.class.php');

define('DEDEXAM',dirname(__FILE__));
define('LIB',dirname(__FILE__).'/libraries');

$cfg_basehost = preg_replace("#/$#",'',$cfg_basehost);

require_once(DEDEXAM.'/data/common.inc.php');

//指定了如何请求一个控制器的某个方法
//http://网站/自定义模块/index.php?c=控制器&a=方法
$ct = Request('c', 'test');
$ac = Request('a', 'test');
//统一应用程序入口
RunApp($ct, $ac);