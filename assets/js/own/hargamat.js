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
				// alert('<?php echo $this->session->userdata("jmlrek);  ?>');
				// $("#jumlahrekod").innerHtml(d.filter_inv);
			},
		},
		columnDefs: [
			{
				// className: "dt-nowrap",
				targets: [0],
				orderable: false,
			},
		],
		pageLength: 50,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});
	$("#filter").change(function () {
		table.ajax.reload();
		var htmlnya = "";
		// alert($("#jumlahrekod").text());
		$("#jumlahrekod").innerHtml("OKOKOK");
	});
	$("#filterinv").change(function () {
		table.ajax.reload();
	});
});
