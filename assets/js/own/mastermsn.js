$(document).ready(function () {
	// var errosimpan = $("#errorparam").val();
	// if (errosimpan == 1) {
	// 	pesan("Departemen Pembuat/Asal BBL belum diset !", "info");
	// }
});
$("#lokasi").change(function () {
	var cek = $("#cekdisposal").is(":checked");
	if (cek) {
		var x = 1;
	} else {
		var x = 0;
	}
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "mastermsn/ubahlokasi",
		data: {
			lok: $(this).val(),
			ceko: x,
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
$("#cekdisposal").click(function () {
	var cek = $("#cekdisposal").is(":checked");
	if (cek) {
		var x = 1;
	} else {
		var x = 0;
	}
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "mastermsn/ubahlokasi",
		data: {
			ceko: x,
			lok: $("#lokasi").val(),
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
$("#simpanmesin").click(function () {
	document.formkolom.submit();
});
$("#btnget").click(function () {
	$("#dok").click();
	$("#dok").change();
});
$("#dok").change(function () {
	var name = document.getElementById("dok");
	$("#namedok").val(name.files.item(0).name);
	$("#btnupdate").addClass("disabled");
	if ($("#namedok").val() != "") {
		$("#btnupdate").removeClass("disabled");
	}
});
$("#btnupdate").click(function () {
	document.formdok.submit();
});
var loadFile = function (event) {
	var output = document.getElementById("gbimage");
	var isifile = event.target.files[0];
	$("#okesubmit").addClass("disabled");
	if (!isifile) {
		output.src = "assets/page/images/add-files.svg";
	} else {
		output.src = URL.createObjectURL(isifile);
		output.onload = function () {
			URL.revokeObjectURL(output.src); // free memory
		};
		$("#okesubmit").removeClass("disabled");
	}
};
// $("#tglpb").datepicker();

// // $("#dept_kirim").change(function () {
// // 	$.ajax({

// // 		type: "POST",
// // 		url: base_url + "pb/depttujupb",
// // 		data: {
// // 			kode: $(this).val(),
// // 		},
// // 		success: function (data) {

// // 			$("#dept_tuju").html(data);

// // 		},
// // 		error: function (xhr, ajaxOptions, thrownError) {
// // 			console.log(xhr.status);
// // 			console.log(thrownError);
// // 		},
// // 	});
// // });
// $("#xdeptselect").change(function () {
// 	// alert($(this).prop("checked"));
// 	var isi = $(this).val();
// 	$.ajax({
// 		dataType: "json",
// 		type: "POST",
// 		url: base_url + "bbl/editdeptpp",
// 		data: {
// 			id: $("#id_header").val(),
// 			dept_bbl: isi,
// 		},
// 		success: function (data) {
// 			window.location.reload();
// 			// alert('berhasil');
// 			// window.location.href = base_url + "bbl/databbl/" + $("#id_header").val();
// 			// $("#butbatal").click();
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 			pesan("ERROR " + xhr.status + " " + thrownError, "info");
// 		},
// 	});
// });
// $("#bbl_pp").change(function () {
// 	// alert($(this).val());
// 	// var isi = $(this).prop("checked") ? 1 : 0;
// 	// var xisi = $(this).prop("checked") ? 0 : 1;
// 	var isinya =
// 		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
// 	$("#loadview").html(isinya);
// 	var isi = $(this).val();
// 	$.ajax({
// 		dataType: "json",
// 		type: "POST",
// 		url: base_url + "bbl/editbblpp",
// 		data: {
// 			id: $("#id_header").val(),
// 			bbl_pp: isi,
// 		},
// 		success: function (data) {
// 			// alert('berhasil');
// 			// window.location.href = base_url + "bbl/databbl/" + $("#id_header").val();
// 			// $("#butbatal").click();
// 			$("#loadview").html("");
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 			if (xisi == 0) {
// 				$(this).attr("checked", false);
// 			} else {
// 				$(this).attr("checked", true);
// 			}
// 			pesan("ERROR " + xhr.status + " " + thrownError, "info");
// 		},
// 	});
// });
// $("#simpandetailbarang").click(function () {
// 	if ($("#nomor_dok").val() == "") {
// 		pesan("Isi / Cari no Dokumen", "error");
// 		return;
// 	}
// 	if (
// 		($("#kgs").val() == "" || $("#kgs").val() == "0") &&
// 		($("#ket").val() == "" || $("#ket").val() == "0")
// 	) {
// 		pesan("Isi Qty atau Ket dengan benar", "error");
// 		return;
// 	}
// 	document.formbbl.submit();
// });

// $("#butgo").click(function () {
// 	// $("#dept_tuju").change();
// 	getdatabbl();
// });
// $("#resetdetailbarang").click(function () {
// 	$("#nomor_dok").val("");
// 	$("#kode_dok").val("");
// 	$("#dept_id").val("");
// 	$("#pcs").val("");
// 	$("#ket").val("");
// 	$("#id").val("");
// });

// $("#nomor_dok").on("keyup", function (e) {
// 	if (e.key == "Enter" || e.keycode === 13) {
// 		$("#caribarang").click();
// 	}
// });
// $(document).on("click", "#editdetailpb", function () {
// 	var noid = $(this).attr("rel");
// 	$.ajax({
// 		dataType: "json",
// 		type: "POST",
// 		url: base_url + "pb/getdetailpbbyid",
// 		data: {
// 			id: noid,
// 		},
// 		success: function (data) {
// 			$("#id").val(data[0].id);
// 			$("#id_barang").val(data[0].id_barang);
// 			$("#nama_barang").val(data[0].nama_barang);
// 			$("#id_satuan").val(data[0].id_satuan);
// 			$("#pcs").val(data[0].pcs);
// 			$("#kgs").val(data[0].kgs);
// 			$("#formbarangpb").attr("action", base_url + "pb/updatedetailbarang");
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// });

// $("#bl").change(function () {
// 	$.ajax({
// 		// dataType: "json",
// 		type: "POST",
// 		url: base_url + "pb/ubahperiode",
// 		data: {
// 			bl: $(this).val(),
// 			th: $("#th").val(),
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
// $("#th").change(function () {
// 	$("#bl").change();
// });
// function getdatabbl() {
// 	// alert($("#level").val());
// 	$.ajax({
// 		// dataType: "json",
// 		type: "POST",
// 		url: base_url + "bbl/getdatabbl",
// 		data: {
// 			dept_id: $("#dept_kirim").val(),
// 			dept_tuju: $("#dept_tuju").val(),
// 		},
// 		success: function (data) {
// 			// alert(data.datagroup);
// 			window.location.reload();
// 			// $("#body-table").html(data.datagroup).show();
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// }
// function getdatadetail_bbl() {
// 	$.ajax({
// 		dataType: "json",
// 		type: "POST",
// 		url: base_url + "bbl/getdatadetail_bbl",
// 		data: {
// 			id_header: $("#id_header").val(),
// 		},
// 		success: function (data) {
// 			$("#jmlrek").val(data.jmlrek);
// 			$("#body-table").html(data.datagroup).show();
// 			if (data.jmlrek == 0) {
// 				$("#simpanbbl").addClass("disabled");
// 			}
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// }
