<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $cfg_soft_lang;?>">
	<title>EXAM管理</title>
	<script type="text/javascript" src="static/js/j.js"></script>
	<script type="text/javascript" src="static/js/xml.js"></script>
	<script type="text/javascript" src="static/js/ajax.js"></script>
	<link href="static/css/admin.css" rel="stylesheet" type="text/css" />
</head>
<body leftmargin='8' topmargin='8'>
	<div class="bodytitle">
		<div class="bodytitleleft"></div>
		<div class="bodytitletxt"  style="padding-left:10px;"><b>EXAM模块</b> -- EXAM卷宗管理</div>
	</div>
	<table width="98%" border="0" cellpadding="0" cellspacing="1" align="center" style="background:#cfcfcf;">
		<tr>
			<td height="26" bgcolor="#EDF9D5" background="static/images/tbg.gif" style="padding-left:10px;"><strong style="float:left;">&nbsp;编辑分类</strong><span style="float:right;padding-right:10px;"><a href='?ct=examtype&ac=add&amp&height=200&amp;width=450' class="thickbox">增加分类</a></span></td>
		</tr>
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="0" cellspacing="1" align="center" style="margin:0px auto;background:#ffffff;">
					<tr height="25" bgcolor="#FBFCE2" >
						<td width="10%" align="center">id</td>
						<td width="10%">分类名称</td>
						<td width="10%">单选题数</td>
						<td width="10%">单选分数</td>
						<td width="10%">多选题数</td>
						<td width="10%">多选分数</td>
						<td width="20%" align="center">管理操作</td>
					</tr>
					<?php
					foreach($examtypes as $examtype){
					?>
					<tr>
						<td  align="center"><?php echo $examtype['id'];?></td>
						<td><?php echo $examtype['name'];?></td>
						<td><?php echo $examtype['onlynum'];?></td>
						<td><?php echo $examtype['onlyfenshu'];?></td>
						<td><?php echo $examtype['morenum'];?></td>
						<td><?php echo $examtype['morefenshu'];?></td>
						<td align="center"><a href="?ct=examtype&ac=add&name=<?php echo $examtype['name'];?>&id=<?php echo $examtype['id'];?>&amp&height=200&amp;width=450" class="thickbox">添加子类</a> <a href='?ct=examtype&ac=edit&amp;id=<?php echo $examtype['id'];?>&height=200&amp;width=450' class="thickbox">修改</a> <a href='#' onClick="javascript:del(<?php echo $examtype['id'];?>)">删除</a></td>
					</tr>
					<?php if(!empty($examtype['son'])) echo $examtype['son']; }?>
				</table> 
			</td>
		</tr>
		<tr>
			<td height="30" style="padding-right:10px;" align="right" bgcolor="#F8FCF1"><input name="submit3" type="submit" value="更新排序" class="np coolbg"/></td>
		</tr>
	</table>
	<form style="margin-left:30px;" action="?ct=dossier&ac=upload_xml" method="post" enctype="multipart/form-data" name="myform" id="myform">
		<table border="0" width="100%">
			<tbody>
				<tr>
					<td align="right">科目：</td>
					<td align="left">
						<select name="reid_level_1" id="select_1" class="select_ajax">
							<option value ="">-请选择-</option>
							<?php 
							foreach($examtp as $key=>$val)
							{
								echo "<option value =".$val['id'].">".$val['name']."</option>";
							}
							?>
						</select>
						<select name="reid_level_2" id="select_2" class="select_ajax">
							<option value ="">-请选择-</option>
						</select>
					</td>
					<td>
						<span>卷宗标题：</span>
						<input name="title" id="title" value="" placeholder="请填写标题">
					</td>
					<td><input type="button" value="选择" onclick="SelectXML('myform.upfile','small');"/>
						<span>文件：</span>
						<input type="text" id="upfile" name="upfile" value="" placeholder="请选择上传文件"/>
						
						(目前仅支持XML电子表格)
						<input type="button" id="dosubmit" name='addsubmit' value="上船" class="shangchuan"/>
						(文件大小最好小于1MB)
					</td>
				</tr>
			</tbody>
		</table>
	</form>
</body>
</html>