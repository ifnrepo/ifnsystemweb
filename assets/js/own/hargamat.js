$(document).ready(function () {
	// alert("SIAP");
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
				console.log("Filter kategori:", d.filter_kategori);
				console.log("Filter kategori:", d.filter_inv);
			},
		},
		columnDefs: [
			{
				// className: "dt-nowrap",
				targets: [0],
				orderable: false,
			},
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
		},
		pageLength: 50,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});
	$("#filter").change(function () {
		table.ajax.reload();
	});
	$("#filterinv").change(function () {
		table.ajax.reload();
	});
});
