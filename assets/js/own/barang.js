// document.addEventListener("DOMContentLoaded", function () {
// 	var el;
// 	window.TomSelect &&
// 		new TomSelect((el = document.getElementById("select-users")), {
// 			copyClassesToDropdown: false,
// 			dropdownParent: "body",
// 			controlInput: "<input>",
// 			render: {
// 				item: function (data, escape) {
// 					if (data.customProperties) {
// 						return (
// 							'<div><span class="dropdown-item-indicator">' +
// 							data.customProperties +
// 							"</span>" +
// 							escape(data.text) +
// 							"</div>"
// 						);
// 					}
// 					return "<div>" + escape(data.text) + "</div>";
// 				},
// 				option: function (data, escape) {
// 					if (data.customProperties) {
// 						return (
// 							'<div><span class="dropdown-item-indicator">' +
// 							data.customProperties +
// 							"</span>" +
// 							escape(data.text) +
// 							"</div>"
// 						);
// 					}
// 					return "<div>" + escape(data.text) + "</div>";
// 				},
// 			},
// 		});
// });
var table;
// $(document).ready(function () {

// 	table = $("#tabelnya").DataTable({
// 		processing: true,
// 		serverSide: true,
// 		order: [],
// 		ajax: {
// 			url: base_url + "barang/get_data_barang",
// 			type: "POST",
// 		},
// 		columnDefs: [
// 			{
// 				targets: [0],
// 				orderable: false,
// 			},
// 		],
// 		pageLength: 50,
// 		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
// 	});
// 	// $(".dataTables_filter").css("float", "right !important");
// });

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
				console.log("Filter kategori:", d.filter_inv);
				console.log("Filter aktif:", d.filter_act);
			},
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
			},
		],
		createdRow: function (row, data, dataIndex) {
			if (data[7] == '<i class="fa fa-times text-danger"></i>') {
				$(row).addClass("text-red");
				// $(row).addClass("font-strike");
			}
		},
		pageLength: 50,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});

	$("#filter").on("change", function () {
		table.ajax.reload();
	});
	$("#filterinv").on("change", function () {
		table.ajax.reload();
	});
	$("#filteract").on("change", function () {
		table.ajax.reload();
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
