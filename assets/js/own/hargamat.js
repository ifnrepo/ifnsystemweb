$(document).ready(function () {
	// alert("SIAP");
	$(".loadered").removeClass('hilang');
	isibutton();
	var table = $("#tabelnya").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "hargamat/get_data_hargamat",
			type: "POST",
			data: function (d) {
				d.filter_kategori = $("#filter").val();
				d.filter_inv = $("#filterinv").val();
				d.filter_bc = $("#filter_bc").val();
				d.filter_milik = $("#filter_milik").val();
				console.log("Filter kategori:", d.filter_kategori);
				console.log("Filter inv:", d.filter_inv);
				console.log("Filter bc:", d.filter_bc);
				console.log("Filter Milik:", d.filter_milik);
			},
		},
		columnDefs: [
			{
				
				targets: [0],
				orderable: false,
				className: 'line-11'
			},
			{
				// className: "text-right",
				targets: [3],
				// orderable: false,
				className: "text-danger font-kecil",
			},
			{
				// className: "text-right",
				targets: [4],
				// orderable: false,
				className: "text-primary",
			},
			{
				className: "line-11",
				targets: [5],
				orderable: false,
			},
			{
				className: "text-right",
				targets: [6],
				orderable: false,
			},
			// {
			// 	className: "text-right",
			// 	targets: [5],
			// 	orderable: false,
			// },
			{
				className: "text-right",
				targets: [7],
				orderable: false,
			},
			{
				className: "text-right",
				targets: [8],
				orderable: false,
			},
			{
				className: "text-right",
				targets: [9],
				orderable: false,
			},
			// {
			// 	className: "text-right",
			// 	targets: [10],
			// 	orderable: false,
			// },
		],
		drawCallback: function (response) {
			// var api = this.api();
			// Output the data for the visible rows to the browser's console
			// console.log(api.rows({ page: "current" }).data());
			// alert("DataTables has redrawn the table");
			// alert(response.json.recordsFiltered);
			$("#reko1").html(rupiah(response.json.recordsFiltered, ".", ",", 0));
			$("#reko2").html(rupiah(response.json.jumlahKgs, ".", ",", 2));
			$("#reko3").html(rupiah(response.json.jumlahPcs, ".", ",", 0));
			$("#reko4").html(rupiah(response.json.jumlahTotal, ".", ",", 2));
			$("#reko5").html(rupiah(response.json.jumlahAkt, ".", ",", 8));
			$(".loadered").addClass('hilang');
		},
		pageLength: 50,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});

	$("#blperiode, #thperiode").on("change", function () {
		$(".loadered").removeClass('hilang');
		$.ajax({
			dataType: "json",
			type: "POST",
			url: base_url + "hargamat/ubahperiode",
			data: {
				bl: $("#blperiode").val(),
				th: $("#thperiode").val(),
				kat: $("#filter").val(),
				bece: $("#filter_bc").val(),
				inv: $("#filterinv").val(),
				milik: $("#filter_milik").val(),
			},
			success: function (data) {
				table.ajax.reload();
				isibutton();
				// alert('berhasil');
				// window.location.href = base_url + "bbl/databbl/" + $("#id_header").val();
				// $("#butbatal").click();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	});
	$("#filter_milik").on("change", function () {
		// table.ajax.reload();
		$("#blperiode").change();
	});
	$("#filter").change(function(){
		$("#blperiode").change();
	});
	$("#filter_bc").change(function(){
		$("#blperiode").change();
	});
	$("#filterinv").change(function(){
		$("#blperiode").change();
	});
	function isibutton(){
		var filter_kategori = $("#filter").val();
		var filter_inv = $("#filterinv").val();
		var filter_milik = $("#filter_milik").val();
		var filter_tahun = $("#thperiode").val();
		var filter_bulan = $("#blperiode").val();

		var exportUrlExcel =
			base_url +
			"hargamat/excel?filter=" +
			filter_kategori +
			"&filterinv=" +
			filter_inv +
			"&filtermilik=" +
			filter_milik +
			"&filtertahun=" +
			filter_tahun +
			"&filterbulan=" +
			filter_bulan;
		$(".btn-export-excel").attr("href", exportUrlExcel);

		var exportUrlPdf =
			base_url +
			"hargamat/pdf?filter=" +
			filter_kategori +
			"&filterinv=" +
			filter_inv+
			"&filtermilik=" +
			filter_milik +
			"&filtertahun=" +
			filter_tahun +
			"&filterbulan=" +
			filter_bulan;
		$(".btn-export-pdf").attr("href", exportUrlPdf);

		console.log("Export Excel URL:", exportUrlExcel);
		console.log("Export PDF URL:", exportUrlPdf);
	}
	// $("#filter, #filterinv,#filter_milik").on("change", function () {
	// 	var filter_kategori = $("#filter").val();
	// 	var filter_inv = $("#filterinv").val();
	// 	var filter_milik = $("#filter_milik").val();

	// 	var exportUrlExcel =
	// 		base_url +
	// 		"hargamat/excel?filter=" +
	// 		filter_kategori +
	// 		"&filterinv=" +
	// 		filter_inv +
	// 		"&filtermilik=" +
	// 		filter_milik;
	// 	$(".btn-export-excel").attr("href", exportUrlExcel);

	// 	var exportUrlPdf =
	// 		base_url +
	// 		"hargamat/pdf?filter=" +
	// 		filter_kategori +
	// 		"&filterinv=" +
	// 		filter_inv;
	// 	$(".btn-export-pdf").attr("href", exportUrlPdf);

	// 	console.log("Export Excel URL:", exportUrlExcel);
	// 	console.log("Export PDF URL:", exportUrlPdf);
	// });
	$(document).on('click','#modaledit',function(){

	})
});
