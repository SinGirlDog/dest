<?php
if(!isset($GLOBALS['_vars'])) $GLOBALS['_vars'] = array(); 
$fields = array();
?><form>
	<?php
	?>
	<ol>
		<dl><span>分类</span>：<?php echo ExamReidDeal($thexam['reid']);?></dl>

		<dl><span>ID</span>：<?php echo $thexam['id'];?></dl>

		<dl><span>标题</span>：<input type="text" readonly="readonly" placeholder="<?php echo $thexam['title'];?>" ></dl>

		<dl><span>类型</span>：<?php echo ExamQuestTypeDeal($thexam['quest_type']);?></dl>

		<dl><span>题干</span>：<textarea><?php echo $thexam['quest_body'];?></textarea></dl>

		<dl>
			<span>备选答案</span>：
			<textarea><?php echo $thexam['quest_answer'];?></textarea>
			<p>各选项以英文分号";"为间隔，请勿手动换行</p>
		</dl>

		<dl>
			<span>参考答案</span>：<input value="<?php echo $thexam['true_answer'];?>" >
			<p>多选题参考答案请以英文点"."间隔，例如：X.Y.Z</p>
		</dl>

		<dl><span>解析</span>：<textarea><?php echo $thexam['quest_analysis'];?></textarea></dl>

		<dl><span>答对次数</span>：<?php echo $thexam['right_times'];?>次</dl>

		<dl><span>答错次数</span>：<?php echo $thexam['wrong_times'];?>次</dl>

		<dl><span>生成时间</span>：<?php echo MyDate("Y-m-d H:i:s",$thexam['addtime']);?></dl>

		<dl><span>最近更新</span>：<?php echo MyDate("Y-m-d H:i:s",$thexam['updatetime']);?></dl>
	</ol>
	<input type="button" value="提交">
</form>
<style type="text/css">
dl {
	padding: 15px;
	border-bottom: 3px dashed #5b0a6133;
}
dl p{
	color:#F00;
	font-size: 10px;
	display: block;
	margin-right: 30px;
}
dl input,textarea{
	width: 80%;
	display: inline-block;
}
dl textarea{
	height: 70px;
}
dl span{
	width: 10%;
	height: 30px;
	line-height: 30px;
	text-align: center;
	display: inline-block;
}
</style>