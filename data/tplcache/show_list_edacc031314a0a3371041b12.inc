<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html>
<html>
<head>
	<title>show list</title>
	<link href="<?php echo $GLOBALS['cfg_templets_skin']; ?>/style/dedecms.css" rel="stylesheet" media="screen" type="text/css" />

</head>
<body>
	<?php 
	pasterTempletDiy("default/head.htm"); 
	?>

	<div style="margin:0 auto;width:100%;text-align:center;">
		<form method="post" id="file_list_form" action="/exam/index.php?c=index&a=open_file">
			<input type="hidden" name='reid' value="<?php echo $treeNewBee['reid']?>">
			<input type="hidden" name='name' value="<?php echo $treeNewBee['name']?>">
			<input type="hidden" name='mobile' value="<?php echo $treeNewBee['mobile']?>">
			<input type="hidden" name="fileid" id="fileid" value="">
			<ul style="margin:0 auto;width:90%;">
				<?php
				foreach($filelist as $key=>$file)
				{
					echo "<li id='".$file[id]."'>".++$key."-".$file[title]."</li>";
				}
				?>
			</ul>
		</form>
	</div>

	<?php include $this->CompilerInclude("footer.htm");
 ?>
</body>
<script type="text/javascript" src="static/js/j.js"></script>
<script type="text/javascript" src="static/js/ajax_index.js"></script>
<style type="text/css">
form{width: 100%;}
form ul li {padding: 5px;}
</style>
</html>