<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang;?>" />
  <title>分类修改</title>
  <link href="static/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body>
  <form name="form" action="?ct=examtype&ac=edit_save" method="post" style="padding-top: 15px;">
    <input type='hidden' name='id' value=<?php echo $examtype['id']; ?> />
    <table width="96%" border="0" cellpadding="1" cellspacing="1" align="center" class="tbtitle" style="	background:#E2F5BC;">
      <tr>
        <td colspan="2" bgcolor="#EDF9D5" background="img/wbg.gif"><strong>&nbsp;修改</strong>
        </td>
      </tr>
      <tr>
        <td width="150" align="right" bgcolor="#FFFFFF">所属分类：</td>
        <td bgcolor="#FFFFFF"><select name="reid">
          <?php echo $sectorscache; ?>
        </select>        </td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF">分类名称：</td>
        <td bgcolor="#FFFFFF"><input type=text name=name value=<?php echo $examtype['name']; ?> /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF">单选题数量：</td>
        <td bgcolor="#FFFFFF"><input type=text name=onlynum value=<?php echo $examtype['onlynum']; ?> /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF">单选题分数：</td>
        <td bgcolor="#FFFFFF"><input type=text name=onlyfenshu value=<?php echo $examtype['onlyfenshu']; ?> /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF">多选题数量：</td>
        <td bgcolor="#FFFFFF"><input type=text name=morenum value=<?php echo $examtype['morenum']; ?> /></td>
      </tr>
      <tr>
        <td align="right" bgcolor="#FFFFFF">多选题分数：</td>
        <td bgcolor="#FFFFFF"><input type=text name=morefenshu value=<?php echo $examtype['morefenshu']; ?> /></td>
      </tr>
      <tr>
        <td height="35" bgcolor="#FFFFFF">&nbsp;</td>
        <td bgcolor="#F8FCF1"><input name="submit4" type="submit" value="提交" class="np coolbg"/></td>
      </tr>
    </table>

    <br>
    <br>
  </form>
</body>
</html>