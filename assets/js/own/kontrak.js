$(document).ready(function () {
	// Load detail
	var url = window.location.href;
	var pisah = url.split("/");
	// alert(pisah[5]);
	if (pisah[2] == "localhost") {
		if (pisah[5] == "editdata" || pisah[5] == "adddata") {
			loaddetail();
		}
	} else {
		if (pisah[5] == "editdata" || pisah[5] == "adddata") {
			loaddetail();
		}
	}
});
$(".tglmode").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
});
$("#butgo").click(function () {
	var dept = $("#deptkontrak").val();
	// if (dept == "" || dept == null) {
	// 	pesan("Pilih Nama Rekanan terlebih dahulu", "info");
	// } else {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "kontrak/getdata",
		data: {
			dept_id: dept,
			jnsbc: $("#jns_bc").val(),
			status: $("#statuskontrak").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
	// }
});
$("#resetdata").click(function () {
	window.location.reload();
});
$("#simpandata").click(function () {
	if ($("#proses").val() == "") {
		pesan("Isi Nama Proses", "info");
		return false;
	}
	if (
		($("#pcs").val() == "" ||
			$("#pcs").val() == "0" ||
			$("#pcs").val().trim() == "-") &&
		($("#kgs").val() == "" ||
			$("#kgs").val() == "0" ||
			$("#kgs").val().trim() == "-")
	) {
		pesan("Pcs / Kgs Kosong", "info");
		return false;
	}

	document.formkontrak.submit();
});
$(".loss-input").blur(function () {
	var id = $(this).attr("id");
	var isi = $(this).val();
	simpankedatabase("tb_kontrak", id, isi, $("#id").val());
});
$(".loss-inputtgl").change(function () {
	var id = $(this).attr("id");
	var isi = tglmysql($(this).val());
	simpankedatabase("tb_kontrak", id, isi, $("#id").val());
});
$(".loss-inputangka").blur(function () {
	var id = $(this).attr("id");
	var isi = toAngka($(this).val());
	simpankedatabase("tb_kontrak", id, isi, $("#id").val());
});
// function toAngka(rp) {
// 	if (rp == "" || rp.trim() == "-") {
// 		return 0;
// 	} else {
// 		return rp.replace(/,*|\D/g, "");
// 	}
// }
function simpankedatabase(namatabel, namakolom, isi, id) {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "kontrak/simpankedatabase",
		data: {
			tbl: namatabel,
			kolom: namakolom,
			data: isi,
			aidi: id,
		},
		success: function (data) {
			// window.location.reload();
			// alert(data.datagroup);
			// $("#body-table").html(data.datagroup).show();
			// $("#jumlahrekod").text(rupiah(data.jmlrek, ".", ",", 0));
			// $("#jumlahpcs").text(rupiah(data.jmlpcs, ".", ",", 0));
			// $("#jumlahkgs").text(rupiah(data.jmlkgs, ".", ",", 2));
			// $("#jumlahrekode").text(rupiah(data.jmlreke, ".", ",", 0));
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loaddetail() {
	var kode = $("#id").val();
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "kontrak/loaddetailkontrak",
		data: {
			id: kode,
			mode: $("#mode").val(),
		},
		success: function (data) {
			// alert(data.datagroup);
			$("#body-table").html(data.datagroup).show();
			// $("#jumlahrekod").text(rupiah(data.jmlrek, ".", ",", 0));
			// $("#jumlahpcs").text(rupiah(data.jmlpcs, ".", ",", 0));
			// $("#jumlahkgs").text(rupiah(data.jmlkgs, ".", ",", 2));
			// $("#jumlahrekode").text(rupiah(data.jmlreke, ".", ",", 0));
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
