<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html>
<html>
<head>
	<title>show_one_paper</title>
	<link href="<?php echo $GLOBALS['cfg_templets_skin']; ?>/style/dedecms.css" rel="stylesheet" media="screen" type="text/css" />

</head>
<body>
	<?php 
	pasterTempletDiy("default/head.htm"); 
	?>

	<div style="margin:0 auto;width:80%;text-align:left;">
		<form method="post" action="/exam/index.php?c=index&a=paper_answered" id="put_answer_form">
			<b><?php echo $paper_data['title'];?></b>
			<br/>
			<br/>
			<p>姓名：<?php echo $paper_data['name'];?></p>
			<input type="hidden" name="paper_id" value="<?php echo $paper_data['id'];?>">
			<br/>
			<b>一、单选题</b>
			
			<?php $num_th = 1;
			foreach($quest_choice_only as $key=>$val)
			{
				echo '<ol class="choice_only">';
					
					if($val['quest_body'])
					{
						echo "<dl>".$num_th.".".$val['quest_body']."</dl>";
					}
					if($val['thumb'])
					{
						echo "<dl><img src='".$val['thumb']."'/></dl>";
					}
					if($val['quest_answer'])
					{
						$answer_arr = explode(';',$val['quest_answer']);
						foreach($answer_arr as $ans_k=>$ans_v)
						{
							echo "<dl>";
								echo "<label for='only_".$num_th."_".$ans_k."'>
									<input id='only_".$num_th."_".$ans_k."' type='radio' value='".($ans_k+1)."' name='only[".$num_th."]'>
								".$ans_v."</label>";
							echo "</dl>";
						}

					}
					
					$num_th++;
				echo '</ol> ';
			}?>
			
			<b>二、多选题</b>
			<?php 
			foreach($quest_choice_more as $key=>$val)
			{
				echo '<ol class="choice_more">';
					
					if($val['quest_body'])
					{
						echo "<dl>".$num_th.".".$val['quest_body']."</dl>";
					}
					if($val['thumb'])
					{

						echo "<dl><img src='".$val['thumb']."'/></dl>";
					}
					if($val['quest_answer'])
					{
						$answer_arr = explode(';',$val['quest_answer']);
						foreach($answer_arr as $ans_k=>$ans_v)
						{
							echo "<dl>";
								echo "<label for='more_".$num_th."_".$ans_k."'>
									<input id='more_".$num_th."_".$ans_k."' type='checkbox' value='".($ans_k+1)."' name='more[".$num_th."][".$ans_k."]'>
								".$ans_v."</label>";
							echo "</dl>";
						}

					}
					
					$num_th++;
				echo "</ol>";
			}?>

			<input type="button" id="put_answer_ajax_button" value="确定">
		</form>
	</div>

	<?php include $this->CompilerInclude("footer.htm");
 ?>
</body>
<script type="text/javascript" src="static/js/j.js"></script>
<script type="text/javascript" src="static/js/paper_answered.js"></script>
<style type="text/css">
form{width: 100%;}
form ol { padding: 5px; }
form ol dl { line-height: 30px; word-wrap: normal; padding: 5px; font-size: 18px;}
form ol dl label { display: block; cursor: pointer; font-size: 16px;}
form ol dl label:hover { background-color: #1ac; color: #fff; font-weight: 800; }
</style>
</html>