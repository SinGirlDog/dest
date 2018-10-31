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
	<?php include $this->CompilerInclude("head.htm");
  foreach($data as $k => $v):  echo $k.'-=-'.$v.'<br/>';  endforeach;  include $this->CompilerInclude("footer.htm");
 ?>
</body>
</html>