$(document).ready(function () {
	// Load
});
$("#butgo").click(function () {
	var dept = $("#deptkontrak").val();
	if (dept == "" || dept == null) {
		pesan("Pilih Nama Rekanan terlebih dahulu", "info");
	} else {
		$.ajax({
			// dataType: "json",
			type: "POST",
			url: base_url + "kontrak/getdata",
			data: {
				dept_id: dept,
				jnsbc: $("#jns_bc").val(),
			},
			success: function (data) {
				window.location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	}
});
