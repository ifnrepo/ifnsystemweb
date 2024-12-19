$(window).on("load", function () {
	NProgress.start();
	NProgress.inc(0.5);
	$("#jumlahrekod").text("Load data ..");
	$("#jumlahpcs").text("Load data ..");
	$("#jumlahkgs").text("Load data ..");
});
$(document).ready(function () {
	NProgress.done();

	var arrurl = window.location.href.split("/");
	addnumber = arrurl[2] == "localhost" ? 0 : 0;
	// alert(arrurl[4 + addnumber]);
	if (
		$("#paramload").val() != "" &&
		(arrurl[4 + addnumber] == "bcwip" || arrurl[4 + addnumber] == "bcwip#")
	) {
		loadtable();
	}
	if (
		$("#paramload").val() != "" &&
		(arrurl[4 + addnumber] == "bcgf" || arrurl[4 + addnumber] == "bcgf#")
	) {
		loadtablegf();
	}
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
$("#kontrakbcnya").change(function () {
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
	var ifndl = $("#ifndln").val();
	// var katcari = document.getElementById("caribar").innerHTML;
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	// $("#textcari").val("");
	var nomorbcnya = $("#nomorbcnya").val();
	var kontrakbcnya = $("#kontrakbcnya").val();
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
			ifndln: ifndl,
			kontbc: kontrakbcnya,
		},
		success: function (data) {
			// alert(data);
			console.log("KONTRAK" + kontrakbcnya);
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
$("#updateinvwipbaru").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	var textcari = $("#textcari").val();
	var ifndl = $("#ifndln").val();

	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdatawipbaru",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			kat: katbar,
			kcari: katcari,
			cari: textcari,
			ifndln: ifndl,
		},
		success: function (data) {
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
			// loadtable();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#updateinvgf").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	var textcari = $("#textcari").val();
	var ifndl = $("#ifndln").val();

	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdatagf",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			kat: katbar,
			kcari: katcari,
			cari: textcari,
			ifndln: ifndl,
		},
		success: function (data) {
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
			// loadtable();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
var table;
function loadtable() {
	var table = $("#tabelnya").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "bcwip/get_data_wip",
			type: "POST",
			data: function (d) {
				d.filter_kategori = $("#katbar").val();
				d.xzzz = "OME";
				console.log("Filter kategori:", d.filter_kategori);
				console.log(d.zzz);
			},
			callback: function (x) {
				alert(x);
			},
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
				class: "borderbottomred",
			},
			{
				targets: [1],
				class: "borderbottomred",
			},
			{
				targets: [2],
				class: "borderbottomred",
			},
			{
				targets: [3],
				class: "borderbottomred",
			},
			{
				targets: [4],
				class: "borderbottomred",
			},
			{
				targets: [5],
				class: "borderbottomred",
			},
			{
				targets: [6],
				class: "text-right borderbottomred",
			},
			{
				targets: [7],
				class: "text-right borderbottomred",
			},
			{
				targets: [8],
				class: "text-center borderbottomred",
			},
		],
		pageLength: 50,
		scrollY: 500,
		paging: false,
		searching: false,
		// info: false,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});
	// $("#katbar").on("change", function () {
	// 	table.ajax.reload();
	// });
}
function loadtablegf() {
	var table = $("#tabelnya").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "bcgf/get_data_gf",
			type: "POST",
			data: function (d) {
				d.filter_kategori = $("#katbar").val();
				console.log("Filter kategori:", d.filter_kategori);
			},
			callback: function (x) {
				alert(x);
			},
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
				class: "borderbottomred",
			},
			{
				targets: [1],
				class: "borderbottomred",
			},
			{
				targets: [2],
				class: "borderbottomred",
			},
			{
				targets: [3],
				class: "borderbottomred",
			},
			{
				targets: [4],
				class: "borderbottomred",
			},
			{
				targets: [5],
				class: "borderbottomred",
			},
			{
				targets: [6],
				class: "borderbottomred",
			},
			{
				targets: [7],
				class: "text-right borderbottomred",
			},
			{
				targets: [8],
				class: "text-right borderbottomred",
			},
			{
				targets: [9],
				class: "text-right borderbottomred",
			},
			{
				targets: [10],
				class: "text-center borderbottomred",
			},
		],
		pageLength: 50,
		scrollY: 500,
		paging: false,
		searching: false,
		// info: false,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});
	// $("#katbar").on("change", function () {
	// 	table.ajax.reload();
	// });
}
$("#tglawal").change(function () {
	// alert("CUY");
});
$("#buttoncari").click(function () {
	$("#updateinv").click();
});
$("#buttoncarigf").click(function () {
	$("#updateinvgf").click();
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
