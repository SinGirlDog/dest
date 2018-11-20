<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html>
<html>
<head>
	<title>hello word</title>
	<link href="<?php echo $GLOBALS['cfg_templets_skin']; ?>/style/dedecms.css" rel="stylesheet" media="screen" type="text/css" />

</head>
<body>
	<?php 
	pasterTempletDiy("default/head.htm"); 
	?>

	<div style="margin:0 auto;width:100%;text-align:center;">
		<form method="post" action="/exam/index.php?c=index&a=welcome">
			<ul style="margin:0 auto;width:90%;">
				<li>welcome</li>
				<li>
					<span>select:</span>
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
				</li>
				<li>
					<span>name</span>
					<input name="name" id="name" value="" placeholder="welcome to feimamuchang" />
				</li>
				<li>
					<span>mobile</span>
					<input name="mobile" id="mobile" value="" placeholder="welcome to feimamuchang" />
				</li>
				<li>
					<input type="submit" name="sure" id="sure" value="Are U Sure"/>
				</li>
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