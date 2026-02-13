$(document).ready(function () {
	$(".tgl").datepicker({
		showButtonPanel: true,
		autoclose: true,
		format: "dd-mm-yyyy",
		todayHighlight: true,
		todayBtn: "linked",
  		// clearBtn: true,
	});
	
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
		var isipesan = "Periksa Stok Barang " + ini + " !";
		if (ini == "Nobontr Kosong") {
			var isipesan = "Masih ada data yang belum pakai Nomor IB, cek data !";
		}
		pesan(isipesan, "info");
	}
	var errosimpan = $("#errorparam").val();
	if (errosimpan == 1) {
		pesan("Dept Asal & Dept Tujuan harus diset terlebih dahulu !", "info");
	}
	$("#dept_kirim").change();
});
$("#dept_kirim").change(function () {
	var kirim = $(this).val();
	var darike = $("#tujuanbon").html();
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "out/depttuju",
		data: {
			kode: $(this).val(),
		},
		success: function (data) {
			if (kirim == "GS" || kirim == "GP" || kirim == "GM") {
				$("#adddataout").addClass("hilang");
				$("#buttonpilih2").removeClass("hilang");
			} else {
				$("#adddataout").removeClass("hilang");
				$("#buttonpilih2").addClass("hilang");
				$("#adddataout").html('<i class="fa fa-plus"></i><span class="ml-1">Tambah Data '+darike+'</span>');
			}
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
	// alert($(this).val());
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getkettuju",
		data: {
			dari: $("#dept_kirim").val(),
			ke: $(this).val(),
		},
		success: function (data) {
			if (data.jmlrek > 0) {
				$("#div-filter2").removeClass("hilang");
				$("#filterbon2").html(data.datagroup);
			} else {
				$("#div-filter2").addClass("hilang");
			}
			// getdataout();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#simpandetailbarang").click(function () {
	if ($("#id_barang").val() == "") {
		pesan("Isi / Cari nama barang", "error");
		return;
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
	document.formbarangout.submit();
});
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
			filterbon: $("#filterbon").val(),
			filterbon2: $("#filterbon2").val(),
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
function getdatadetailout() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getdatadetailout",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			// alert(data.jumtotdet);
			// window.location.reload();
			$("#body-table").html(data.datagroup).show();
			$("#jmlrek").val(data.jmlrek);
			$("#jumtotdet").html('Total Kgs : '+rupiah(data.jumtotdet,'.',',',2));
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
$("#resetdetailbarang").click(function () {
	$("#id_barang").val("");
	$("#nama_barang").val("");
	$("#id_satuan").val("");
	$("#pcs").val("");
	$("#kgs").val("");
	$("#id").val("");
	$("#keterangan").val("");
	$("#spekbarangnya").text("");
	$("#cont-spek").addClass("hilang");
});
$("#nama_barang").on("keyup", function (e) {
	if (e.key === "Enter" || e.keyCode === 13) {
		$("#caribarang").click();
		$("#caribarang").focus();
	}
});
