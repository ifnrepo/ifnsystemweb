$(document).ready(function () {
	$("#katedept_id").change();
});

$("#editdept").click(function () {
	if ($("#dept_id").val() == "") {
		pesan("Kode tidak boleh kosong !", "error");
		return;
	}
	if ($("#departemen").val() == "") {
		pesan("Departemen tidak boleh kosong !", "error");
		return;
	}
	if ($("#katedept_id").val() == "") {
		pesan("Kategori tidak boleh kosong !", "error");
		return;
	}

	document.formatedit.submit();
});

$("#katedept_id").change(function () {
	var x = $(this).val();
	if (x == 3) {
		$("#jikasubkon").removeClass("hilang");
	} else {
		$("#jikasubkon").addClass("hilang");
	}
});
