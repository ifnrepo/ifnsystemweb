var table = null;
var tablekmk = null;
var chrtkurs = '';
var chrtkurskmk = '';
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
		"dom": '<"pull-left"l>t<"bottom-left"i><"bottom-right"p>',
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
			{ "data": "id",
			  "className": "text-center",
			  "render": function(data, type, row, meta){
					var urly = base_url+"kurs/editkurs/"+row.id;
					return "<a href='"+urly+"' class='btn btn-primary py-1 btn-flat font-kecil' title='Edit' data-bs-toggle='modal' data-bs-target='#modal-large' data-message='Hapus IB' data-title='Edit Data Kurs BI'>Edit</a>";
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
		"dom": '<"pull-left"l>t<"bottom-left"i><"bottom-right"p>',
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

	var chrtkurs_option = {
		chart: {
			type: "line",
			fontFamily: 'inherit',
			height: 225,
			sparkline: {
				enabled: false
			},
			animations: {
				enabled: true,
			},
		},
		fill: {
			opacity: 1,
		},
		stroke: {
			width: [2, 1],
			dashArray: [0, 3],
			lineCap: "round",
			curve: "smooth",
		},
		series: [],
		noData: {
			text: 'Empty Data ...'
		},
		tooltip: {
			theme: 'dark',
			y: {
				formatter: function (val) {
				return rupiah(val,'.',',',2);
				}
			},
			x: {
				format: 'MMM yyyy'
			}
		},
		grid: {
			strokeDashArray: 4,
		},
		xaxis: {
			labels: {
				padding: 0,
			},
			tooltip: {
				enabled: false
			},
			type: 'datetime',
		},
		yaxis: {
			labels: {
				padding: 4
			},
		},
		// labels: [
		// 	'2020-06-20', '2020-06-21', '2020-06-22', '2020-06-23', '2020-06-24', '2020-06-25', '2020-06-26', '2020-06-27', '2020-06-28', '2020-06-29', '2020-06-30', '2020-07-01', '2020-07-02', '2020-07-03', '2020-07-04', '2020-07-05', '2020-07-06', '2020-07-07', '2020-07-08', '2020-07-09', '2020-07-10', '2020-07-11', '2020-07-12', '2020-07-13', '2020-07-14', '2020-07-15', '2020-07-16', '2020-07-17', '2020-07-18', '2020-07-19'
		// ],
		// labels: [],
		colors: [tabler.getColor("primary"), tabler.getColor("gray-600"), tabler.getColor("orange")],
		legend: {
			show: false,
		},
	};
	chrtkurs = new ApexCharts(document.getElementById('chart-kurs'), chrtkurs_option);
	chrtkurs.render();

	var chrtkurskmk_option = {
		chart: {
			type: "line",
			fontFamily: 'inherit',
			height: 225,
			sparkline: {
				enabled: false
			},
			animations: {
				enabled: true
			},
		},
		fill: {
			opacity: 1,
		},
		stroke: {
			width: [2, 1],
			dashArray: [0, 3],
			lineCap: "round",
			curve: "smooth",
		},
		series: [],
		noData: {
			text: 'Empty Data ...'
		},
		tooltip: {
			theme: 'dark',
			y: {
				formatter: function (val) {
				return rupiah(val,'.',',',2);
				}
			},
			x: {
				format: 'dd MMM yyyy'
			}
		},
		grid: {
			strokeDashArray: 4,
		},
		xaxis: {
			labels: {
				padding: 0,
			},
			tooltip: {
				enabled: false
			},
			type: 'datetime',
		},
		yaxis: {
			labels: {
				padding: 4
			},
		},
		colors: [tabler.getColor("primary"), tabler.getColor("gray-600"), tabler.getColor("orange")],
		legend: {
			show: false,
		},
	};
	chrtkurskmk = new ApexCharts(document.getElementById('chart-kurskmk'), chrtkurskmk_option);
	chrtkurskmk.render();

	setTimeout(() => {
		getdatakursbi(),
		getdatakurskmk()
	}, 1000);
	// getdatakursbi();
});

$("#select-kurs").change(function(){
	getdatakursbi($(this).val());
	getdatakurskmk($(this).val())
})

$("#kolombi").click(function(){
	// alert('Kolom BI');
})

$("#kolomkmk").click(function(){
	// alert('Kolom KMK');
})

function getdatakursbi(kurs=''){
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "kurs/getdatakursbiuntukchart",
		data: {
			kode: kurs
		},
		success: function (xdata) {
			// window.location.reload();
			// alert(xdata['data']);
			chrtkurs.updateSeries([
				{
					name: kurs=='' ? 'USD' : kurs,
					data: xdata['data']
				}
			]);
			chrtkurs.updateOptions({
				// series: xdata['data'],
				labels: xdata['label'] // New data
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function getdatakurskmk(kurs=''){
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "kurs/getdatakurskmkuntukchart",
		data: {
			kode: kurs
		},
		success: function (xdata) {
			// window.location.reload();
			// alert(xdata['data']);
			chrtkurskmk.updateSeries([
				{
					name: kurs=='' ? 'USD' : kurs,
					data: xdata['data']
				}
			]);
			chrtkurskmk.updateOptions({
				// series: xdata['data'],
				labels: xdata['label'] // New data
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}