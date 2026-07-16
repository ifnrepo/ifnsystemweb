$(document).ready(function () {
	// alert("OKE");
	var jmlrek = $("#jumlahrek").text();
	var jmlpc = $("#jumlahpc").text();
	var jmlkg = $("#jumlahkg").text();
	var jmlidr = $("#jumlahid").text();
	var jmlusd = $("#jumlahus").text();
	$("#jumlahrekod").text(rupiah(jmlrek, ".", ",", 0));
	$("#jumlahpcs").text(rupiah(jmlpc, ".", ",", 0));
	$("#jumlahkgs").text(rupiah(jmlkg, ".", ",", 2));
	$("#jumlahidr").text(rupiah(jmlidr, ".", ",", 2));
	$("#jumlahusd").text(rupiah(jmlusd, ".", ",", 2));
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
$("#tglawal").on('change',function(){
	// alert($(this).val());
	var datestr = $(this).val();
	const split = datestr.split('-');
	const today = new Date(split[2],split[1],split[0]);	

	const hasil = new Date(today.getFullYear(),today.getMonth(),0);
	var m = hasil.getMonth()+1;
	m = m > 9 ? m : "0"+m;

	var cok = hasil.getDate()+'-'+m+'-'+hasil.getFullYear();
    console.log(cok);
	$("#tglakhir").val(cok);
	$("#tglakhir").change();
})
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
