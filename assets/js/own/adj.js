$(document).ready(function () {
	// $(".datatabledengandiv").DataTable({
	// 	dom: "<'extra'>frtip",
	// });
	// $("div.extra").html($("#sisipkan").html()).insertAfter(".dataTables_filter");
	// $(".dataTables_filter").css("float", "right");
	var url = window.location.href;
	var pisah = url.split("/");
	// alert(pisah[5]);
	if (pisah[2] == "localhost") {
		if (pisah[5] == "dataadj") {
			getdatadetailadj();
		}
	} else {
		if (pisah[4] == "addinvoice" || pisah[4] == "editinvoice") {
			// getdatainvoice();
		}
		if (pisah[5] == "dataadj") {
			getdatadetailadj();
		}
	}
	// $("#dept_kirim").change();
	// $("#level").change();
	var errosimpan = $("#errorparam").val();
	if (errosimpan == 1) {
		pesan("Set dahulu Dept Adjustment dengan klik tombol GO !", "info");
	}
	if (errosimpan == 2) {
		pesan("Data Adjustment berhasil dihapus !", "info");
	}
	if (errosimpan == 3) {
		pesan("Data sudah divalidasi !", "info");
	}
	if (errosimpan == 4) {
		pesan("Data keterangan/catatan ADJ harus di isi !", "info");
	}
});
// $("#tglpb").datepicker();

$("#dept_kirim").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "adj/depttujuadj",
		data: {
			kode: $(this).val(),
		},
		success: function (data) {
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
$('input[name="radios-inline"]').on("change", function (e) {
	var radio = e.target.value;
	// alert(radio);
	$("#id_barang").val("");
	$("#po").val("");
	$("#item").val("");
	$("#dis").val("");
	$("#nama_barang").val("");
	$("#nama_barang").attr("placeholer", "XXXX").blur();
});
$("#pcs").change(function () {
	var po = $("#po").val();
	var item = $("#item").val();
	var dis = $("#dis").val();
	if (po != "" && ($(this).val() != "" || $(this).val() != "0")) {
		$.ajax({
			dataType: "json",
			type: "POST",
			url: base_url + "adj/getberatjala",
			data: {
				po: po,
				item: item,
				dis: dis,
			},
			success: function (data) {
				// alert(data);
				var pcs = parseFloat($("#pcs").val());
				var jmlkgs = pcs * data["berat"];
				$("#kgs").val(jmlkgs);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	}
});
$("#simpandetailbarang").click(function () {
	var insno = $("#insno").val();
	var nobontr = $("#nobontr").val();
	// alert($("#po").val());
	if ($("#po").val() == "") {
		if ($("#id_barang").val() == "") {
			pesan("Isi / Cari nama barang", "error");
			return;
		}
	}
	if ($("#id_satuan").val() == "") {
		pesan("Isi Satuan barang", "error");
		return;
	}
	if (
		($("#pcs").val() == "" || $("#pcs").val() == "0") &&
		($("#kgs").val() == "" || $("#kgs").val() == "0")
	) {
		pesan("Isi Qty atau Kgs", "error");
		return;
	}
	if ($("#keterangan").val() == "") {
		pesan("Keterangan detail barang Harus di isi", "error");
		return;
	}
	// Cek salah masuk nobontr ke insno
	if (insno != "") {
		if (insno.includes("SU-GM") || insno.includes("DLN-IFN")) {
			pesan(
				"Cek kembali nomor instruksi, (Sepertinya Nomor IB yang di input)",
				"error",
			);
			return;
		}
	}
	// Cek salah masuk insno ke nobontr
	if (nobontr != "") {
		var cek = false;
		if (nobontr.includes("SU-GM") && !cek) {
			cek = true;
		}
		if (nobontr.includes("DLN-IFN") && !cek) {
			cek = true;
		}
		if (!cek) {
			pesan(
				"Cek kembali nomor IB, (Sepertinya Nomor Instruksi yang di input)",
				"error",
			);
			return;
		}
	}
	document.formbarangpb.submit();
});
$("#butgo").click(function () {
	// $("#dept_tuju").change();
	getdataadj();
	// alert("XXX");
});
$("#resetdetailbarang").click(function () {
	$("#id_barang").val("");
	$("#nama_barang").val("");
	$("#id_satuan").val("");
	$("#pcs").val("");
	$("#kgs").val("");
	$("#id").val("");
});
$("#nama_barang").on("keyup", function (e) {
	// alert("INI");
	if (e.key == "enter" || e.keycode === 13) {
		$("#caribarang").click();
	}
});
$(document).on("click", "#editdetailadj", function () {
	var noid = $(this).attr("rel");
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "adj/getdetailadjbyid",
		data: {
			id: noid,
		},
		success: function (data) {
			$("#id").val(data[0].id);
			$("#id_barang").val(data[0].id_barang);
			$("#po").val(data[0].po);
			$("#item").val(data[0].item);
			$("#dis").val(data[0].dis);
			if (data[0].po == "") {
				$("#nama_barang").val(data[0].nama_barang);
			} else {
				$("#nama_barang").val(data[0].sku);
			}
			$("#id_satuan").val(data[0].id_satuan);
			$("#pcs").val(data[0].pcs);
			$("#kgs").val(data[0].kgs);
			$("#keterangan").val(data[0].keterangan);
			$("#formbarangpb").attr("action", base_url + "adj/updatedetailbarang");
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#level").change(function () {
	$(this).removeClass("bg-primary");
	$(this).removeClass("bg-success");
	// alert($(this).val());
	setTimeout(() => {
		if ($(this).val() <= 1) {
			$("#adddatapb").removeClass("disabled");
			$(this).addClass("bg-primary");
		} else {
			$("#adddatapb").addClass("disabled");
			$(this).addClass("bg-success");
		}
	}, 200);
	$("#butgo").click();
});
$("#bl").change(function () {
	$.ajax({
		type: "POST",
		url: base_url + "pb/ubahperiode",
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
function getdataadj() {
	// alert($("#level").val());
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "adj/getdataadj",
		data: {
			dept_id: $("#dept_kirim").val(),
		},
		success: function (data) {
			// alert(data.datagroup);
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function getdatadetailadj() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "adj/getdatadetailadj",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			// alert(data.jmlpcs);
			// window.location.reload();
			$("#jmlrek").val(data.jmlrek);
			// $("#jmlpcs").innerText(data.jmlpcs);
			$("#body-table").html(data.datagroup).show();
			if (data.jmlrek == 0) {
				$("#simpanpb").addClass("disabled");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
