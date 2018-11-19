$(document).ready(function (){
	$("#qbody").blur(function(){
		var qbody = $(this).val();
		$("#title").val(qbody);
	});
});

$(document).ready(function(){
	$("#select_1").change(function(){
		var reid = $(this).val();
		var	url = '?ct=dossier&ac=ajax_get_select&reid='+reid;

		$.ajax({
			url:url,
			datatype:'html',
			success:function(ResultHtml,textStatus){
				if(textStatus == 'success'){
					// $('#select_'+num_next).html(ResultHtml);
					$("#select_2").html(ResultHtml);
				}
				else{
					console.log(textStatus);
				}
			}
		});
	});
});

$(document).ready(function(){
	$("#dosubmit").click(function(){
		if($("#select_2").val() == ""){
			confirm("请选择科目 ^_^ ");
			$("#select_2").focus();
			return false;
		}
		if($("#quest_type").val() == ""){
			confirm("请选择题型 ^_^ ");
			$("#quest_type").focus();
			return false;
		}
		if($("#qbody").val() == ""){
			confirm("请补全题干 ^_^ ");
			$("#qbody").focus();
			return false;
		}
		if($("#qanswer").val() == ""){
			confirm("请补全备选答案 ^_^ ");
			$("#qanswer").focus();
			return false;
		}
		if($("#tanswer").val() == ""){
			confirm("请补全参考答案 ^_^ ");
			$("#tanswer").focus();
			return false;
		}
		$("#myform").submit();
	});
});