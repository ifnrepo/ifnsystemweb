$(document).ready(function () {

});
$("#butgo").click(function () {
	// alert($("#dept").val());
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "setcost/getdata",
		data: {
			dept: $("#dept").val(),
			ctgr: $("#kategcost").val(),
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
