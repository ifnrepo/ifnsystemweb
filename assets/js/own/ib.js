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
		if (pisah[5] == "dataib") {
			getdatadetailib();
		}
	} else {
		if (pisah[5] == "dataib") {
			getdatadetailib();
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
	var value_old = 0;
	var errosimpan = $("#errorsimpan").val();
	if (errosimpan == 1) {
		pesan(
			"Pilih departemen penerima Input Barang (tekan tombol 'GO' dahulu)",
			"error",
		);
	}
	if (errosimpan == 2) {
		pesan("Ada Error Program, Hubungi Administrator Aplikasi !", "error");
	}
	if (errosimpan == 3) {
		pesan("Tidak terjadi perubahan pada data X !", "error");
	}
});
// $("#tglpb").datepicker();
$("#bl").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "ib/ubahperiode",
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
	// $("#dept_tuju").change();
	getdataib();
});
$("#jn_ib").change(function () {
	var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadview").html(isinya);
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/updatebykolom/jn_ib",
		data: {
			isinya: $(this).val(),
			id: $("#id_header").val(),
		},
		success: function (data) {
			$("#loadview").html("");
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$(".inputtgl").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
});
$("#nomor_sj").focus(function () {
	value_old = $(this).val();
});
$("#tgl_sj").focus(function () {
	value_old = $(this).val();
});
$("#nomor_aju").focus(function () {
	value_old = $(this).val();
});
$("#tgl_aju").focus(function () {
	value_old = $(this).val();
});
$("#no_kendaraan").focus(function () {
	value_old = $(this).val();
});
$("#no_faktur_pajak").focus(function () {
	value_old = $(this).val();
});
$("#nomor_sj").blur(function () {
	if ($("#nomor_sj").val() != value_old) {
		updatekolom($("#id_header").val(), "tb_header", "nomor_sj", $(this).val());
	}
});
$("#tgl_sj").change(function () {
	if ($("#tgl_sj").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"tgl_sj",
			tglmysql($(this).val()),
		);
	}
});
$("#nomor_aju").blur(function () {
	if ($("#nomor_aju").val() != value_old) {
		updatekolom($("#id_header").val(), "tb_header", "nomor_aju", $(this).val());
	}
});
$("#tgl_aju").change(function () {
	if ($("#tgl_aju").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"tgl_aju",
			tglmysql($(this).val()),
		);
	}
});
$("#no_kendaraan").blur(function () {
	if ($("#no_kendaraan").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"no_kendaraan",
			$(this).val(),
		);
	}
});
$("#no_faktur_pajak").blur(function () {
	if ($("#no_faktur_pajak").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"no_faktur_pajak",
			$(this).val(),
		);
	}
});

$("#cekbarang").click(function () {
	if ($("#id_pemasok").val() == 0) {
		pesan("Isi data supplier/Pemasok terlebih dahulu", "info");
		return false;
	} else {
		$("#getbarang").click();
	}
});

function updatekolom(idx, tabel, kolom, isi) {
	var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadview").html(isinya);
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/updatekolom/" + kolom,
		data: {
			isinya: isi,
			tbl: tabel,
			id: idx,
		},
		success: function (data) {
			$("#loadview").html("");
			// alert(data);
			// window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function getdatadetailib() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/getdatadetailib",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			// alert(data.jmlrek);
			// window.location.reload();
			$("#jmlrek").val(data.jmlrek);
			$("#body-table").html(data.datagroup).show();
			// $("#totalharga").val(rupiah(data.totalharga, ".", ",", 2));
			if (data.jmlrek > 0) {
				$("#jn_ib").attr("disabled", true);
				$("#pilihsup").addClass("disabled");
			}
			// hitunggrandtotal();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
$("#xsimpanib").click(function () {
	if ($("#nomor_sj").val() == "" || $("#tgl_sj").val() == "") {
		pesan("Nomor/Tgl Surat jalan belum diisi !", "info");
		return false;
	}
	if ($("#nomor_aju").val() == "" || $("#tgl_aju").val() == "") {
		pesan("Nomor/Tgl AJU belum di isi !", "info");
		return false;
	}
	if ($("#totalharga").val() == "") {
		pesan("Harga ada yang kosong !", "info");
		return false;
	}
	$("#carisimpanib").click();
});
//End IB JS
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
	// alert(tglmysql($("#tgldtbt").val()));
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
$("#mt_uang").change(function () {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "po/updatebykolom/mt_uang",
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
$("#carisupplier").click(function () {
	$("#tglpo").click();
	// alert('OKE');
});

$("#diskon").focus(function () {
	value_old = toAngka($(this).val());
});
$("#pph").focus(function () {
	value_old = toAngka($(this).val());
});
$("#diskon").blur(function () {
	if (toAngka($("#diskon").val()) != value_old) {
		hitunggrandtotal();
		$.ajax({
			dataType: "json",
			type: "POST",
			url: base_url + "po/updatebykolom/diskon",
			data: {
				isinya: toAngka($(this).val()),
				id: $("#id_header").val(),
			},
			success: function (data) {
				// $("#loadertgldtbt").html("");
				// window.location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	}
});
$("#pph").blur(function () {
	if (toAngka($("#pph").val()) != value_old) {
		hitunggrandtotal();
		$.ajax({
			dataType: "json",
			type: "POST",
			url: base_url + "po/updatebykolom/pph",
			data: {
				isinya: toAngka($(this).val()),
				id: $("#id_header").val(),
			},
			success: function (data) {
				// $("#loadertgldtbt").html("");
				// window.location.reload();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	}
});
$("#cekppn").click(function () {
	var xx = $(this).is(":checked");
	var jumlah = toAngka($("#totalharga").val());
	var diskon = toAngka($("#diskon").val());
	var dpp = (jumlah - diskon) * 0.11;
	if (xx) {
		$("#hargappn").val(rupiah(dpp, ".", ",", 2));
	} else {
		$("#hargappn").val("");
	}
	hitunggrandtotal();
	updatekolomcekppn(xx);
	updatekolomppn(dpp);
});

$("#header_po").focus(function () {
	value_old = $(this).val();
});
$("#catatan1").focus(function () {
	value_old = $(this).val();
});
$("#catatan2").focus(function () {
	value_old = $(this).val();
});
$("#catatan3").focus(function () {
	value_old = $(this).val();
});
$("#header_po").blur(function () {
	updatekolom($("#id_header").val(), "catatan_po", "header_po", $(this).val());
});
$("#catatan1").blur(function () {
	updatekolom($("#id_header").val(), "catatan_po", "catatan1", $(this).val());
});
$("#catatan2").blur(function () {
	updatekolom($("#id_header").val(), "catatan_po", "catatan2", $(this).val());
});
$("#catatan3").blur(function () {
	updatekolom($("#id_header").val(), "catatan_po", "catatan3", $(this).val());
});
function hitunggrandtotal() {
	var jumlah = toAngka($("#totalharga").val());
	var diskon = toAngka($("#diskon").val());
	var ppn = toAngka($("#hargappn").val());
	var pph = toAngka($("#pph").val());
	// alert(jumlah);
	var isi = jumlah - diskon;
	$("#total").val(rupiah(isi, ".", ",", 2));
	$("#jumlah").val(
		rupiah(isi + parseFloat(ppn) - parseFloat(pph), ".", ",", 2),
	);
	// alert(jumlah - diskon);
}
function updatekolomcekppn(nil) {
	var nol = nil == true ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "po/updatebykolom/cekppn",
		data: {
			isinya: nol,
			id: $("#id_header").val(),
		},
		success: function (data) {
			// $("#loadertgldtbt").html("");
			// window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function updatekolomppn(nil) {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "po/updatebykolom/ppn",
		data: {
			isinya: nil,
			id: $("#id_header").val(),
		},
		success: function (data) {
			// $("#loadertgldtbt").html("");
			// window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function getdataib() {
	// alert($("#dept_tuju").val());
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "ib/getdataib",
		data: {
			dept: $("#dept_tuju").val(),
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
