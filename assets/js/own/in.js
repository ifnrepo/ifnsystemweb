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
	$("#dept_kirim").change();
});
$("#dept_kirim").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "in/depttuju",
		data: {
			kode: $(this).val(),
		},
		success: function (data) {
			// alert(data);
			// window.location.reload();
			$("#dept_tuju").html(data);
			$("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#dept_tuju").change(function () {
	var ia = $(this).val();
	if (ia != null) {
		getdatain();
	}
});
$("#bl").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "in/ubahperiode",
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
$(document).on("click", "#verifikasirekord", function () {
	var rel = $(this).attr("rel");
	var jmlverif = $("#jmlverif").val();
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "in/verifikasirekord",
		data: {
			id: rel,
		},
		success: function (data) {
			// alert(data[0]["name"]);
			$("#" + rel).html(
				"<div class='text-primary line-12' style='font-size: 11px !important;'>Verifikasi :" +
					data[0]["name"] +
					"<br>" +
					data["0"]["verif_tgl"] +
					"</div>",
			);
			$("#jmlverif").val(parseFloat(jmlverif) + 1);
			$("#infoverif").html(
				"Verifikasi : " + $("#jmlverif").val() + "/" + $("#jmlrek").val(),
			);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#xsimpanin").click(function () {
	var rekord = $("#jmlrek").val();
	var verif = $("#jmlverif").val();
	if (rekord != verif) {
		pesan("Semua rekord harus diverifikasi !", "error");
		return false;
	} else {
		$("#carisimpanin").click();
	}
});
$("#butgo").click(function () {
	$("#dept_kirim").change();
});
//End JS
function getdatain() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "in/getdata",
		data: {
			dept_id: $("#dept_kirim").val(),
			dept_tuju: $("#dept_tuju").val(),
		},
		success: function (data) {
			// alert(data.datagroup);
			// window.location.reload();
			$("#body-table").html(data.datagroup).show();
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
			if (data.jmlrek == 0) {
				$("#simpanout").addClass("disabled");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
