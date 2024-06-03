$(document).ready(function () {
	// $(".datatabledengandiv").DataTable({
	// 	dom: "<'extra'>frtip",
	// });
	// $("div.extra").html($("#sisipkan").html()).insertAfter(".dataTables_filter");
	// $(".dataTables_filter").css("float", "right");
	// var url = window.location.href;
	// var pisah = url.split("/");
	
	// if (pisah[2] == "localhost") {
	// 	if (pisah[5] == "databbl ") {
	// 		getdatadetailpb();
	// 	}
	// } else {
	// 	if (pisah[4] == "addinvoice" || pisah[4] == "editinvoice") {
			
	// 	}
	// 	if (pisah[5] == "datapb") {
	// 		getdatadetailpb();
	// 	}
	// }
	// $("#dept_kirim").change();
	
});
$("#tglpb").datepicker();

// $("#dept_kirim").change(function () {
// 	$.ajax({
		
// 		type: "POST",
// 		url: base_url + "pb/depttujupb",
// 		data: {
// 			kode: $(this).val(),
// 		},
// 		success: function (data) {
			
// 			$("#dept_tuju").html(data);
			
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// });

$("#simpandetailbarang").click(function () {
	if ($("#nomor_dok").val() == "") {
		pesan("Isi / Cari no Dokumen", "error");
		return;
	}
	if (
		($("#kgs").val() == "" || $("#kgs").val() == "0") &&
		($("#ket").val() == "" || $("#ket").val() == "0")
	) {
		pesan("Isi Qty atau Ket dengan benar", "error");
		return;
	}
	document.formbbl.submit();
});

$("#butgo").click(function () {
	// $("#dept_tuju").change();
	getdatapb();
});
$("#resetdetailbarang").click(function () {
	$("#nomor_dok").val("");
	$("#kode_dok").val("");
	$("#dept_id").val("");
	$("#pcs").val("");
	$("#ket").val("");
	$("#id").val("");
});

$("#nomor_dok").on("keyup", function (e) {
	if (e.key == "Enter" || e.keycode === 13) {
		$("#caribarang").click();
	}
});
$(document).on("click", "#editdetailpb", function () {
	var noid = $(this).attr("rel");
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "pb/getdetailpbbyid",
		data: {
			id: noid,
		},
		success: function (data) {
			$("#id").val(data[0].id);
			$("#id_barang").val(data[0].id_barang);
			$("#nama_barang").val(data[0].nama_barang);
			$("#id_satuan").val(data[0].id_satuan);
			$("#pcs").val(data[0].pcs);
			$("#kgs").val(data[0].kgs);
			$("#formbarangpb").attr("action", base_url + "pb/updatedetailbarang");
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});

$("#bl").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "pb/ubahperiode",
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
function getdatapb() {
	// alert($("#level").val());
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "pb/getdatapb",
		data: {
			dept_id: $("#dept_kirim").val(),
			dept_tuju: $("#dept_tuju").val(),
			levelsekarang: $("#level").val(),
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
function getdatadetail_bbl() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "bbl/getdatadetail_bbl",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			$("#jmlrek").val(data.jmlrek);
			$("#body-table").html(data.datagroup).show();
			if (data.jmlrek == 0) {
				$("#simpanbbl").addClass("disabled");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
