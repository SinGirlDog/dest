$(document).ready(function(){
	$("#select_1").change(function(){
		var reid = $(this).val();
		var	url = '/exam/index.php?c=index&a=ajax_get_select&reid='+reid;

		$.ajax({
			type:"POST",
			url:url,
			datatype:'html',
			success:function(ResultHtml,textStatus){
				if(textStatus == 'success'){
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
	$("#sure").click(function(){
		var s2 = $("#select_2").val();
		if(s2 == ""){
			confirm("请选择分类");
			$("#select_2").focus();
			return false;
		}
		var name = $("#name").val();
		if(name == ""){
			confirm("请填写姓名");
			$("#name").focus();
			return false;
		}
		var myreg=/^[1][3,4,5,7,8][0-9]{9}$/;
		var mobile = $("#mobile").val();
		if(mobile == "" || !myreg.test(mobile)){
			confirm("请填写有效的手机号码");
			$("#mobile").focus();
			return false;
		}
		console.log($("#sure").val());
	});
});

$(document).ready(function(){
	$("#file_list_form ul li").click(function(){
		var fileid = $(this).attr('id');
		$("#fileid").val(fileid);
		$("#file_list_form").submit();

	});
});

