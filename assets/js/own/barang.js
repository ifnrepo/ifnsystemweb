var table;
$(document).ready(function () {
	var table = $("#tabelnya").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "barang/get_data_barang",
			type: "POST",
			data: function (d) {
				d.filter_kategori = $("#filter").val();
				d.filter_inv = $("#filterinv").val();
				d.filter_act = $("#filteract").val();
				console.log("Filter kategori:", d.filter_kategori);
				console.log("Filter INV:", d.filter_inv);
				console.log("Filter aktif:", d.filter_act);
			},
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
		pageLength: 50,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});

	$("#filter, #filterinv, #filteract").on("change", function () {
		table.ajax.reload();
	});

	$("#filter, #filterinv, #filteract").on("change", function () {
		var filter_kategori = $("#filter").val();
		var filter_inv = $("#filterinv").val();
		var filter_act = $("#filteract").val();

		var exportUrlExcel =
			base_url +
			"barang/excel?filter=" +
			filter_kategori +
			"&filterinv=" +
			filter_inv +
			"&filteract=" +
			filter_act;
		$(".btn-export-excel").attr("href", exportUrlExcel);

		var exportUrlPdf =
			base_url +
			"barang/pdf?filter=" +
			filter_kategori +
			"&filterinv=" +
			filter_inv +
			"&filteract=" +
			filter_act;
		$(".btn-export-pdf").attr("href", exportUrlPdf);

		console.log("Export Excel URL:", exportUrlExcel);
		console.log("Export PDF URL:", exportUrlPdf);
	});
});

$("#tabelnya tbody").on("click", "td", function () {
	var tr = $(this).closest("tr");
	var rowindex = tr.index();
	// alert(rowindex);
	$("#currentrow").val(rowindex);
	// table.row(this).data(d).draw();
});
$("#viewalias").click(function () {
	var isi = $(this).is(":checked") ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "barang/updateview",
		data: {
			isinya: isi,
		},
		success: function (data) {
			window.location.reload();
			// alert('berhasil');
			// window.location.href = base_url + "bbl/databbl/" + $("#id_header").val();
			// $("#butbatal").click();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
			pesan("ERROR " + xhr.status + " " + thrownError, "info");
		},
	});
});

$("#simpandata").click(function () {
	document.formkolom.submit();
});

var loadFile = function (event) {
	var output = document.getElementById("gbimage");
	var isifile = event.target.files[0];

	if (!isifile) {
		output.src = "<?= base_url($path . 'image.jpg'); ?>";
		$("#okesubmit").addClass("disabled");
	} else {
		output.src = URL.createObjectURL(isifile);
		output.onload = function () {
			URL.revokeObjectURL(output.src);
		};
		$("#okesubmit").removeClass("disabled");
	}
};
