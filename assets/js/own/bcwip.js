$(document).ready(function () {
	// alert("OKE");
	var jmlrek = $("#jumlahrek").text();
	var jmlpc = $("#jumlahpc").text();
	var jmlkg = $("#jumlahkg").text();
	// var jmlidr = $("#jumlahid").text();
	// var jmlusd = $("#jumlahus").text();
	$("#jumlahrekod").text(rupiah(jmlrek, ".", ",", 0));
	$("#jumlahpcs").text(rupiah(jmlpc, ".", ",", 0));
	$("#jumlahkgs").text(rupiah(jmlkg, ".", ",", 2));
	// $("#jumlahidr").text(rupiah(jmlidr, ".", ",", 2));
	// $("#jumlahusd").text(rupiah(jmlusd, ".", ",", 2));
});
// var butoncari = false;
// $("#buttoncaribckeluar").click(function () {
// 	butoncari = true;
// 	$("#updatebckeluar").click();
// });

$("#updatebcwip").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var milik = $("#kepemilikan").val();
	var kat = $("#katbarang").val();
	var depe = $("#currdept").val();

	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "error");
		return false;
	}

	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "bcwip/getdata",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			punya: milik,
			katbar: kat,
			curr: depe,
			pcskgs: $("#pcskgsbcwip").val()
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
