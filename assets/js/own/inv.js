$(window).on('load', function () {
	NProgress.start();
});
$(document).ready(function () {
	NProgress.done();
});
document.addEventListener("DOMContentLoaded", function () {
	window.Litepicker &&
		new Litepicker({
			element: document.getElementById("tglawal"),
			format: "DD-MM-YYYY",
			buttonText: {
				previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
				nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
			},
		});
});
document.addEventListener("DOMContentLoaded", function () {
	window.Litepicker &&
		new Litepicker({
			element: document.getElementById("tglakhir"),
			format: "DD-MM-YYYY",
			buttonText: {
				previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
				nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
			},
		});
});
$("#updateinv").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	$("#textcari").val('');
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
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
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
			cari: textcari
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
})
