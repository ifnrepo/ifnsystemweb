$(document).ready(function () {
	$(".tgl").datepicker({
		showButtonPanel: true,
		autoclose: true,
		format: "dd-mm-yyyy",
		todayHighlight: true,
		todayBtn: "linked",
  		// clearBtn: true,
	});

	$(".pelabuhan").select2({
		selectionCssClass: "btn-flat font-bold text-black",
		minimumInputLength: 2,
		tags: [],
		ajax: {
			url: base_url + "/Ib/caripelabuhan",
			dataType: "json",
			data: function (params) {
				var query = {
					search: params.term,
					type: "user_search",
				};
				// Query parameters will be ?search=[term]&type=user_search
				return query;
			},
			processResults: function (data) {
				return {
					results: data,
				};
			},
		},
		cache: true,
		// placeholder: "Search for a user...",
	});
	loadlampiran();
	loadkontainer();
	loadentitas();

	var errosimpan = $("#errorsimpan").val();
	var pesan = $("#pesanerror").val();
	if (errosimpan == 1) {
		// pesan("PESAN :", "error");
		alert("PESAN : " + pesan);
	}
	if (errosimpan == 2) {
		// pesan("PESAN :", "error");
		alert("PESAN : " + pesan);
	}

	// Set the date we're counting down to
	var countDownDate = new Date($("#updateon").val()).getTime();
	// Update the count down every 1 second
	var x = setInterval(function () {
		// Get today's date and time
		var now = new Date().getTime();

		// Find the distance between now and the count down date
		var distance = countDownDate - now;

		// Time calculations for days, hours, minutes and seconds
		var days = Math.floor(distance / (1000 * 60 * 60 * 24));
		var hours = Math.floor(
			(distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60),
		);
		var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
		var seconds = Math.floor((distance % (1000 * 60)) / 1000);

		// Display the result in the element with id="demo"
		document.getElementById("timetoexpired").innerHTML =
			"Token Expired On 0" + hours + ":" + minutes + ":" + seconds;
		document.getElementById("adaapadengantoken").innerHTML =
			"DATA TOKEN ALREADY SET ";
		$("#cekdata").removeClass("disabled");
		// If the count down is finished, write some text
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("timetoexpired").innerHTML = "TOKEN EXPIRED";
			document.getElementById("adaapadengantoken").innerHTML =
				"DATA TOKEN NOT SET";
			if (!$("#cekdata").hasClass("disabled")) {
				$("#cekdata").addClass("disabled");
			}
		}
	}, 1000);

	$("#kolomasuransi").removeClass("hilang");
	$("#kolomfreight").removeClass("hilang");
	if ($("#kode_incoterm").val() == "CFR") {
		$("#kolomasuransi").addClass("hilang");
	} else if (
		$("#kode_incoterm").val() == "FOB" ||
		$("#kode_incoterm").val() == ""
	) {
		$("#kolomfreight").addClass("hilang");
		$("#kolomasuransi").addClass("hilang");
	}
	var isikonversi = $("#totalkonversi").text();
	if(isikonversi=='-'){
		$("#lampirandankonversi").addClass('disabled');
		$("#perhitunganjaminan").addClass('disabled');
		$("#lembarperijinan").addClass('disabled');
	}
	$("#jumlahpcsdetailbarang").text($("#pcssum").text())
	$("#jumlahkgsdetailbarang").text($("#txtsum").text())
	$("#jumlahkgsdetailbarang2").text($("#totalkonversi").text())

	if($("#tgl_aju").val() == ''){
		$("#tombolhitung").addClass('disabled');
	}else{
		$("#tombolhitung").removeClass('disabled');
	}
});
$("#getnomoraju").click(function () {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/getnomoraju",
		data: {
			jns: $("#jns_bc").val(),
		},
		success: function (data) {
			// alert(data);
			$("#nomor_aju").val(data);
			savedata("nomor_aju", data);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
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
	var halaman = $("#namahalaman").val();
	var mode = $("#modehalaman").val() != "" ? "/1" : "";
	savedata("jns_bc", $(this).val());
	if ($(this).val() == "23") {
		isilampiran($("#id_header").val());
	} else {
		setTimeout(() => {
			window.location.href =
				base_url + halaman + "/isidokbc/" + $("#id_header").val() + mode;
		}, 500);
	}
});
$("#nomor_sj").change(function () {
	savedata("nomor_sj", $(this).val());
});
$("#tgl_sj").change(function () {
	savedata("tgl_sj", tglmysql($(this).val()));
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
$("#jns_angkutan").change(function () {
	savedata("jns_angkutan", $(this).val());
});
$("#angkutan").blur(function () {
	savedata("angkutan", $(this).val());
});
$("#no_kendaraan").blur(function () {
	savedata("no_kendaraan", $(this).val());
});
$("#ukuran_kontainer").change(function () {
	savedata("ukuran_kontainer", $(this).val());
});
$("#nomor_kontainer").blur(function () {
	savedata("nomor_kontainer", $(this).val());
});
$("#bendera_angkutan").change(function () {
	savedata("bendera_angkutan", $(this).val());
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
	setTimeout(() => {
		hitungdevisa();
	}, 500);
});
$("#kurs_idr").blur(function () {
	savedata("kurs_idr", toAngka($(this).val()));
	setTimeout(() => {
		hitungdevisa();
	}, 500);
	// $("#mtuang").change();
});
$("#devisa_usd").blur(function () {
	savedata("devisa_usd", toAngka($(this).val()));
});
$("#devisa_idr").blur(function () {
	savedata("devisa_idr", toAngka($(this).val()));
});
$("#nomor_po").blur(function () {
	savedata("nomor_po", $(this).val());
});
$("#tgl_po").change(function () {
	savedata("tgl_po", tglmysql($(this).val()));
});
$("#nomor_inv").blur(function () {
	savedata("nomor_inv", $(this).val());
});
$("#tgl_inv").change(function () {
	savedata("tgl_inv", tglmysql($(this).val()));
});
$("#nomor_pl").blur(function () {
	savedata("nomor_pl", $(this).val());
});
$("#tgl_pl").change(function () {
	savedata("tgl_pl", tglmysql($(this).val()));
});
$("#nomor_blawb").blur(function () {
	savedata("nomor_blawb", $(this).val());
});
$("#tgl_blawb").change(function () {
	savedata("tgl_blawb", tglmysql($(this).val()));
});
$("#bc11").blur(function () {
	savedata("bc11", $(this).val());
});
$("#tgl_bc11").change(function () {
	savedata("tgl_bc11", tglmysql($(this).val()));
});
$("#nomor_posbc11").blur(function () {
	savedata("nomor_posbc11", $(this).val());
});
// $("#nomor_subposbc11").change(function () {
// 	savedata("nomor_subposbc11", $(this).val());
// });
$("#exnomor_bc").blur(function () {
	savedata("exnomor_bc", $(this).val());
});
$("#extgl_bc").change(function () {
	savedata("extgl_bc", tglmysql($(this).val()));
});
$("#ket_kemasan").blur(function () {
	savedata("ket_kemasan", $(this).val());
});
$("#tg_jawab").blur(function () {
	savedata("tg_jawab", $(this).val());
});
$("#jabat_tg_jawab").blur(function () {
	savedata("jabat_tg_jawab", $(this).val());
});
$("#nilai_pab").on("keypress", function (e) {
	if (e.keyCode == 13) {
		savedata("nilai_pab", toAngka($(this).val()));
		$("#nilai_pab").blur();
	}
});
$("#nilai_pab").blur(function () {
	savedata("nilai_pab", toAngka($(this).val()));
	hitungdevisa();
});
$("#nilai_serah").on("keypress", function (e) {
	if (e.keyCode == 13) {
		savedata("nilai_serah", toAngka($(this).val()));
		$("#nilai_serah").blur();
	}
});
$("#nilai_serah").blur(function () {
	savedata("nilai_serah", toAngka($(this).val()));
	// hitungdevisa();
});
$("#pelabuhan_muat").change(function () {
	savedata("pelabuhan_muat", $(this).val());
});
// $("#pelabuhan_muat").val("").trigger("change");
$("#pelabuhan_bongkar").change(function () {
	savedata("pelabuhan_bongkar", $(this).val());
});
$("#kode_incoterm").change(function () {
	savedata("kode_incoterm", $(this).val());
	$("#kolomasuransi").removeClass("hilang");
	$("#kolomfreight").removeClass("hilang");
	if ($(this).val() == "CFR") {
		savedata("asuransi", 0);
		$("#kolomasuransi").addClass("hilang");
	} else if ($(this).val() == "FOB" || $(this).val() == "") {
		savedata("asuransi", 0);
		savedata("freight", 0);
		$("#kolomfreight").addClass("hilang");
		$("#kolomasuransi").addClass("hilang");
	}
});
$("#freight").change(function () {
	savedata("freight", toAngka($(this).val()));
});
$("#asuransi").change(function () {
	savedata("asuransi", toAngka($(this).val()));
});
$("#jenis_kontainer").change(function () {
	savedata("jenis_kontainer", $(this).val());
});
$("#tipe_kontainer").change(function () {
	savedata("tipe_kontainer", $(this).val());
});
$("#simpanhakbc").click(function () {
	cekkolom();
});
$("#getblawb").click(function () {
	if ($("#nomor_blawb").val() == "") {
		pesan("Isi Nomor BL", "error");
		return;
	}
	if ($("#tgl_blawb").val() == "" || $("#tgl_blawb").val() == "00-00-0000") {
		pesan("Isi Tanggal BL", "error");
		return;
	}
	// $("#getblawbasli").attr(
	// 	"href",
	// 	base_url +
	// 		"ib/getdatablawb/" +
	// 		$("#nomor_blawb").val() +
	// 		"/" +
	// 		$("#tgl_blawb").val() +
	// 		"/" +
	// 		$("#id_header").val(),
	// );
	setTimeout(() => {
		// alert("PASANG");
		window.location.href =
			base_url +
			"ib/getdatablawb/" +
			$("#nomor_blawb").val() +
			"/" +
			$("#tgl_blawb").val() +
			"/" +
			$("#id_header").val();
	}, 500);
});
$("#cekdata").click(function () {
	var cek = cekkolom(1);
	if (cek == 1) {
		$("#kirimkeceisa").click();
	} else {
		cekkolom();
	}
});
$("#cekndpbm").click(function () {
	// alert("Akan dicek kemudian");
});
function isilampiran(ide) {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/isilampiran23",
		data: {
			id: ide,
		},
		success: function (data) {
			var halaman = $("#namahalaman").val();
			$("#keteranganerr").text("Data Saved ..!");
			// pesan("Data Saved ..!", "success");
			setTimeout(() => {
				window.location.href =
					base_url + halaman + "/isidokbc/" + $("#id_header").val();
			}, 500);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function cekkolom(mode) {
	if ($("#jns_bc").val() == "") {
		// $("#keteranganerr").text("Pilih Jenis BC !");
		pesan("Pilih Jenis BC !", "error");
		return false;
	}
	if ($("#nomor_aju").val() == "" || $("#tgl_aju").val() == "") {
		// $("#keteranganerr").text("isi Nomor Aju dan Tanggal Aju !");
		pesan("isi Nomor Aju dan Tanggal Aju !", "error");
		return false;
	}
	if (toAngka($("#bruto").val()) == 0 || toAngka($("#netto").val()) == 0) {
		// $("#keteranganerr").text("Jumlah Bruto dan Netto Harus di isi !");
		pesan("Jumlah Bruto dan Netto Harus di isi !", "error");
		return false;
	}
	if ($("#bruto").val() == "0" || $("#netto").val() == "0") {
		// $("#keteranganerr").text("Jumlah Bruto dan Netto Harus di isi !");
		pesan("Jumlah Bruto dan Netto Harus di isi !", "error");
		return false;
	}
	if ($("#txtsum").text() != $("#netto").val()) {
		// $("#keteranganerr").text("Cek Nilai Pabean (CIF) dengan Detail Harga !");
		pesan("Cek Jumlah Netto dan Jumlah detail harus Sama", "error");
		return false;
	}
	if ($("#jns_bc").val() == "261") {
		if ($("#sumdetailbc").val() != $("#nilai_pab").val()) {
			// $("#keteranganerr").text("Cek Nilai Pabean (CIF) dengan Detail Harga !");
			pesan("Cek Nilai Pabean (CIF) dengan Detail Harga BC !", "error");
			return false;
		}
	} else {
		if ($("#jns_bc").val() == "25" || $("#jns_bc").val() == "41") {
			if ($("#sumdetail").val() != $("#nilai_serah").val()) {
				// $("#keteranganerr").text("Cek Nilai Pabean (CIF) dengan Detail Harga !");
				pesan("Cek Nilai Pabean (CIF) dengan Detail Harga !", "error");
				return false;
			}
		}else{
			if ($("#sumdetail").val() != $("#nilai_pab").val()) {
				// $("#keteranganerr").text("Cek Nilai Pabean (CIF) dengan Detail Harga !");
				pesan("Cek Nilai Pabean (CIF) dengan Detail Harga !", "error");
				return false;
			}
		}
	}
	if ($("#tg_jawab").val() == "") {
		// $("#keteranganerr").text("Isi Nama Penanggung Jawab !");
		pesan("Isi Nama Penanggung Jawab !", "error");
		return false;
	}
	if ($("#jabat_tg_jawab").val() == "") {
		// $("#keteranganerr").text("Isi Jabatan Penanggung Jawab !");
		pesan("Isi Jabatan Penanggung Jawab !", "error");
		return false;
	}
	if ($("#jmllampiran").val() == "0") {
		// $("#keteranganerr").text("Isi Lampiran Dokumen !");
		pesan("Isi Lampiran Dokumen !", "error");
		return false;
	}
	if ($("#jns_angkutan").val() == "") {
		// $("#keteranganerr").text("Isi Lampiran Dokumen !");
		pesan("Jenis Angkutan harus di isi !", "error");
		return false;
	}
	if ($("#angkutan").val() == "") {
		// $("#keteranganerr").text("Isi Lampiran Dokumen !");
		pesan("Angkutan harus di isi !", "error");
		return false;
	}
	if ($("#no_kendaraan").val() == "") {
		// $("#keteranganerr").text("Isi Lampiran Dokumen !");
		pesan("Nomor Angkutan harus di isi !", "error");
		return false;
	}
	if ($("#jml_kemasan").val() == "0") {
		// $("#keteranganerr").text("Isi Lampiran Dokumen !");
		pesan("Jumlah Kemasan harus di isi !", "error");
		return false;
	}
	if ($("#kd_kemasan").val() == "") {
		// $("#keteranganerr").text("Isi Lampiran Dokumen !");
		pesan("Jenis Kemasan harus di isi !", "error");
		return false;
	}
	// Untuk cek BC 23
	if ($("#jns_bc").val() == "23") {
		// $("#pesanerror").val("");
		if ($("#pelabuhan_muat").val() == "") {
			pesan("Pelabuhan Muat harus di isi", "error");
			return false;
		}
		if ($("#pelabuhan_bongkar").val() == "") {
			pesan("Pelabuhan Bongkar harus di isi", "error");
			return false;
		}
		if ($("#nomor_blawb").val() == "") {
			pesan("Nomor BL/AWB harus di isi", "error");
			return false;
		}
		if ($("#bc11").val() == "") {
			pesan("Untuk BC 23 Nomor BC11 harus di isi", "error");
			return false;
		}
		// if ($("#nomor_subposbc11").val() == "") {
		// 	pesan("Nomor Subpos BC11 harus di isi", "error");
		// 	return false;
		// }
		if ($("#nomor_posbc11").val() == "") {
			pesan("Nomor Pos BC11 harus di isi", "error");
			return false;
		}
		if ($("#bendera_angkutan").val() == "") {
			pesan("Negara Asal angkutan harus di isi", "error");
			return false;
		}
		if ($("#ukuran_kontainer").val() == "") {
			pesan("Ukuran peti kemas harus di isi", "error");
			return false;
		}
		if ($("#nomor_kontainer").val() == "") {
			pesan("Nomor peti kemas harus di isi", "error");
			return false;
		}
	}
	// Untuk cek BC 30
	if ($("#jns_bc").val() == "30") {
		// $("#pesanerror").val("");
		if ($("#pelabuhan_muat").val() == "") {
			pesan("Pelabuhan Muat harus di isi", "error");
			return false;
		}
		if ($("#pelabuhan_bongkar").val() == "") {
			pesan("Pelabuhan Bongkar harus di isi", "error");
			return false;
		}
		if ($("#bendera_angkutan").val() == "") {
			pesan("Negara Asal angkutan harus di isi", "error");
			return false;
		}
		if ($("#kode_incoterm").val() == "") {
			pesan("Kode Cara Bayar harus di isi", "error");
			return false;
		}
		// alert($("#freight").val());
		if ($("#kode_incoterm").val() == "CFR") {
			if (
				$("#freight").val() == "0" ||
				$("#freight").val() == "" ||
				$("#freight").val().trim() == "-"
			) {
				pesan("Nilai Freight harus di isi !", "error");
				return false;
			}
		}
		if ($("#kode_incoterm").val() == "CIF") {
			if (
				$("#freight").val() == "0" ||
				$("#freight").val() == "" ||
				$("#freight").val().trim() == "-" ||
				$("#asuransi").val() == "0" ||
				$("#asuransi").val() == "" ||
				$("#asuransi").val().trim() == "-"
			) {
				pesan("Nilai Freight & Asuransi harus di isi !", "error");
				return false;
			}
		}
		// if ($("#nomor_kontainer").val() == "") {
		// 	pesan("Nomor peti kemas harus di isi", "error");
		// 	return false;
		// }
	}
	// Untuk cek BC 262
	if ($("#jns_bc").val() == "262") {
		if ($("#exnomor_bc").val() == "") {
			pesan("Nomor Ex BC harus di isi", "error");
			return false;
		}
	}
	// Untuk cek BC 261
	// if ($("#jns_bc").val() == "261") {
	// 	if ($("#nomorkontrak").val() == "") {
	// 		pesan("Nomor Kontrak BC harus di isi", "error");
	// 		return false;
	// 	}
	// 	if ($("#jumlahhskosong").val() != "0") {
	// 		pesan("Masih ada HS Code kosong pada Detail Barang", "error");
	// 		return false;
	// 	}
	// 	if ($("#jumlahnobontrkosong").val() != "0") {
	// 		pesan("Masih ada Nobontr kosong pada Detail Ver. BC", "error");
	// 		return false;
	// 	}
	// }
	// $("#keteranganerr").text("Dokumen siap di kirim ke CEISA 40 !");
	if (mode != 1) {
		pesan("Dokumen siap di kirim ke CEISA 40 !", "success");
	}
	return 1;
}
$(document).on('dblclick','#nomor_sj',function(){
	masukkelampiran($("#id_header").val(),'630',$(this).val(),$("#tgl_sj").val());
})
$(document).on('click','#addkontraktolampiran',function(){
	masukkelampiran($("#id_header").val(),'315',$("#nomorkontrak").val(),$("#tglkontrak").val());
	masukkelampiran($("#id_header").val(),'203',$("#nomor_kep").val(),$("#tgl_kep").val());
})
function masukkelampiran(idx,fieldx,nilaix,tglx){
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "akb/masukkelampiran/",
		data: {
			id: idx,
			field: fieldx,
			nilai: nilaix,
			tgl: tglx,
		},
		success: function (data) {
			alert('Lampiran '+fieldx+' sudah masuk, Refresh halaman');
			$("#keteranganerr").text("Data Saved ..!");
			// pesan("Data Saved ..!", "success");
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
			// pesan("Data Saved ..!", "success");
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
	// alert(xu);
	switch (xu) {
		case "1": //IDR
			tothar = parseFloat(toAngka($("#nilai_pab").val()));
			devidr = parseFloat(toAngka($("#kurs_idr").val()));
			devusd = parseFloat(toAngka($("#kurs_usd").val()));
			$("#devisa_usd").val(rupiah(tothar / devusd, ".", ",", 3));
			$("#devisa_idr").val(rupiah(tothar * devidr, ".", ",", 2));
			break;
		case "2": //USD
			tothar = parseFloat(toAngka($("#nilai_pab").val()));
			devidr = parseFloat(toAngka($("#kurs_idr").val()));
			devusd = parseFloat(toAngka($("#kurs_usd").val()));
			$("#devisa_idr").val(rupiah(tothar * devusd, ".", ",", 3));
			$("#devisa_usd").val(rupiah(tothar / devidr, ".", ",", 2));
			break;
		default:
			break;
	}
	$("#devisa_idr").blur();
	$("#devisa_usd").blur();
}
function loadlampiran() {
	var id = $("#id_header").val();
	var ceksend = $("#nomor_aju").attr("readonly") == "readonly" ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/getdatalampiran/" + id,
		data: { cek: ceksend },
		success: function (data) {
			// window.location.reload();
			$("#body-table").html(data.datagroup).show();
			$("#jmllampiran").val(data.datagroup.length);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loadkontainer() {
	var id = $("#id_header").val();
	var ceksend = $("#nomor_aju").attr("readonly") == "readonly" ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/getdatakontainer/" + id,
		data: { cek: ceksend },
		success: function (data) {
			// window.location.reload();
			$("#body-table-kontainer").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loadentitas() {
	var id = $("#id_header").val();
	var ceksend = $("#nomor_aju").attr("readonly") == "readonly" ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/getdataentitas/" + id,
		data: { cek: ceksend },
		success: function (data) {
			// window.location.reload();
			$("#body-table-entitas").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function ceklampiranbc23() {
	var ide = $("#id_header").val();
	$("#pesanerror").val("");
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "ib/getdoklampiran/",
		data: { id: ide, bc: $("#jns_bc").val() },
		success: function (data) {
			$("#pesanerror").val(data);
			// alert(data);
			// return false;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
	// return callbak;
}
