<?php
/**
 * 文件选择
 *
 * @version        $Id: select_xml_post.php 1 10:24 2018年11月11日 Sun $
 */

require_once(dirname(__FILE__)."/config.php");
// require_once(dirname(__FILE__)."/../xml.func.php");

$xmlpath = "/xml";
if(empty($activepath))
{
	$activepath ='';
	$activepath = str_replace('.', '', $activepath);
	$activepath = preg_replace("#\/{1,}#", '/', $activepath);
	if(strlen($activepath) < strlen($cfg_image_dir))
	{
		$activepath = $cfg_image_dir;
	}
}
if(!strpos($activepath,$xmlpath)){
	$activepath .= $xmlpath;
}

$xmlfile_type = "xml";
if(empty($xmlfile))
{
	$xmlfile='';
}
if(!is_uploaded_file($xmlfile))
{
	ShowMsg("你没有选择上传的文件!".$xmlfile, "-1");
	exit();
}
$CKEditorFuncNum = (isset($CKEditorFuncNum))? $CKEditorFuncNum : 1;
$xmlfile_name = trim(preg_replace("#[ \r\n\t\*\%\\\/\?><\|\":]{1,}#", '', $xmlfile_name));

if(!preg_match("#\.(".$cfg_xmltype.")#i", $xmlfile_name))
{
	ShowMsg("你所上传的文件类型不在许可列表，请更改系统对扩展名限定的配置！".$cfg_xmltype.$xmlfile_name, "-1");
	exit();
}
$nowtme = time();
$sparr = Array("xml");
$xmlfile_type = strtolower(trim($xmlfile_type));
if(!in_array($xmlfile_type, $sparr))
{
	ShowMsg("上传的图片格式错误，请使用JPEG、GIF、PNG、WBMP格式的其中一种！","-1");
	exit();
}
$mdir = MyDate($cfg_addon_savetype, $nowtme);
if(!is_dir($cfg_basedir.$activepath."/$mdir"))
{
	MkdirAll($cfg_basedir.$activepath."/$mdir",$cfg_dir_purview);
	CloseFtp();
}
$filename_name = $cuserLogin->getUserID().'-'.dd2char(MyDate("ymdHis", $nowtme).mt_rand(100,999));
$filename = $mdir.'/'.$filename_name;
$fs = explode('.', $xmlfile_name);
$filename = $filename.'.'.$fs[count($fs)-1];
$filename_name = $filename_name.'.'.$fs[count($fs)-1];
$fullfilename = $cfg_basedir.$activepath."/".$filename;
move_uploaded_file($xmlfile, $fullfilename) or die("上传文件到 $fullfilename 失败！");
if($cfg_remote_site=='Y' && $remoteuploads == 1)
{
    //分析远程文件路径
	$remotefile = str_replace(DEDEROOT, '', $fullfilename);
	$localfile = '../..'.$remotefile;
    //创建远程文件夹
	$remotedir = preg_replace('/[^\/]*\.(xml)/', '', $remotefile);
	$ftp->rmkdir($remotedir);
	$ftp->upload($localfile, $remotefile);
}
@unlink($xmlfile);
if(empty($resize))
{
	$resize = 0;
}
if($resize==1)
{
	if(in_array($xmlfile_type, $cfg_photo_typenames))
	{
		ImageResize($fullfilename, $iwidth, $iheight);
	}
}
else
{
	if(in_array($xmlfile_type, $cfg_photo_typenames))
	{
		WaterImg($fullfilename, 'up');
	}
}

$info = '';
$sizes[0] = 0; $sizes[1] = 0;
$sizes = getimagesize($fullfilename, $info);
$imgwidthValue = $sizes[0];
$imgheightValue = $sizes[1];
$imgsize = filesize($fullfilename);
$inquery = "INSERT INTO `#@__uploads`(arcid,title,url,mediatype,width,height,playtime,filesize,uptime,mid)
VALUES ('0','$filename','".$activepath."/".$filename."','1','$imgwidthValue','$imgheightValue','0','{$imgsize}','{$nowtme}','".$cuserLogin->getUserID()."'); ";
$dsql->ExecuteNoneQuery($inquery);
$fid = $dsql->GetLastID();
AddMyAddon($fid, $activepath.'/'.$filename);
$CKUpload = isset($CKUpload)? $CKUpload : FALSE;
if ($GLOBALS['cfg_html_editor']=='ckeditor' && $CKUpload)
{
	$fileurl = $activepath.'/'.$filename;
	$message = '';

	$str='<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction('.$CKEditorFuncNum.', \''.$fileurl.'\', \''.$message.'\');</script>';
	exit($str);
}

if(!empty($noeditor)){
	//（2011.08.25 根据用户反馈修正图片上传回调 by:织梦的鱼）
	ShowMsg("成功上传一份文件！","select_xml.php?xmlstick=$xmlstick&comeback=".urlencode($filename_name)."&v=$v&f=$f&CKEditorFuncNum=$CKEditorFuncNum&noeditor=yes&activepath=".urlencode($activepath)."/$mdir&d=".time());
}else{
	ShowMsg("成功上传一份文件！","select_xml.php?xmlstick=$xmlstick&comeback=".urlencode($filename_name)."&v=$v&f=$f&CKEditorFuncNum=$CKEditorFuncNum&activepath=".urlencode($activepath)."/$mdir&d=".time());
}
exit();