$(document).ready(function () {
	if ($("#master3").is(":checked")) {
		$("#master13").attr("disabled", false);
	} else {
		$("#master13").attr("disabled", true);
	}
	$("#cekmng").change();
	$("#ceksgm").change();
	$("#hakprogram4").change();
});
$("#tambahuser").click(function () {
	if ($("#name").val() == "") {
		pesan("Nama tidak boleh kosong !", "error");
		return;
	}
	if ($("#bagian").val() == "") {
		pesan("Bagian tidak boleh kosong !", "error");
		return;
	}
	if ($("#id_dept").val() == "") {
		pesan("Jabatan tidak boleh kosong !", "error");
		return;
	}
	if ($("#jabatan").val() == "") {
		pesan("Jabatan tidak boleh kosong !", "error");
		return;
	}
	if ($("#id_level_user").val() == "") {
		pesan("Level User tidak boleh kosong !", "error");
		return;
	}
	if ($("#email").val() == "") {
		pesan("E-mail tidak boleh kosong !", "error");
		return;
	}
	if ($("#username").val() == "") {
		pesan("Username tidak boleh kosong !", "error");
		return;
	}
	if ($("#password").val() == "") {
		pesan("Password tidak boleh kosong !", "error");
		return;
	}
	$.ajax({
		url: base_url + "userapps/cekusername", // Ubah ke URL controller yang tepat
		type: "POST",
		data: { data: $("#username").val() },
		success: function (response) {
			if (response == 0) {
				document.formtambahuser.submit();
			} else {
				pesan("Username sudah ada yang memakai, ganti Username !", "error");
			}
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: ", status, error);
		},
	});
});

$("#edituser").click(function () {
	if ($("#name").val() == "") {
		pesan("Nama tidak boleh kosong !", "error");
		return;
	}
	if ($("#bagian").val() == "") {
		pesan("Bagian tidak boleh kosong !", "error");
		return;
	}
	if ($("#id_dept").val() == "") {
		pesan("Jabatan tidak boleh kosong !", "error");
		return;
	}
	if ($("#jabtan").val() == "") {
		pesan("Jabatan tidak boleh kosong !", "error");
		return;
	}
	if ($("#id_level_user").val() == "") {
		pesan("Level User tidak boleh kosong !", "error");
		return;
	}
	if ($("#email").val() == "") {
		pesan("E-mail tidak boleh kosong !", "error");
		return;
	}
	if ($("#username").val() == "") {
		pesan("Username tidak boleh kosong !", "error");
		return;
	}
	if ($("#password").val() == "") {
		pesan("Password tidak boleh kosong !", "error");
		return;
	}
	document.formtambahuser.submit();
});

$("#id_level_user").change(function () {
	// alert($(this).val());
});

$("#cekpp").change(function () {
	// alert($(this).props("checked", true));
	if ($(this).is(":checked") && $("#cekut").is(":checked")) {
		$("#cekut").prop("checked", false);
	}
});
$("#cekut").change(function () {
	// alert($(this).props("checked", true));
	if ($(this).is(":checked") && $("#cekpp").is(":checked")) {
		$("#cekpp").prop("checked", false);
	}
});
$("#master3").change(function () {
	if ($(this).is(":checked")) {
		$("#master13").attr("disabled", false);
	} else {
		$("#master13").prop("checked", false);
		$("#master13").attr("disabled", true);
	}
});
$("#cekmng").change(function () {
	if ($(this).is(":checked")) {
		$("#inicekmng").removeClass("hilang");
	} else {
		$("#inicekmng").addClass("hilang");
	}
});
$("#ceksgm").change(function () {
	if ($(this).is(":checked")) {
		$("#iniceksgm").removeClass("hilang");
	} else {
		$("#iniceksgm").addClass("hilang");
	}
});
$("#hakprogram4").change(function () {
	if ($(this).is(":checked")) {
		$("#cekeventrahasia").removeClass("hilang");
	} else {
		$("#cekeventrahasia").addClass("hilang");
	}
});
