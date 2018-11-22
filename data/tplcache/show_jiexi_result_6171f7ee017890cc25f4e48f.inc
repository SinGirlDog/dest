<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>show_jiexi_result</title>
	<link href="<?php echo $GLOBALS['cfg_templets_skin']; ?>/style/dedecms.css" rel="stylesheet" media="screen" type="text/css" />
	<script type="text/javascript" src="static/js/jquery1.7.1.js"></script>
	<script type="text/javascript">
		$(function() {
			　　if (window.history && window.history.pushState){
				$(window).on('popstate', function () {
					window.history.pushState('forward', null, '#');
					window.history.forward(1);
				});
			}
			window.history.pushState('forward', null, '#'); //在IE中必须得有这两行
			window.history.forward(1);
		});
	</script>
</head>
<body>
	<?php 
	pasterTempletDiy("default/head.htm"); 
	?>
	<div style="margin:0 auto;width:80%;text-align:left;">
		<input id="msg" type="hidden" value="<?php echo $msg; ?>">
		<input id="url" type="hidden" value="<?php echo $url; ?>">
		<form method="post" id="jiexi_answer_form" action="/exam/index.php?c=index&a=show_list">
			<p>单项选择：<?php echo $answer_data['fenshu_choice_only']; ?> 分</p>
			<br/>
			<p>多项选择：<?php echo $answer_data['fenshu_choice_more']; ?> 分</p>
			<br/>
			<p>合   计：<?php echo $answer_data['fenshu_choice_more']+$answer_data['fenshu_choice_only']; ?> 分</p>
			<br/>
			<p>排   名：第 <?php echo $paiming['rownum']; ?> 名；
				成功战胜了 <?php echo substr($paiming['percent'],0,5); ?>% 的对手；再接再厉； </p>
				<br/>
				<b><?php echo $answer_data['title'] ?></b>
				<br/>
				<br/>
				<p>姓名：<?php echo $answer_data['name'] ?></p>
				<input type="hidden" name="paper_id" value="{$answer_data['paper_id']}">
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
										<input style='display:none;' id='only_".$num_th."_".$ans_k."' type='radio' value='".($ans_k+1)."' name='only[".$num_th."]'>
									".$ans_v."</label>";
								echo "</dl>";
							}
						}

						if($answer_choice_only[$num_th-1] != $cankao_choice_only['answer'][$num_th-1])
						{
							$current_color = 'style="color:red;"';
							$percent_wrong = 100*$val['wrong_times']/($val['wrong_times']+$val['right_times']);
						}
						else
						{
							$current_color = 'style="color:green;"';
							$percent_wrong = '';
						}
						if($percent_wrong)
						{
							echo "<dl ".$current_color.">错误概率：".$percent_wrong."%</dl>";
						}
						echo "<dl ".$current_color.">回答：".$answer_choice_only[$num_th-1]."</dl>";
						echo "<dl>参考答案：".$cankao_choice_only['answer'][$num_th-1]."</dl>";

						echo "<dl>解析：".$analysis_choice_only[$num_th-1]['quest_analysis']."</dl>";
						
						$analysis_img = $analysis_choice_only[$num_th-1]['analysis_thumb'];
						if($analysis_img)
						{
							echo "<dl><img src='".$analysis_img."'/></dl>";
						}

						$num_th++;
					echo '</ol> ';
				}?>

				<b>二、多选题</b>
				<?php $num_more_th = 0;
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
										<input style='display:none;' id='more_".$num_th."_".$ans_k."' type='checkbox' value='".($ans_k+1)."' name='more[".$num_th."][".$ans_k."]'>
									".$ans_v."</label>";
								echo "</dl>";
							}
						}
						
						$answer_length = sizeof($answer_choice_more[$num_more_th]);
						$cankao_length = sizeof($cankao_choice_more['answer'][$num_more_th]);
						$intersect_length = sizeof(array_intersect($cankao_choice_more['answer'][$num_more_th], $answer_choice_more[$num_more_th]));
						if( ($answer_length != $cankao_length) || ($intersect_length != $cankao_length) )
						{
							$current_color = 'style="color:red;"';
							$percent_wrong = 100*$val['wrong_times']/($val['wrong_times']+$val['right_times']);
						}
						else
						{
							$current_color = 'style="color:green;"';
							$percent_wrong = '';
						}
						if($percent_wrong)
						{
							echo "<dl ".$current_color.">错误概率：".$percent_wrong."%</dl>";
						}
						echo "<dl ".$current_color.">回答：".implode('.',$answer_choice_more[$num_more_th])."</dl>";
						echo "<dl>参考答案：".implode('.',$cankao_choice_more['answer'][$num_more_th])."</dl>";

						echo "<dl>解析：".$analysis_choice_more[$num_more_th]['quest_analysis']."</dl>";

						$analysis_img = $analysis_choice_more[$num_more_th]['analysis_thumb'];
						if($analysis_img)
						{
							echo "<dl><img src='".$analysis_img."'/></dl>";
						}

						$num_th++;
						$num_more_th++;
					echo "</ol>";
				}?>

				<input type="button" id="jiexi_answer_button" value="收起">

			</form>
		</div>
		<?php include $this->CompilerInclude("footer.htm");
 ?>
	</body>
	<script type="text/javascript" src="static/js/jiexi_result.js"></script>
	<style type="text/css">
	form{width: 100%;}
	form ol { padding: 5px; }
	form ol dl { line-height: 30px; word-wrap: normal; padding: 5px; font-size: 18px;}
	form ol dl label { display: block; cursor: pointer; font-size: 16px;}
	form ol dl label:hover { background-color: #1ac; color: #fff; font-weight: 800; }
</style>
</html>