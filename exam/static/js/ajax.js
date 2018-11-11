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
		if($("#title").val() == ""){
			confirm("请填写标题 ^_^ ");
			$("#title").focus();
			return false;
		}
		if($("#upfile").val() == ""){
			confirm("请选择上传文件 ^_^ ");
			$("#upfile").focus();
			return false;
		}
		$("#myform").submit();
	});
});