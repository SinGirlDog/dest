<?php
require_once(dirname(__FILE__).'/config.php');
require_once(DEDEINC.'/datalistcp.class.php');
CheckPurview('plus_用户留言插件');
 
if(empty($dopost)) $dopost = "";
if(isset($allid))
{
    $aids = explode(',',$allid);
    if(count($aids)==1)
    {
        $id = $aids[0];
        $dopost = "delete";
    }
}
if($dopost=="delete")
{
    $id = preg_replace("#[^0-9]#", "", $id);
    $dsql->ExecuteNoneQuery("DELETE FROM `#@__plus_mymsg` WHERE id='$id'");
    ShowMsg("成功删除一条留言！","mymessage_main.php");
    exit();
}else if($dopost=="delall")
{
    $aids = explode(',',$aids);
    if(isset($aids) && is_array($aids))
    {
        foreach($aids as $aid)
        {
            $aid = preg_replace("#[^0-9]#", "", $aid);
            $dsql->ExecuteNoneQuery("DELETE FROM `#@__plus_mymsg` WHERE id='$aid'");
        }
        ShowMsg("成功删除指定留言！","mymessage_main.php");
        exit();
    }
    else
    {
        ShowMsg("你没选定任何留言！","mymessage_main.php");
        exit();
    }
}else{
	if(empty($keyword)) $keyword = '';
	$sql = "SELECT * FROM `#@__plus_mymsg` WHERE  CONCAT(`title`,`content`) LIKE '%$keyword%'";
	
	$dlist = new DataListCP();
	$dlist->SetParameter('keyword', $keyword);
	$dlist->SetTemplet(DEDEADMIN.'/templets/mymessage_main.htm');
	$dlist->SetSource($sql);
	$dlist->display();
}
?>
