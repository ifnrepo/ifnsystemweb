$(document).ready(function () {

});

$("#butgoview").click(function(){
	$("#deptkontrak").change();
})
$("#deptkontrak").change(function(){
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "main/setdeptnotif",
		data: {
			dept : $("#deptkontrak").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})