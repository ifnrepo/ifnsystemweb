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
		if (pisah[5] == "datapo") {
			getdatadetailpo();
		}
	} else {
		if (pisah[5] == "datapo") {
			getdatadetailpo();
		}
	}
	// $("#dept_kirim").change();
	// $("#level").change();
	var jn_bayar = $("#jn_pembayaran").val();
	if (jn_bayar == "CASH" || jn_bayar == "") {
		$("#tgldtbt").attr("disabled", true);
	} else {
		$("#tgldtbt").attr("disabled", false);
	}
});
// $("#tglpb").datepicker();

$("#dept_kirim").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "pb/depttujupb",
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
$("#tgldt").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
});
$("#tgldtbt").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
});
$("#tgldt").change(function () {
	var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadertgldt").html(isinya);
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "po/updatebykolom/tgl_dtb",
		data: {
			isinya: tglmysql($("#tgldt").val()),
			id: $("#id_header").val(),
		},
		success: function (data) {
			$("#loadertgldt").html("");
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#tgldtbt").change(function () {
	var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadertgldbt").html(isinya);
	alert(tglmysql($("#tgldtbt").val()));
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "po/updatebykolom/tgl_rencana_bayar",
		data: {
			isinya: tglmysql($("#tgldtbt").val()),
			id: $("#id_header").val(),
		},
		success: function (data) {
			$("#loadertgldtbt").html("");
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#jn_pembayaran").change(function () {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "po/updatebykolom/jenis_pembayaran",
		data: {
			isinya: $(this).val(),
			id: $("#id_header").val(),
		},
		success: function (data) {
			// $("#loadertgldtbt").html("");
			window.location.reload();
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
	document.formbarangpb.submit();
});
$("#butgo").click(function () {
	// $("#dept_tuju").change();
	getdatapo();
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
	if (e.key == "Enter" || e.keycode === 13) {
		$("#caribarang").click();
	}
});
$(document).on("click", "#editdetailpb", function () {
	var noid = $(this).attr("rel");
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "pb/getdetailpbbyid",
		data: {
			id: noid,
		},
		success: function (data) {
			$("#id").val(data[0].id);
			$("#id_barang").val(data[0].id_barang);
			$("#nama_barang").val(data[0].nama_barang);
			$("#id_satuan").val(data[0].id_satuan);
			$("#pcs").val(data[0].pcs);
			$("#kgs").val(data[0].kgs);
			$("#formbarangpb").attr("action", base_url + "pb/updatedetailbarang");
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
		// dataType: "json",
		type: "POST",
		url: base_url + "po/ubahperiode",
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
$("#carisupplier").click(function () {
	$("#tglpo").click();
	// alert('OKE');
});

function getdatapo() {
	// alert($("#level").val());
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "po/getdatapo",
		data: {
			jn: $("#jn_po").val(),
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

function getdatadetailpo() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "po/getdatadetailpo",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			// alert(data.jmlrek);
			// window.location.reload();
			$("#jmlrek").val(data.jmlrek);
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
