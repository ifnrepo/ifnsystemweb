var table = null;
$(document).ready(function () {
	// var table = $("#tabelnya").DataTable({
	// 	processing: true,
	// 	serverSide: true,
	// 	order: [],
	// 	ajax: {
	// 		url: base_url + "barang/get_data_barang",
	// 		type: "POST",
	// 		data: function (d) {
	// 			d.filter_kategori = $("#filter").val();
	// 			d.filter_inv = $("#filterinv").val();
	// 			d.filter_act = $("#filteract").val();
	// 			console.log("Filter kategori:", d.filter_kategori);
	// 			console.log("Filter INV:", d.filter_inv);
	// 			console.log("Filter aktif:", d.filter_act);
	// 		},
	// 	},
	// 	columnDefs: [
	// 		{
	// 			targets: [0],
	// 			orderable: false,
	// 		},
	// 	],
	// 	pageLength: 50,
	// 	dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',

	$("#filter, #filterinv, #filteract").on("change", function () {
		table.ajax.reload();

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
	});

	// $("#filter, #filterinv, #filteract").on("change", function () {
	

	// 	console.log("Export Excel URL:", exportUrlExcel);
	// 	console.log("Export PDF URL:", exportUrlPdf);
	// });
	table = $('#tabelnya').DataTable({
		"processing": true,
		// "responsive":true,
		"serverSide": true,
		"orderSequence": ['desc', 'asc'],
		"ordering": true, // Set true agar bisa di sorting
		"order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		"ajax":
		{
			"url": base_url +"barang/getdatabarangbaru", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				d.filt = $('#filter').val();
				d.filtinv = $('#filterinv').val();
				d.filtact = $('#filteract').val();
            }
		},
		"deferRender": true,
		"aLengthMenu": [[5, 10, 50, 100],[ 5, 10, 50, 100]], // Combobox Limit
		"pageLength": 50,
		"dom": '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{"data": 'kode',"sortable": false, 
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}  
			},
			{ "data": "kode" },
			{ "data": "nama_barang",
				"render": 
				function( data, type, row, meta ) {
					// return data.substr(0, 60);
					var id = row.id;
					var nok = meta.row + meta.settings._iDisplayStart + 1;
					return '<a href="'+base_url+'barang/viewdata/'+id+'/'+nok+ '" rel="'+id+'" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="View data" title="view data Barang">'+data+'</a>'
				},
			 },
			{ "data": "imdo",
				"render" :
				function(data, type,row,meta){
					if(data==1){
						return '<span class="badge badge-outline text-pink">IM</span>';
					}else{
						return '<span class="badge badge-outline text-cyan">LO</span>';
					}
				}
			 },
			{ "data": "nama_kategori" },
			{ "data": "kodesatuan" },
			{ "data": "dln",
				"render" :
				function(data, type,row,meta){
					if(data==1){
						return '<i class="fa fa-check text-success"></i>';
					}else{
						return '-';
					}
				}
			},
			{ "data": "noinv",
				"render" :
				function(data, type,row,meta){
					if(data==1){
						return '<i class="fa fa-check text-success"></i>';
					}else{
						return '-';
					}
				}
			 },
			{ "data": "act", 
				"render" :
				function(data, type,row,meta){
					if(data==1){
						return '<i class="fa fa-check text-success"></i>';
					}else{
						return '-';
					}
				}
			},
			{ "data": "safety_stock",
				"render": 
				function( data, type, row, meta ) {
					return rupiah(data,'.',',',2);
				},
				className: "text-right"
			 },
			{ "data": "id",
				"render": 
				function( data, type, row, meta ) {
					var nok = meta.row + meta.settings._iDisplayStart + 1;
					var buton2 = '';
					buton2 = '<div class="btn-group" role="group">';
					buton2 += '<label for="btn-radio-dropdown-dropdown" class="btn btn-sm btn-success btn-flat dropdown-toggle text-black" style="padding:3px 4px !important;" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
					buton2 += 'Aksi';
					buton2 += '</label>';
					buton2 += '<div class="dropdown-menu">';
					buton2 += '<label class="dropdown-item p-1">';
					buton2 += '<a href='+base_url+'barang/editdata/'+data+'/'+nok+' rel="'+data+ '" rel2="'+nok+' data-title="Edit Data Barang" class="btn btn-sm btn-primary btn-icon text-white w-100" rel="' +data+ '" title="Edit data">';
					buton2 += '<i class="fa fa-edit pr-1"></i> Edit Data';
					buton2 += '</a>';
					buton2 += '</label>';
					if ($("#isisafety").val() != 'hilang') {
						buton2 += '</label>';
						buton2 += '<label class="dropdown-item p-1">';
						buton2 += '<a href='+base_url+'barang/isistock/'+data+'/'+nok+' class="btn btn-sm btn-info btn-icon w-100" id="edituser" rel="'+data+'" title="View data" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Isi Safety Stock">';
						buton2 += '<i class="fa fa-info pr-1"></i> Isi Safety Stock';
						buton2 += '</a>';
						buton2 += '</label>';
					}
					buton2 += '<label class="dropdown-item p-1">';
					buton2 += '<a href='+base_url+'barang/bombarang/'+data+' class="btn btn-sm btn-cyan btn-icon w-100" id="edituser" rel="'+data+'" title="Add Data BOM" >';
					buton2 += 'BOM';
					buton2 += '</a>';
					buton2 += '</label>';
					buton2 += '</div>';
					buton2 += '</div>';
					return buton2;
				}
			},
		],
	});
	// DataTable.defaults.column.orderSequence = ['desc', 'asc'];
});
// });

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
