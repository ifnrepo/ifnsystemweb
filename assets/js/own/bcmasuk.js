$(document).ready(function () {
	// alert("OKE");
	var jmlrek = $("#jumlahrek").text();
	var jmlpc = $("#jumlahpc").text();
	var jmlkg = $("#jumlahkg").text();
	$("#jumlahrekod").text(rupiah(jmlrek, ".", ",", 0));
	$("#jumlahpcs").text(rupiah(jmlpc, ".", ",", 0));
	$("#jumlahkgs").text(rupiah(jmlkg, ".", ",", 2));
});
$("#updatebcmasuk").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var jnsbc = $("#jns_bc").val();
	// var katbar = $("#katbar").val();
	// // var katcari = document.getElementById("caribar").innerHTML;
	// var katcari = $("input:radio[name=radios-inline]:checked").val();
	// // $("#textcari").val("");
	// var nomorbcnya = $("#nomorbcnya").val();
	// var textcari = $("#textcari").val();
	// if ($("#gbg").is(":checked")) {
	// 	var gbg = 1;
	// } else {
	// 	var gbg = 0;
	// }
	// alert(jnsbc);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "bcmasuk/getdata",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			jns: jnsbc,
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
