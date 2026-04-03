var table = null;
var tablekmk = null;
$(document).ready(function () {
	// $("#currdept").change();
	$(".loadered").removeClass('hilang');
	table = $('#tabelrate').DataTable({
		// "processing": true,
		// "responsive":true,
		"serverSide": true,
		// "orderSequence": ['desc', 'asc'],
		// "ordering": true, // Set true agar bisa di sorting
		// "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
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
			$("#loadview").html('');
			$(".loadered").addClass('hilang');
			// alert(api2.recordsFiltered);
			// alert(api2.recordsFiltered);
            // if(api2.recordsFiltered > 0){
			// 	$("#jumlahkgs").text(rupiah(data[0]['totalkgs'],'.',',',2));
			// 	$("#jumlahpcs").text(rupiah(data[0]['totalpcs'],'.',',',0));
			// 	$("#sawalpcs").text(rupiah(data[0]['sawalpcs'],'.',',',0));
			// 	$("#sawalkgs").text(rupiah(data[0]['sawalkgs'],'.',',',2));
			// 	$("#inkgs").text(rupiah(data[0]['totalinkgs'],'.',',',2));
			// 	$("#outkgs").text(rupiah(data[0]['totaloutkgs'],'.',',',2));
			// 	$("#adjkgs").text(rupiah(data[0]['totaladjkgs'],'.',',',2));
			// 	$("#sokgs").text(rupiah(data[0]['totalsokgs'],'.',',',2));
			// 	$("#inpcs").text(rupiah(data[0]['totalinpcs'],'.',',',0));
			// 	$("#outpcs").text(rupiah(data[0]['totaloutpcs'],'.',',',0));
			// 	$("#adjpcs").text(rupiah(data[0]['totaladjpcs'],'.',',',0));
			// 	$("#sopcs").text(rupiah(data[0]['totalsopcs'],'.',',',0));
			// 	$("#jumlahrekod").text(rupiah(api2.recordsFiltered,'.',',',0));
			// }else{
			// 	$("#jumlahkgs").text('0');
			// 	$("#jumlahpcs").text('0');
			// 	$("#sawalpcs").text('0');
			// 	$("#sawalkgs").text('0');
			// 	$("#inkgs").text('0');
			// 	$("#outkgs").text('0');
			// 	$("#adjkgs").text('0');
			// 	$("#sokgs").text('0');
			// 	$("#inpcs").text('0');
			// 	$("#outpcs").text('0');
			// 	$("#adjpcs").text('0');
			// 	$("#sopcs").text('0');
			// 	$("#jumlahrekod").text('0');
			// }
		},
		"ajax":
		{
			"url": base_url +"kurs/getkursbi", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				// d.filt = $('#katbar').val();
				// // d.exdo = $('#exdonya').val();
				// d.stok = $('#idstok').val();
				// d.buyer = $('#idbuyer').val();
				// d.exnet = $('#idexnet').val();
				// d.dataneh = $('#dataneh').is(':checked');
				// d.opaneh = $('#opaneh').is(':checked');
				// d.nobc = $('#filtnomorbc').val();
			// 	d.filtact = $('#filteract').val();
            }
		},
		"deferRender": true,
		"aLengthMenu": [[5, 12, 25, 50, 100],[ 5, 12, 25, 50, 100]], // Combobox Limit
		"pageLength": 12,
		"dom": 'f<"pull-left"l>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{ "data": "nameu",
			  "className": "text-blue"
			},
			{ "data": "usd",
			  "className": "text-right",
			  "render": function(data, type, row, meta){
					return rupiah(row.usd,'.',',',2);
			  }
			},
			{ "data": "jpy",
			  "className": "text-right",
			  "render": function(data, type, row, meta){
					return rupiah(row.jpy,'.',',',2);
			  }
			},
			{ "data": "eur",
			  "className": "text-right",
			  "render": function(data, type, row, meta){
					return rupiah(row.eur,'.',',',2);
			  }
			},
		],
	});

	tablekmk = $('#tabelkmk').DataTable({
		// "processing": true,
		// "responsive":true,
		"serverSide": true,
		// "orderSequence": ['desc', 'asc'],
		// "ordering": true, // Set true agar bisa di sorting
		// "order": [[ 0, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		"initComplete": function(set, json){
			// alert('Data is Loaded');
			var json = tablekmk.ajax.json();
		},
		"fnDrawCallback": function(oSettings) {
			// alert('The table has been redrawn.');
			var api = this.api();
			var api2 = api.ajax.json();
            var data = api.rows({ page: 'current' }).data().toArray();
			var panjang = api.rows({ page: 'current' }).data().length;
			$("#loadview").html('');
			$(".loadered").addClass('hilang');
			// alert(api2.recordsFiltered);
			// alert(api2.recordsFiltered);
            // if(api2.recordsFiltered > 0){
			// 	$("#jumlahkgs").text(rupiah(data[0]['totalkgs'],'.',',',2));
			// 	$("#jumlahpcs").text(rupiah(data[0]['totalpcs'],'.',',',0));
			// 	$("#sawalpcs").text(rupiah(data[0]['sawalpcs'],'.',',',0));
			// 	$("#sawalkgs").text(rupiah(data[0]['sawalkgs'],'.',',',2));
			// 	$("#inkgs").text(rupiah(data[0]['totalinkgs'],'.',',',2));
			// 	$("#outkgs").text(rupiah(data[0]['totaloutkgs'],'.',',',2));
			// 	$("#adjkgs").text(rupiah(data[0]['totaladjkgs'],'.',',',2));
			// 	$("#sokgs").text(rupiah(data[0]['totalsokgs'],'.',',',2));
			// 	$("#inpcs").text(rupiah(data[0]['totalinpcs'],'.',',',0));
			// 	$("#outpcs").text(rupiah(data[0]['totaloutpcs'],'.',',',0));
			// 	$("#adjpcs").text(rupiah(data[0]['totaladjpcs'],'.',',',0));
			// 	$("#sopcs").text(rupiah(data[0]['totalsopcs'],'.',',',0));
			// 	$("#jumlahrekod").text(rupiah(api2.recordsFiltered,'.',',',0));
			// }else{
			// 	$("#jumlahkgs").text('0');
			// 	$("#jumlahpcs").text('0');
			// 	$("#sawalpcs").text('0');
			// 	$("#sawalkgs").text('0');
			// 	$("#inkgs").text('0');
			// 	$("#outkgs").text('0');
			// 	$("#adjkgs").text('0');
			// 	$("#sokgs").text('0');
			// 	$("#inpcs").text('0');
			// 	$("#outpcs").text('0');
			// 	$("#adjpcs").text('0');
			// 	$("#sopcs").text('0');
			// 	$("#jumlahrekod").text('0');
			// }
		},
		"ajax":
		{
			"url": base_url +"kurs/getkurskmk", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				// d.filt = $('#katbar').val();
				// // d.exdo = $('#exdonya').val();
				// d.stok = $('#idstok').val();
				// d.buyer = $('#idbuyer').val();
				// d.exnet = $('#idexnet').val();
				// d.dataneh = $('#dataneh').is(':checked');
				// d.opaneh = $('#opaneh').is(':checked');
				// d.nobc = $('#filtnomorbc').val();
			// 	d.filtact = $('#filteract').val();
            }
		},
		"deferRender": true,
		"aLengthMenu": [[5, 12, 25, 50, 100],[ 5, 12, 25, 50, 100]], // Combobox Limit
		"pageLength": 12,
		"dom": 'f<"pull-left"l>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{ "data": "tgl",
			  "className": "text-blue"
			},
			{ "data": "usd",
			  "className": "text-right",
			  "render": function(data, type, row, meta){
					return rupiah(row.usd,'.',',',2);
			  }
			},
			{ "data": "jpy",
			  "className": "text-right",
			  "render": function(data, type, row, meta){
					return rupiah(row.jpy,'.',',',2);
			  }
			},
			{ "data": "eur",
			  "className": "text-right",
			  "render": function(data, type, row, meta){
					return rupiah(row.eur,'.',',',2);
			  }
			},
		],
	});

});


$("#kolombi").click(function(){
	// alert('Kolom BI');
})

$("#kolomkmk").click(function(){
	// alert('Kolom KMK');
})