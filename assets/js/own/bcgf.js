var table = null;
$(document).ready(function () {
	table = $('#tabelnya').DataTable({
		"processing": true,
		// "responsive":true,
		"serverSide": true,
		"orderSequence": ['desc', 'asc'],
		"ordering": true, // Set true agar bisa di sorting
		"order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		"initComplete": function(set, json){
			// alert('Data is Loaded');
			var json = table.ajax.json();
		},
		"fnDrawCallback": function(oSettings) {
			// alert('The table has been redrawn.');
			var api = this.api();
			var api2 = api.ajax.json();
            var data = api.rows({ page: 'current' }).data().toArray();
			var panjang = api.rows({ page: 'current' }).data().length;
			// alert(api2.recordsFiltered);
			// alert(api2.recordsFiltered);
            if(api2.recordsFiltered > 0){
				$("#jumlahkgs").text(rupiah(data[0]['totalkgs'],'.',',',2));
				$("#jumlahpcs").text(rupiah(api2.recordsFiltered,'.',',',0));
			}else{
				$("#jumlahkgs").text('0');
				$("#jumlahpcs").text('0');
			}
		},
		"ajax":
		{
			"url": base_url +"bcgf/getdatabaru", // URL file untuk proses select datanya
			"type": "POST",
			// "data": function(d){
			// 	d.filt = $('#filter').val();
			// 	d.filtinv = $('#filterinv').val();
			// 	d.filtact = $('#filteract').val();
            // }
		},
		"deferRender": true,
		"aLengthMenu": [[5, 10, 25, 50, 100],[ 5, 10, 25, 50, 100]], // Combobox Limit
		"pageLength": 50,
		"dom": '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{"data": 'kode',"sortable": false, 
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}  
			},
			{ "data": "kode",
				"className": "line-11",
				"render" :
				function(data, type,row,meta){
					var nok = meta.row + meta.settings._iDisplayStart + 1;
					var id = 'OME+'+row.xpo.trim()+'+'+row.xitem.trim()+'+'+row.xdis+'+'+row.nobale.trim();
					return '<span class="text-pink font-11">'+viewsku(row.xpo,row.xitem,row.xdis)+'</span><br><a href="'+base_url+'bcgf/getdatabyid/'+id+ '" rel="'+id+'" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View data" title="view data Barang">'+row.spek+'</a>';
				}
			 },
			{ "data": "nobale" },
			{ "data": "nobale",
				"render" :
				function(data, type, row, meta){
					return 'KGS';
				}
			 },
			{ "data": "saldokgs",
				"className": "text-right",
				"render" :
				function(data, type, row, meta){
					return rupiah(data,'.',',',2);
				}
			 },
			{ "data": "inkgs",
				"className": "text-right",
				"render" :
				function(data, type, row, meta){
					return rupiah(data,'.',',',2);
				}
			 },
			{ "data": "outkgs",
				"className": "text-right",
				"render" :
				function(data, type, row, meta){
					return rupiah(data,'.',',',2);
				}
			 },
			{ "data": "adjkgs",
				"className": "text-right",
				"render" :
				function(data, type, row, meta){
					return rupiah(data,'.',',',2);
				}
			 },
			{ "data": "kode",
				"className": "text-right",
				"render" :
				function(data, type, row, meta){
					var hasil = parseFloat(row.saldokgs)+parseFloat(row.inkgs)-parseFloat(row.outkgs)+parseFloat(row.adjkgs);
					return rupiah(hasil,'.',',',2);
				}
			 },
			{ "data": "kode",
				"className": "text-right",
				"render" :
				function(data, type, row, meta){
					return rupiah(0,'.',',',2);
				}
			 },
			{ "data": "kode" },
		],
	});
});
// });


$("#updatebcgf").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var milik = $("#kepemilikan").val();
	var kat = $("#katbarang").val();

	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "error");
		return false;
	}

	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "bcgf/getdata",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			punya: milik,
			// katbar: kat
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
			// submitdata();
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
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
