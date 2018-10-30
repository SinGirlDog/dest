<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>留言管理</title>
<link href="css/base.css" rel="stylesheet" type='text/css'>
<script language='javascript'>
function Sel(stype)
{
	  for(var i=0;i < document.getElementsByName('aids').length;i++)
	  {
		  if(stype=='all') document.getElementsByName('aids')[i].checked=true;
		  else document.getElementsByName('aids')[i].checked=false;
	  }
}
function checkSubmit()
{
	var str = '';
	for(var i=0;i < document.getElementsByName('aids').length;i++)
	{
		  if(document.getElementsByName('aids')[i].checked){
		  	if(str=='') str += document.getElementsByName('aids')[i].value;
		  	else str += ',' + document.getElementsByName('aids')[i].value;
		  }
	}
	if(str=='')
	{
		alert('你没选择任何内容！');
		return false;
	}
	else
	{
		location="mymessage_main.php?aids="+str+"&dopost=delall";
	}
}
</script>
</head>
 
<body background='images/allbg.gif' leftmargin='8' topmargin='8'>
<table width="98%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#D6D6D6">
  <tr>
    <td height="28" background="images/tbg.gif" colspan="4" style="padding-left:10px;"><div style="float:left"> <b>留言管理</b> </div></td>
  </tr>
  <tr>
    <td height="30" align="center" bgcolor="#F9FCEF"  colspan="4"><form action="mymessage_main.php" name="form1" method="get">
        <table border="0" cellspacing="0" cellpadding="3">
          <tr>
            <td>关键字：</td>
            <td><input name="keyword" type="text" id="keyword" size="12" style="width:250px" value="<?php echo $keyword; ?>" /></td>
            <td><input name="imageField" class="np" type="image" src="images/button_search.gif" width="60" height="22" border="0" /></td>
          </tr>
        </table>
      </form></td>
  </tr>
  <form name='form1' method='post' action='mymessage_main.php' onSubmit='return checkSubmit();'>
    <input type='hidden' name='dopost' value='delall'/>
    <input type='hidden' name='allid' value=''/>
    <tr align="center" bgcolor="#FBFCE2" height="26">
      <td width="40">选择</td>
      <td width="100">留言标题</td>
      <td width="">留言内容</td>
      <td width="100">管理</td>
    </tr>
    <?php
$atts = array();
$atts['tagname'] = 'datalist';
$blockValue = $this->refObj->GetArcList($atts,$this->refObj,$fields); 
if(is_array($blockValue)){
foreach( $blockValue as $key=>$fields )
{
?>
    <tr align="center" bgcolor="#FFFFFF" height="26" onMouseMove="javascript:this.bgColor='#FCFDEE';"
        	 onMouseOut="javascript:this.bgColor='#FFFFFF';">
      <td><input type='checkbox' name='aids' value='<?php echo $fields['id']; ?>' class='np'></td>
      <td><a href="<?php echo $fields['title']; ?>" target='_blank'><?php echo htmlspecialchars($fields['title']); ?></a></td>
      <td><a href="<?php echo $fields['content']; ?>" target='_blank'><?php echo htmlspecialchars($fields['content']); ?></a></td>
      <td><a href='mymessage_main.php?id=<?php echo $fields['id']; ?>&dopost=delete'>[删除]</a></td>
    </tr>
    <?php
}
}?>
  </form>
  <tr bgcolor="#ffffff" height="28">
    <td colspan="4"> 　 <a href='#' onclick='Sel("all")' class='np coolbg'>[全选]</a> <a href='#' onclick='Sel("none")' class='np coolbg'>[取消]</a> <a href='#' onclick='checkSubmit()' class='np coolbg'>批量删除</a></td>
  </tr>
  <tr align="center" bgcolor="#F9FCEF" height="28">
    <td colspan="4"> <?php
$atts = array();
$atts['tagname'] = 'pagelist';
$atts['listsize'] = '6';
 echo $this->refObj->GetPageList($atts,$this->refObj,$fields); 
?>
 </td>
  </tr>
</table>
</body>
</html>