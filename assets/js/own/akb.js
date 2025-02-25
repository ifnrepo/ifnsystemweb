$(document).ready(function () {
	// $(".datatabledengandiv").DataTable({
	// 	dom: "<'extra'>frtip",
	// });
	// $("div.extra").html($("#sisipkan").html()).insertAfter(".dataTables_filter");
	// $(".dataTables_filter").css("float", "right");
	var url = window.location.href;
	var pisah = url.split("/");
	// alert(pisah[5]);
	if (pisah[2] == "localhost") {
		if (pisah[5] == "dataib") {
			getdatadetailib();
		}
	} else {
		if (pisah[5] == "dataib") {
			getdatadetailib();
		}
	}
	// generatekode();
	// $("#dept_kirim").change();
	// $("#level").change();
	var jn_bayar = $("#jn_pembayaran").val();
	if (jn_bayar == "CASH" || jn_bayar == "") {
		$("#tgldtbt").attr("disabled", true);
	} else {
		$("#tgldtbt").attr("disabled", false);
	}
	var value_old = 0;
	var errosimpan = $("#errorsimpan").val();
	var pesanerr = $("#pesanerror").val();
	if (errosimpan == 1) {
		var pesan1 =
			"Pilih departemen penerima Input Barang (tekan tombol 'GO' dahulu)";
		var cekpesan = pesanerr == "" ? pesan1 : pesanerr;
		pesan(cekpesan, "error");
	}
	if (errosimpan == 2) {
		pesan("Ada Error Program, Hubungi Administrator Aplikasi !", "error");
	}
	if (errosimpan == 3) {
		pesan("Tidak terjadi perubahan pada data X !", "error");
	}
	if (errosimpan == 4) {
		pesan("Ada Pcs, Kgs atau Harga yang masih kosong !", "error");
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
		if (!$("#addtoken").hasClass("disabled")) {
			$("#addtoken").addClass("disabled");
		}
		// If the count down is finished, write some text
		if (distance < 0) {
			clearInterval(x);
			document.getElementById("timetoexpired").innerHTML = "TOKEN EXPIRED";
			$("#addtoken").removeClass("disabled");
		}
	}, 1000);
});
// $("#tglpb").datepicker();

$("#bl").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "ib/ubahperiode",
		data: {
			bl: $(this).val(),
			th: $("#th").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#th").change(function () {
	$("#bl").change();
});
$("#butgo").click(function () {
	// $("#dept_tuju").change();
	getdataakb();
});
$("#jn_ib").change(function () {
	var isinya =
		'<span class="text-primary"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading ...</span>';
	$("#loadview").html(isinya);
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/updatebykolom/jn_ib",
		data: {
			isinya: $(this).val(),
			id: $("#id_header").val(),
		},
		success: function (data) {
			$("#loadview").html("");
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#tanpa_bc").click(function () {
	var isinya =
		'<span class="text-primary"><div class="spinner-border spinner-border-sm text-primary" role="status"></div> Loading ...</span>';
	$("#loadview").html(isinya);
	var ikeh = $(this).is(":checked") ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/updatebykolom/tanpa_bc",
		data: {
			isinya: ikeh,
			id: $("#id_header").val(),
		},
		success: function (data) {
			$("#loadview").html("");
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$(".inputtgl").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
});
$("#nomor_sj").focus(function () {
	value_old = $(this).val();
});
$("#tgl_sj").focus(function () {
	value_old = $(this).val();
});
$("#nomor_aju").focus(function () {
	value_old = $(this).val();
});
$("#tgl_aju").focus(function () {
	value_old = $(this).val();
});
$("#nomor_bc").focus(function () {
	value_old = $(this).val();
});
$("#tgl_bc").focus(function () {
	value_old = $(this).val();
});
$("#no_kendaraan").focus(function () {
	value_old = $(this).val();
});
$("#no_faktur_pajak").focus(function () {
	value_old = $(this).val();
});
$("#nomor_sj").blur(function () {
	if ($("#nomor_sj").val() != value_old) {
		updatekolom($("#id_header").val(), "tb_header", "nomor_sj", $(this).val());
	}
});
$("#tgl_sj").change(function () {
	if ($("#tgl_sj").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"tgl_sj",
			tglmysql($(this).val()),
		);
	}
});
$("#nomor_aju").blur(function () {
	if ($("#nomor_aju").val() != value_old) {
		updatekolom($("#id_header").val(), "tb_header", "nomor_aju", $(this).val());
	}
});
$("#tgl_aju").change(function () {
	if ($("#tgl_aju").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"tgl_aju",
			tglmysql($(this).val()),
		);
	}
});
$("#nomor_bc").blur(function () {
	if ($("#nomor_bc").val() != value_old) {
		updatekolom($("#id_header").val(), "tb_header", "nomor_bc", $(this).val());
		generatekode();
	}
});
$("#tgl_bc").change(function () {
	if ($("#tgl_bc").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"tgl_bc",
			tglmysql($(this).val()),
		);
		generatekode();
	}
});
$("#no_kendaraan").blur(function () {
	if ($("#no_kendaraan").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"no_kendaraan",
			$(this).val(),
		);
	}
});
$("#no_faktur_pajak").blur(function () {
	if ($("#no_faktur_pajak").val() != value_old) {
		updatekolom(
			$("#id_header").val(),
			"tb_header",
			"no_faktur_pajak",
			$(this).val(),
		);
	}
});

$("#cekbarang").click(function () {
	if ($("#id_pemasok").val() == 0) {
		pesan("Isi data supplier/Pemasok terlebih dahulu", "info");
		return false;
	} else {
		$("#getbarang").click();
	}
});
$("#jns_bc").change(function () {
	updatekolom($("#id_header").val(), "tb_header", "jns_bc", $(this).val());
	generatekode();
});
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
	$("#generatenobc").html(jnsbc + "-010017-" + tglbc + "-" + nobc);
}
function updatekolom(idx, tabel, kolom, isi) {
	var isinya =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadview").html(isinya);
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/updatekolom/" + kolom,
		data: {
			isinya: isi,
			tbl: tabel,
			id: idx,
		},
		success: function (data) {
			$("#loadview").html("");
			// alert(data);
			// window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
$("#dept_id").change(function () {
	// alert("XXX");
	$("#butgo").click();
});
function getdatadetailib() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ib/getdatadetailib",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			// alert(data.jmlrek);
			// window.location.reload();
			$("#jmlrek").val(data.jmlrek);
			$("#body-table").html(data.datagroup).show();
			// $("#totalharga").val(rupiah(data.totalharga, ".", ",", 2));
			if (data.jmlrek > 0) {
				$("#jn_ib").attr("disabled", true);
				$("#pilihsup").addClass("disabled");
			}
			// hitunggrandtotal();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
$("#xsimpanib").click(function () {
	var ikeh = $("#tanpa_bc").is(":checked") ? 1 : 0;
	if ($("#nomor_sj").val() == "" || $("#tgl_sj").val() == "") {
		pesan("Nomor/Tgl Surat jalan belum diisi !", "info");
		return false;
	}
	if (ikeh == 0) {
		if ($("#jns_bc").val() == "") {
			pesan("Jenis BC belum di isi !", "info");
			return false;
		}
		if ($("#nomor_aju").val() == "" || $("#tgl_aju").val() == "") {
			pesan("Nomor/Tgl AJU belum di isi !", "info");
			return false;
		}
		if ($("#nomor_bc").val() == "" || $("#tgl_bc").val() == "") {
			pesan("Nomor/Tgl BC belum di isi !", "info");
			return false;
		}
	}
	if ($("#jmlrek").val() == "0") {
		pesan("Barang kosong !", "info");
		return false;
	}
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "ib/cekhargabarang",
		data: {
			id: $("#id_header").val(),
		},
		success: function (data) {
			if (data == 0) {
				$("#carisimpanib").click();
			} else {
				pesan("Harga barang harus diisi !", "info");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
function getdataakb() {
	// alert($("#dept_id").val());
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "akb/getdataakb",
		data: {
			dept: $("#dept_id").val(),
		},
		success: function (data) {
			// alert(data.datagroup);
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
