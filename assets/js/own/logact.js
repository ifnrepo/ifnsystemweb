$(window).on("load", function () {
	NProgress.start();
	NProgress.inc(0.5);
});
$(document).ready(function () {
	NProgress.done();
});

// document.addEventListener("DOMContentLoaded", function () {
// 	window.Litepicker &&
// 		new Litepicker({
// 			element: document.getElementById("tglawal"),
// 			format: "DD-MM-YYYY",
// 			buttonText: {
// 				previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
// 				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
// 				nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
// 				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
// 			},
// 		});
// });
// document.addEventListener("DOMContentLoaded", function () {
// 	window.Litepicker &&
// 		new Litepicker({
// 			element: document.getElementById("tglakhir"),
// 			format: "DD-MM-YYYY",
// 			buttonText: {
// 				previousMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
// 				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>`,
// 				nextMonth: `<!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
// 				<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>`,
// 			},
// 		});
// });
// $("#viewharga").click(function () {
// 	// alert($(this).is(":checked"));
// 	var load =
// 		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
// 	$("#loadview").html(load);
// 	var kisi = $(this).is(":checked") ? 1 : 0;
// 	$.ajax({
// 		// dataType: "json",
// 		type: "POST",
// 		url: base_url + "inv/viewharga",
// 		data: {
// 			cek: kisi,
// 		},
// 		success: function (data) {
// 			// alert(data);
// 			window.location.reload();
// 			// $("#body-table").html(data.datagroup).show();
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// });
// $("#katbar").change(function () {
// 	$("#updateinv").click();
// });
$("#tglawal").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
	maxDate: 0,
});
$("#tglakhir").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
	maxDate: 0,
});
// $("#butgo").click(function () {

// 	$.ajax({
// 		dataType: "json",
// 		type: "POST",
// 		url: base_url + "logact/updatetgl",
// 		data: {
// 			tgaw: $("#tglawal").val(),
// 			tgak: $("#tglakhir").val(),
// 			usr: $("#userlog").val(),
// 		},
// 		success: function (data) {
// 			// alert(data);
// 			window.location.reload();
// 			// $("#body-table").html(data.datagroup).show();
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// });
$("#butgo").click(function () {
    var tglawal = $("#tglawal").val();
    var tglakhir = $("#tglakhir").val();
    var userlog = $("#userlog").val();

    $.ajax({
        dataType: "json",
        type: "POST",
        url: base_url + "logact/updatetgl",
        data: {
            tgaw: tglawal,
            tgak: tglakhir,
            usr: userlog,
        },
        success: function (data) {
            var exportExcelUrl = base_url + "logact/excel?tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&userlog=" + userlog;
            $(".btn-export-excel").attr("href", exportExcelUrl);

            var exportPdfUrl = base_url + "logact/cetakpdf?tglawal=" + tglawal + "&tglakhir=" + tglakhir + "&userlog=" + userlog;
            $(".btn-export-pdf").attr("href", exportPdfUrl);

            window.location.reload();
        },
        error: function (xhr, ajaxOptions, thrownError) {
            console.log(xhr.status);
            console.log(thrownError);
        },
    });
});


// $("#updateinv").click(function () {
// // 	var tglawal = $("#tglawal").val();
// // 	var tglakhir = $("#tglakhir").val();
// // 	var currdept = $("#currdept").val();
// // 	var currdept = $("#currdept").val();
// // 	var katbar = $("#katbar").val();
// // 	// var katcari = document.getElementById("caribar").innerHTML;
// // 	var katcari = $("input:radio[name=radios-inline]:checked").val();
// // 	// $("#textcari").val("");
// // 	var textcari = $("#textcari").val();
// // 	if ($("#gbg").is(":checked")) {
// // 		var gbg = 1;
// // 	} else {
// // 		var gbg = 0;
// // 	}
// // 	// alert(gbg);
// // 	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
// // 		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
// // 		return false;
// // 	}
// // 	$.ajax({
// // 		dataType: "json",
// // 		type: "POST",
// // 		url: base_url + "inv/getdata",
// // 		data: {
// // 			tga: tglawal,
// // 			tgk: tglakhir,
// // 			dpt: currdept,
// // 			gbn: gbg,
// // 			kat: katbar,
// // 			kcari: katcari,
// // 			cari: textcari,
// // 		},
// // 		success: function (data) {
// // 			// alert(data);
// // 			window.location.reload();
// // 			// $("#body-table").html(data.datagroup).show();
// // 		},
// // 		error: function (xhr, ajaxOptions, thrownError) {
// // 			console.log(xhr.status);
// // 			console.log(thrownError);
// // 		},
// // 	});
// // });
// // $("#tglawal").change(function () {
// // 	// alert("CUY");
// // });
// // $("#buttoncari").click(function () {
// // 	var tglawal = $("#tglawal").val();
// // 	var tglakhir = $("#tglakhir").val();
// // 	var currdept = $("#currdept").val();
// // 	var currdept = $("#currdept").val();
// // 	var katbar = $("#katbar").val();
// // 	var textcari = $("#textcari").val();
// // 	// var katcari = document.getElementById("caribar").innerHTML;
// // 	var katcari = $("input:radio[name=radios-inline]:checked").val();
// // 	if ($("#gbg").is(":checked")) {
// // 		var gbg = 1;
// // 	} else {
// // 		var gbg = 0;
// // 	}
// // 	// alert(gbg);
// // 	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
// // 		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
// // 		return false;
// // 	}
// // 	$.ajax({
// // 		dataType: "json",
// // 		type: "POST",
// // 		url: base_url + "inv/getdata",
// // 		data: {
// // 			tga: tglawal,
// // 			tgk: tglakhir,
// // 			dpt: currdept,
// // 			gbn: gbg,
// // 			kat: katbar,
// // 			cari: textcari,
// // 			kcari: katcari,
// // 		},
// // 		success: function (data) {
// // 			// alert(data);
// // 			window.location.reload();
// // 			// $("#body-table").html(data.datagroup).show();
// // 		},
// // 		error: function (xhr, ajaxOptions, thrownError) {
// // 			console.log(xhr.status);
// // 			console.log(thrownError);
// // 		},
// // 	});
// // });
// // $("#viewinv").change(function () {
// // 	var load =
// // 		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
// // 	$("#loadview").html(load);
// // 	var kisi = $(this).is(":checked") ? 1 : 0;
// // 	$.ajax({
// // 		dataType: "json",
// // 		type: "POST",
// // 		url: base_url + "inv/viewinv",
// // 		data: {
// // 			cek: kisi,
// // 		},
// // 		success: function (data) {
// // 			// alert(data);
// // 			window.location.reload();
// // 			$("#loadview").html("");
// // 			// $("#body-table").html(data.datagroup).show();
// // 		},
// // 		error: function (xhr, ajaxOptions, thrownError) {
// // 			console.log(xhr.status);
// // 			console.log(thrownError);
// // 		},
// // 	});
// // });
// // $("#caribar").click(function () {
// // 	var dok = document.getElementById("caribar");
// // 	if (dok.innerHTML == "Cari Barang") {
// // 		dok.innerHTML = "Cari SKU";
// // 	} else {
// // 		dok.innerHTML = "Cari Barang";
// // 	}
// });
