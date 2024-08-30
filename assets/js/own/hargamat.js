$(document).ready(function () {
	// alert("SIAP");
});

$("#filter").change(function () {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "hargamat/addkondisi",
		data: {
			kate: $("#filter").val(),
			arti: $("#filterinv").val(),
		},
		success: function (data) {
			window.location.reload();
			// alert(data);
			// window.location.reload();
			// $("#dept_tuju").html(data);
			// $("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#filterinv").change(function () {
	$("#filter").change();
});
