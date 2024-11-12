$(window).on("load", function () {
	NProgress.start();
	NProgress.inc(0.5);
	$("#jumlahrekod").text("Load data ..");
	$("#jumlahpcs").text("Load data ..");
	$("#jumlahkgs").text("Load data ..");
});
$(document).ready(function () {
	NProgress.done();
	var jmlrek = $("#jumlahrek").text();
	var jmlpc = $("#jumlahpc").text();
	var jmlkg = $("#jumlahkg").text();
	$("#jumlahrekod").text(rupiah(jmlrek, ".", ",", 0));
	$("#jumlahpcs").text(rupiah(jmlpc, ".", ",", 2));
	$("#jumlahkgs").text(rupiah(jmlkg, ".", ",", 2));
});
$("#textcari").blur(function () {
	var isi = $(this).val().trim();
	$(this).val(isi);
});
$("#viewharga").click(function () {
	// alert($(this).is(":checked"));
	var load =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadview").html(load);
	var kisi = $(this).is(":checked") ? 1 : 0;
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "inv/viewharga",
		data: {
			cek: kisi,
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
});
$("#katbar").change(function () {
	$("#updateinv").click();
});
$("#nomorbcnya").change(function () {
	$("#updateinv").click();
});
$("#tglawal").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
	maxDate: 0,
});
$("#updateinv").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	// var katcari = document.getElementById("caribar").innerHTML;
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	// $("#textcari").val("");
	var nomorbcnya = $("#nomorbcnya").val();
	var textcari = $("#textcari").val();
	if ($("#gbg").is(":checked")) {
		var gbg = 1;
	} else {
		var gbg = 0;
	}
	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdata",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			gbn: gbg,
			kat: katbar,
			kcari: katcari,
			cari: textcari,
			nobcnya: nomorbcnya,
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
});
$("#updateinvwip").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	// var katcari = document.getElementById("caribar").innerHTML;
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	// $("#textcari").val("");
	var textcari = $("#textcari").val();

	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdatawip",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			kat: katbar,
			kcari: katcari,
			cari: textcari,
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
});
$("#tglawal").change(function () {
	// alert("CUY");
});
$("#buttoncari").click(function () {
	$("#updateinv").click();
	// var tglawal = $("#tglawal").val();
	// var tglakhir = $("#tglakhir").val();
	// var currdept = $("#currdept").val();
	// var currdept = $("#currdept").val();
	// var katbar = $("#katbar").val();
	// var textcari = $("#textcari").val();
	// // var katcari = document.getElementById("caribar").innerHTML;
	// var katcari = $("input:radio[name=radios-inline]:checked").val();
	// if ($("#gbg").is(":checked")) {
	// 	var gbg = 1;
	// } else {
	// 	var gbg = 0;
	// }
	// alert("xxx");
	// // alert(gbg);
	// if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
	// 	pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
	// 	return false;
	// }
	// $.ajax({
	// 	dataType: "json",
	// 	type: "POST",
	// 	url: base_url + "inv/getdata",
	// 	data: {
	// 		tga: tglawal,
	// 		tgk: tglakhir,
	// 		dpt: currdept,
	// 		gbn: gbg,
	// 		kat: katbar,
	// 		cari: textcari,
	// 		kcari: katcari,
	// 	},
	// 	success: function (data) {
	// 		// alert(data);
	// 		window.location.reload();
	// 		// $("#body-table").html(data.datagroup).show();
	// 	},
	// 	error: function (xhr, ajaxOptions, thrownError) {
	// 		console.log(xhr.status);
	// 		console.log(thrownError);
	// 	},
	// });
});
$("#viewinv").change(function () {
	var load =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadview").html(load);
	var kisi = $(this).is(":checked") ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/viewinv",
		data: {
			cek: kisi,
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
			$("#loadview").html("");
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
// $("#caribar").click(function () {
// 	var dok = document.getElementById("caribar");
// 	if (dok.innerHTML == "Cari Barang") {
// 		dok.innerHTML = "Cari SKU";
// 	} else {
// 		dok.innerHTML = "Cari Barang";
// 	}
// });
