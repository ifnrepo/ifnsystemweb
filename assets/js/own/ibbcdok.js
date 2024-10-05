$(document).ready(function () {
	$(".tgl").datepicker({
		autoclose: true,
		format: "dd-mm-yyyy",
		todayHighlight: true,
	});

	loadlampiran();
});
$(".inputangka").on("change click keyup input paste", function (event) {
	$(this).val(function (index, value) {
		return value
			.replace(/(?!\.)\D/g, "")
			.replace(/(?<=\..*)\./g, "")
			.replace(/(?<=\.\d\d).*/g, "")
			.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	});
});
$("#keexcel").click(function () {
	if (
		$("#jns_bc").val() == "" ||
		$("#nomor_aju").val() == "" ||
		$("#tgl_aju").val() == ""
	) {
		pesan("Isi dahulu jenis BC serta nomor/tgl Aju !", "error");
		alert(generatekodeaju());
		return false;
	}
});
$("#jns_bc").change(function () {
	savedata("jns_bc", $(this).val());
});
$("#mtuang").change(function () {
	savedata("mtuang", $(this).val());
	hitungdevisa();
});
$("#nomor_aju").blur(function () {
	if ($(this).val() != "") {
		var jadi = isikurangnol($(this).val());
		$(this).val(jadi);
		savedata("nomor_aju", $(this).val());
	}
});
$("#tgl_aju").change(function () {
	savedata("tgl_aju", tglmysql($(this).val()));
});
// $("#nomor_bc").blur(function(){
//     if($(this).val() != ''){
//         var jadi = isikurangnol($(this).val());
//         $(this).val(jadi) ;
//         savedata('nomor_bc',$(this).val());
//     }
// });
// $("#tgl_bc").change(function(){
//         savedata('tgl_bc',tglmysql($(this).val()));
// });
$("#jns_angkutan").change(function () {
	savedata("jns_angkutan", $(this).val());
});
$("#angkutan").blur(function () {
	savedata("angkutan", $(this).val());
});
$("#no_kendaraan").blur(function () {
	savedata("no_kendaraan", $(this).val());
});
$("#bruto").blur(function () {
	savedata("bruto", toAngka($(this).val()));
});
$("#netto").blur(function () {
	savedata("netto", toAngka($(this).val()));
});
$("#kd_kemasan").change(function () {
	savedata("kd_kemasan", $(this).val());
});
$("#jml_kemasan").blur(function () {
	savedata("jml_kemasan", toAngka($(this).val()));
});
$("#kurs_usd").blur(function () {
	savedata("kurs_usd", toAngka($(this).val()));
});
$("#kurs_idr").blur(function () {
	savedata("kurs_idr", toAngka($(this).val()));
});
$("#devisa_usd").blur(function () {
	savedata("devisa_usd", toAngka($(this).val()));
});
$("#devisa_idr").blur(function () {
	savedata("devisa_idr", toAngka($(this).val()));
});
$("#simpanhakbc").click(function () {
	if ($("#jns_bc").val() == "") {
		$("#keteranganerr").text("Pilih Jenis BC !");
		return false;
	}
	if ($("#nomor_aju").val() == "" || $("#tgl_aju").val() == "") {
		$("#keteranganerr").text("isi Nomor Aju dan Tanggal Aju !");
		return false;
	}
	if ($("#nomor_bc").val() == "" || $("#tgl_bc").val() == "") {
		$("#keteranganerr").text("isi Nomor BC dan Tanggal BC !");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/simpandatanobc",
		data: {
			id: $("#id_header").val(),
			jns: $("#jns_bc").val(),
			aju: $("#nomor_aju").val(),
			tglaju: $("#tgl_aju").val(),
			bc: $("#nomor_bc").val(),
			tglbc: $("#tgl_bc").val(),
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
function savedata(kolom, data) {
	$("#keteranganerr").text("Loading ..!");
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/updatebykolom/" + kolom,
		data: {
			id: $("#id_header").val(),
			isinya: data,
		},
		success: function (data) {
			$("#keteranganerr").text("Data Saved ..!");
			setTimeout(() => {
				$("#keteranganerr").text("");
			}, 3000);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function generatekode() {
	var nol = "0";
	var jnsbc =
		$("#jns_bc").val() == ""
			? "000000"
			: nol.repeat(6 - $("#jns_bc").val().length) + $("#jns_bc").val();
	var tglbc =
		$("#tgl_bc").val() == ""
			? "00000000"
			: tglmysql($("#tgl_bc").val()).replace(/-/g, "");
	var nobc = $("#nomor_bc").val() == "" ? "000000" : $("#nomor_bc").val();
	// alert(jnsbc + "-010017-" + tglbc + "-" + nobc);
	return jnsbc + "-010017-" + tglbc + "-" + nobc;
}
function generatekodeaju() {
	var nol = "0";
	var jnsbc =
		$("#jns_bc").val() == ""
			? "000000"
			: nol.repeat(6 - $("#jns_bc").val().length) + $("#jns_bc").val();
	var tglbc =
		$("#tgl_aju").val() == ""
			? "00000000"
			: tglmysql($("#tgl_aju").val()).replace(/-/g, "");
	var nobc =
		$("#nomor_aju").val() == ""
			? "000000"
			: nol.repeat(6 - $("#nomor_aju").val().length) + $("#nomor_aju").val();
	// alert(jnsbc + "-010017-" + tglbc + "-" + nobc);
	return jnsbc + "-010017-" + tglbc + "-" + nobc;
}
function isikurangnol(val) {
	var nol = "0";
	var jnsbc = nol.repeat(6 - val.length) + val;
	return jnsbc;
}
function hitungdevisa() {
	var xu = $("#mtuang").val();
	switch (xu) {
		case "1": //IDR
			tothar = parseFloat(toAngka($("#totalharga").val()));
			devidr = parseFloat(toAngka($("#kurs_idr").val()));
			devusd = parseFloat(toAngka($("#kurs_usd").val()));
			$("#devisa_usd").val(rupiah((tothar / devusd).toFixed(2), ".", ",", 3));
			$("#devisa_idr").val(rupiah((tothar * devidr).toFixed(2), ".", ",", 2));
			break;
		case "2": //USD
			tothar = parseFloat(toAngka($("#totalharga").val()));
			devidr = parseFloat(toAngka($("#kurs_idr").val()));
			devusd = parseFloat(toAngka($("#kurs_usd").val()));
			$("#devisa_idr").val(rupiah((tothar * devusd).toFixed(2), ".", ",", 3));
			$("#devisa_usd").val(rupiah((tothar / devidr).toFixed(2), ".", ",", 2));
			break;
		default:
			break;
	}
	$("#devisa_idr").blur();
	$("#devisa_usd").blur();
}
function loadlampiran() {
	var id = $("#id_header").val();
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/getdatalampiran/" + id,
		data: {},
		success: function (data) {
			// window.location.reload();
			$("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
