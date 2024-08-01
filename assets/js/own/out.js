$(document).ready(function () {
	var url = window.location.href;
	var pisah = url.split("/");
	// alert(pisah[5]);
	if (pisah[2] == "localhost") {
		if (pisah[5] == "dataout") {
			getdatadetailout();
		}
	} else {
		if (pisah[4] == "addinvoice" || pisah[4] == "editinvoice") {
			// getdatainvoice();
		}
		if (pisah[5] == "dataout") {
			getdatadetailout();
		}
	}
	if ($("#errornya").val() != "" && $("#errornya").length > 0) {
		var ini = $("#errornya").val();
		var isipesan =
			"Stok Barang ke " + ini + " kurang Qty Real (Pengeluaran), cek data !";
		if (ini == "Nobontr Kosong") {
			var isipesan = "Masih ada data yang belum pakai Nobontr, cek data !";
		}
		pesan(isipesan, "info");
	}
	$("#dept_kirim").change();
});
$("#dept_kirim").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "out/depttuju",
		data: {
			kode: $(this).val(),
		},
		success: function (data) {
			// alert(data);
			// window.location.reload();
			$("#dept_tuju").html(data);
			// $("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
// $("#dept_tuju").change(function () {
// 	var ia = $(this).val();
// 	if (ia != null) {
// 		getdataout();
// 	}
// });
$("#bl").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "out/ubahperiode",
		data: {
			bl: $(this).val(),
			th: $("#th").val(),
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
$("#th").change(function () {
	$("#bl").change();
});
$("#butgo").click(function () {
	getdataout();
});
$("#xsimpanout").click(function () {
	$("#simpanout").click();
});
function getdataout() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getdata",
		data: {
			dept_id: $("#dept_kirim").val(),
			dept_tuju: $("#dept_tuju").val(),
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function getdatadetailout() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getdatadetailout",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			// alert(data.jmlrek);
			// window.location.reload();
			$("#body-table").html(data.datagroup).show();
			$("#jmlrek").val(data.jmlrek);
			if (data.jmlrek == 0) {
				$("#xsimpanout").addClass("disabled");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
