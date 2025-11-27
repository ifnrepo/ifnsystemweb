$(document).ready(function () {
	var jmlpc = $("#jumlahpc").text();
	// var jmlin = $("#jmlin").text();
	// var jmlout = $("#jmlout").text();
	// var jmladj = $("#jmladj").text();
	$("#jumlahpcs").text(rupiah(jmlpc, ".", ",", 0));
	// $("#jmline").text("In : " + rupiah(jmlin, ".", ",", 0));
	// $("#jmloute").text("Out : " + rupiah(jmlout, ".", ",", 0));
	// $("#jmladje").text("Adj : " + rupiah(jmladj, ".", ",", 0));
	// $("#jmlsaldo").text(
	// 	"Saldo : " +
	// 		rupiah(
	// 			parseFloat(jmlsaw) +
	// 				parseFloat(jmlin) -
	// 				parseFloat(jmlout) -
	// 				parseFloat(jmladj),
	// 			".",
	// 			",",
	// 			0,
	// 		),
	// );
});
$("#updatemesin").click(function(){
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var milik = $("#lokasimesin").val();
	var kat = $("#katbarang").val();

	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "error");
		return false;
	}
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "invmesin/getdata",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			msn: milik,
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
// $("#thperiode").change(function () {
// 	$.ajax({
// 		// dataType: "json",
// 		type: "POST",
// 		url: base_url + "invmesin/ubahperiode",
// 		data: {
// 			th: $(this).val(),
// 			lok: $("#lokasimesin").val(),
// 			bl: $("#blperiode").val(),
// 		},
// 		success: function (data) {
// 			window.location.reload();
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// });
// $("#blperiode").change(function () {
// 	$("#thperiode").change();
// });
// $("#lokasimesin").change(function () {
// 	$("#thperiode").change();
// });
