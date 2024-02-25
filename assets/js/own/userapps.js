$(document).ready(function () {});
$("#tambahuser").click(function () {
	if ($("#name").val() == "") {
		pesan("Nama tidak boleh kosong !", "error");
		return;
	}
	if ($("#bagian").val() == "") {
		pesan("Bagian tidak boleh kosong !", "error");
		return;
	}
	if ($("#jabatan").val() == "") {
		pesan("Jabatan tidak boleh kosong !", "error");
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
$("#edituser").click(function () {
	if ($("#name").val() == "") {
		pesan("Nama tidak boleh kosong !", "error");
		return;
	}
	if ($("#bagian").val() == "") {
		pesan("Bagian tidak boleh kosong !", "error");
		return;
	}
	if ($("#jabatan").val() == "") {
		pesan("Jabatan tidak boleh kosong !", "error");
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
