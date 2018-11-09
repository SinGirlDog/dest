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