$(document).ready(function () {
	// $("#gettask").click();
	// alert("OK");
});
$("#taskmode").change(function () {
	$("#gettask").click();
});

$("#gettask").click(function () {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "task/mode",
		data: {
			id: $("#taskmode").val(),
		},
		success: function (data) {
			window.location.reload();
			// alert('berhasil');
			// window.location.href = base_url + "bbl/databbl/" + $("#id_header").val();
			// $("#butbatal").click();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
			pesan("ERROR " + xhr.status + " " + thrownError, "info");
		},
	});
});
