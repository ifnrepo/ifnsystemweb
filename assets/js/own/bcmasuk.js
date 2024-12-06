$(document).ready(function () {
	// alert("OKE");
	var jmlrek = $("#jumlahrek").text();
	var jmlpc = $("#jumlahpc").text();
	var jmlkg = $("#jumlahkg").text();
	$("#jumlahrekod").text(rupiah(jmlrek, ".", ",", 0));
	$("#jumlahpcs").text(rupiah(jmlpc, ".", ",", 0));
	$("#jumlahkgs").text(rupiah(jmlkg, ".", ",", 2));
});
var butoncari = false;
$("#buttoncaribcmasuk").click(function () {
	butoncari = true;
	$("#updatebcmasuk").click();
});
document.getElementById("textcari").addEventListener("keypress", function (e) {
	if (e.key == "Enter") {
		$("#buttoncaribcmasuk").click();
	}
});
$("#updatebcmasuk").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var jnsbc = $("#jns_bc").val();
	if (butoncari == true) {
		var carinopen = $("#textcari").val();
	} else {
		var carinopen = null;
		$("#textcari").val("");
	}
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
			nopen: carinopen,
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



