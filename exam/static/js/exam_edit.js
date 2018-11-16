$(document).ready(function (){
	$("#qbody").blur(function(){
		var qbody = $(this).val();
		$("#title").val(qbody);
	});
});