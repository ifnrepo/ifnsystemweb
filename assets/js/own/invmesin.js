$("#thperiode").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "invmesin/ubahperiode",
		data: {
			th: $(this).val(),
			lok: $("#lokasimesin").val(),
			bl: $("#blperiode").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#blperiode").change(function () {
	$("#thperiode").change();
});
$("#lokasimesin").change(function () {
	$("#thperiode").change();
});
