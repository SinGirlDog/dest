<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><ol>
	<dl style="display: inline-block;">
		若确认预览结果无误；可点击
		<a href="?ct=dossier"><input type="button" value="返回列表" /></a>
		返回后尝试“存储”操作；
	</dl>
</ol>
<?php
require_once(DEDEEXAM.'/libraries/XML/xml.class.php');
$myXml = new xml();
$myXml->dir = $_SERVER['DOCUMENT_ROOT'].$thefile['url'];
$myXml->init();
?>
<ol>
	<dl style="display: inline-block;text-align: center;">
		若确认预览结果无误；可点击
		<a href="?ct=dossier"><input type="button" value="返回列表" /></a>
		返回后尝试“存储”操作；
	</dl>
</ol>