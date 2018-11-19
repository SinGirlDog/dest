$(document).ready(function(){
	$("#select_1").change(function(){
		var reid = $(this).val();
		var	url = '/index.php?ct=index&ac=ajax_get_select&reid='+reid;
		console.log(url);

		$.ajax({
			url:url,
			datatype:'html',
			success:function(ResultHtml,textStatus){
				if(textStatus == 'success'){
					console.log(ResultHtml);
					$("#select_2").html(ResultHtml);
				}
				else{
					console.log(textStatus);
				}
			}
		});
	});
});
