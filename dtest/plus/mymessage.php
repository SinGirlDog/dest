<?php
require_once(dirname(__FILE__)."/../include/common.inc.php");
if(empty($dopost)) $dopost = '';
 
if($dopost=='save' || true)
{
    $validate = isset($validate) ? strtolower(trim($validate)) : '';
    $svali = GetCkVdValue();
    // if($validate=='' || $validate!=$svali)
    // {
    //     ShowMsg('验证码不正确!','-1');
    //     exit();
    // }
	$title = htmlspecialchars($title);
    $content = htmlspecialchars($content);
	$query = "INSERT INTO `#@__plus_mymsg`(`title`,`content`) VALUES('$title','$content')";
    $dsql->ExecuteNoneQuery($query);
    ShowMsg('留言成功!','/mymessage.htm');   //这里我图省事儿，直接写绝对路径了，实际应用的时候不应该这样。
}
?>
