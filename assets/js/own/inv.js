var table = null;
$(document).ready(function () {
	$(".loadered").removeClass('hilang');
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
			$("#loadview").html('');
			$(".loadered").addClass('hilang');
			// alert(api2.recordsFiltered);
			// alert(api2.recordsFiltered);
            if(api2.recordsFiltered > 0){
				$("#jumlahkgs").text(rupiah(data[0]['totalkgs'],'.',',',2));
				$("#jumlahpcs").text(rupiah(data[0]['totalpcs'],'.',',',0));
				$("#sawalpcs").text(rupiah(data[0]['sawalpcs'],'.',',',0));
				$("#sawalkgs").text(rupiah(data[0]['sawalkgs'],'.',',',2));
				$("#inkgs").text(rupiah(data[0]['totalinkgs'],'.',',',2));
				$("#outkgs").text(rupiah(data[0]['totaloutkgs'],'.',',',2));
				$("#adjkgs").text(rupiah(data[0]['totaladjkgs'],'.',',',2));
				$("#inpcs").text(rupiah(data[0]['totalinpcs'],'.',',',0));
				$("#outpcs").text(rupiah(data[0]['totaloutpcs'],'.',',',0));
				$("#adjpcs").text(rupiah(data[0]['totaladjpcs'],'.',',',0));
				$("#jumlahrekod").text(rupiah(api2.recordsFiltered,'.',',',0));
			}else{
				$("#jumlahkgs").text('0');
				$("#jumlahpcs").text('0');
				$("#sawalpcs").text('0');
				$("#sawalkgs").text('0');
				$("#inkgs").text('0');
				$("#outkgs").text('0');
				$("#adjkgs").text('0');
				$("#inpcs").text('0');
				$("#outpcs").text('0');
				$("#adjpcs").text('0');
				$("#jumlahrekod").text('0');
			}
		},
		"ajax":
		{
			"url": base_url +"inv/getdatabaru", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				d.filt = $('#katbar').val();
				d.exdo = $('#exdonya').val();
				d.stok = $('#idstok').val();
				d.buyer = $('#idbuyer').val();
				d.exnet = $('#idexnet').val();
				d.dataneh = $('#dataneh').is(':checked');
			// 	d.filtinv = $('#filterinv').val();
			// 	d.filtact = $('#filteract').val();
            }
		},
		"deferRender": true,
		"aLengthMenu": [[5, 10, 25, 50, 100],[ 5, 10, 25, 50, 100]], // Combobox Limit
		"pageLength": 25,
		"dom": '<"pull-left"l>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{ "data": "kode",
				"className": "line-11",
				"render": function(data, type, row, meta){
					var sku = row.po.trim() == '' ? row.kode : viewsku(row.po,row.item,row.dis) ;
					var spek = row.po.trim() == '' ? row.nama_barang : row.spek ;
					var idbrg = row.id_barang == null ? 0 : row.id_barang;
					var ide = 'OME-'+encodeURIComponent(gantislash(row.po.trim()))+'-'+encodeURIComponent(gantislash(row.item.trim()))+'-'+row.dis+'-'+idbrg+'-'+encodeURIComponent(gantislash(row.nobontr.trim()))+'-'+encodeURIComponent(gantislash(row.insno.trim()))+'-'+encodeURIComponent(row.nobale.trim())+'-'+encodeURIComponent(row.nomor_bc.trim());
					return "<span class='hilang'>"+spek+"</span><span class='text-pink font-11'>"+sku+"</span>"+"<br><a href='"+base_url+"inv/viewdetail/"+ide+"' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail'>"+spek+"</a>";
				}
			 },
			{ "data": "kodeinv",
				"className": "line-11 font-11",
				"render": function(data, type, row, meta){
					return "<span>"+row.nobontr+"</span><br><span>"+row.insno+"</span>"
				}
			 },
			{ "data": "nobale" },
			{ "data": "kodesatuan",
				"className": "text-center"
			 },
			{ "data": "nomor_bc",
				"render": function(data, type, row, meta){
					return "<span class='font-kecil'>"+data+"</span>";
				}
			 },
			{ "data": "stok" ,
				"className": "text-center",
				"render": function(data, type, row, meta){
					var stok = row.stok==1 ? "A" : (row.stok==2 ? "B" : "");
					return stok;
				}
			},
			{ "data": "exnet",
				"className": "text-center",
				"render": function(data, type, row, meta){
					var exnet = row.exnet==1 ? "<span class='text-teal'>Y</span>" : "";
					return exnet;
				}
			},
			{ "data": "kodeinv",
				"className": "text-right",
				"render": function(data, type, row, meta){
					var saldo = parseFloat(row.saldopcs)+parseFloat(row.inpcs)-parseFloat(row.outpcs)+parseFloat(row.adjpcs);
					var saldokgs = row.saldopcs+row.inpcs-row.outpcs+row.adjpcs;
					return rupiah(saldo,'.',',',0);
				}
			 },
			{ "data": "kodeinv",
				"className": "text-right",
				"render": function(data, type, row, meta){
					var saldo = parseFloat(parseFloat(row.saldokgs).toFixed(2))+parseFloat(parseFloat(row.inkgs).toFixed(2))-parseFloat(parseFloat(row.outkgs).toFixed(2))+parseFloat(parseFloat(row.adjkgs).toFixed(2));
					return rupiah(saldo.toFixed(2),'.',',',2);
				}
			 },
			{ "data": "kodeinv",
				"className": "text-right",
				"render": function(data, type, row, meta){
					return rupiah(0,'.',',',2);
				}
			 },
			{ "data": "kodeinv",
				"className": "text-center",
				"render": function(data, type, row, meta){
					// return rupiah(0,'.',',',2);
					// var buto = '<a href="'+base_url+"inv/confirmverifikasidata/' . $det['idu']; ?>" class="btn btn-success btn-sm font-bold" data-bs-toggle="modal" data-bs-target="#veriftask" data-tombol="Ya" data-message="Akan memverifikasi data <br> <?= $det['nama_barang'] ?>" style="padding: 2px 3px !important" id="verifrek<?= $det['idu']; ?>" rel="<?= $det['idu']; ?>" title="<?= $det['idu']; ?>"><span>Verify</span></a>
					return "<a href='"+base_url+"inv/confirmverifikasidata/"+row.idu+"' class='btn btn-success btn-sm font-bold' data-bs-toggle='modal' data-bs-target='#veriftask' data-tombol='Ya' data-message='Akan memverifikasi data' style='padding: 2px 3px !important'>Verify</a>";
				}
			 },
		],
	});

	$("#katbar").on("change", function () {
		table.ajax.reload();
		// $("#loadview").html('<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>');
		$(".loadered").removeClass('hilang');
	});

	$("#dataneh").on("change", function () {
		table.ajax.reload();
		$(".loadered").removeClass('hilang');
	});
	$("#exdonya").on('change',function(){
		table.ajax.reload();
		$(".loadered").removeClass('hilang');
	})
	$("#idstok").on('change',function(){
		table.ajax.reload();
		$(".loadered").removeClass('hilang');
	})
	$("#idbuyer").on('change',function(){
		table.ajax.reload();
		$(".loadered").removeClass('hilang');
	})
	$("#idexnet").on('change',function(){
		table.ajax.reload();
		$(".loadered").removeClass('hilang');
	})

	// $('#textcari').on('input', function() {
    //     table.search(this.value).draw();
    // });

	$("#buttoncari").click(function(){
		var isi = $("#textcari").val();
		table.search(isi).draw();
		return false;
	})
	$("#buttonreset").click(function(){
		$("#textcari").val('');
		table.search('').draw();
		return false;
	})
	// if($("#ifndln").val()=='all'){
	// 	$("#simpaninv").removeClass('disabled');
	// }
});
function gantislash(stri){
	let cek = stri.trim();
	let jadi = cek.replaceAll("/", "+");
	let hasilx = jadi.replaceAll("-", "?");
	let hasil = hasilx.replaceAll(" ", "%20");
	return hasil;
}
$("#textcari").blur(function () {
	// var isi = $(this).val().trim();
	// $(this).val(isi);
});
$("#viewharga").click(function () {
	// // alert($(this).is(":checked"));
	// var load =
	// 	'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	// $("#loadview").html(load);
	// var kisi = $(this).is(":checked") ? 1 : 0;
	// $.ajax({
	// 	// dataType: "json",
	// 	type: "POST",
	// 	url: base_url + "inv/viewharga",
	// 	data: {
	// 		cek: kisi,
	// 	},
	// 	success: function (data) {
	// 		// alert(data);
	// 		window.location.reload();
	// 		// $("#body-table").html(data.datagroup).show();
	// 	},
	// 	error: function (xhr, ajaxOptions, thrownError) {
	// 		console.log(xhr.status);
	// 		console.log(thrownError);
	// 	},
	// });
});
$("#nomorbcnya").change(function () {
	// $("#updateinv").click();
});
$("#kontrakbcnya").change(function () {
	// $("#updateinv").click();
});
$("#tglawal").datepicker({
	autoclose: true,
	format: "dd-mm-yyyy",
	todayHighlight: true,
	maxDate: 0,
});
$("#currdept").change(function () {
	// let ini = $(this).val();
	// if (ini == "GF") {
	// 	$("#div-exdo").removeClass("hilang");
	// } else {
	// 	$("#div-exdo").addClass("hilang");
	// }
});
// $("#buttoncari").click(function () {
// 	var tglawal = $("#tglawal").val();
// 	var tglakhir = $("#tglakhir").val();
// 	var currdept = $("#currdept").val();
// 	var currdept = $("#currdept").val();
// 	var katbar = $("#katbar").val();
// 	var ifndl = $("#ifndln").val();
// 	// var katcari = document.getElementById("caribar").innerHTML;
// 	var katcari = $("input:radio[name=radios-inline]:checked").val();
// 	// $("#textcari").val("");
// 	var nomorbcnya = $("#nomorbcnya").val();
// 	var kontrakbcnya = $("#kontrakbcnya").val();
// 	var textcari = $("#textcari").val();
// 	if ($("#gbg").is(":checked")) {
// 		var gbg = 1;
// 	} else {
// 		var gbg = 0;
// 	}
// 	// alert(gbg);
// 	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
// 		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
// 		return false;
// 	}
// 	$.ajax({
// 		dataType: "json",
// 		type: "POST",
// 		url: base_url + "inv/getdata",
// 		data: {
// 			tga: tglawal,
// 			tgk: tglakhir,
// 			dpt: currdept,
// 			gbn: gbg,
// 			kat: katbar,
// 			kcari: katcari,
// 			cari: textcari,
// 			nobcnya: nomorbcnya,
// 			ifndln: ifndl,
// 			kontbc: kontrakbcnya,
// 			exdo: $("#exdonya").val(),
// 		},
// 		success: function (data) {
// 			// alert(data);
// 			console.log("KONTRAK" + kontrakbcnya);
// 			window.location.reload();
// 			// $("#body-table").html(data.datagroup).show();
// 		},
// 		error: function (xhr, ajaxOptions, thrownError) {
// 			console.log(xhr.status);
// 			console.log(thrownError);
// 		},
// 	});
// });
$("#updateinv").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var ifndl = $("#ifndln").val();
	var katbar = $("#katbar").val();
	// var katcari = document.getElementById("caribar").innerHTML;
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	$("#textcari").val("");
	var nomorbcnya = $("#nomorbcnya").val();
	var kontrakbcnya = $("#kontrakbcnya").val();
	var textcari = $("#textcari").val();
	if ($("#gbg").is(":checked")) {
		var gbg = 1;
	} else {
		var gbg = 0;
	}
	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir - Proses dibatalkan", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdata",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			idln: ifndl
			// gbn: gbg,
			// kat: katbar,
			// kcari: katcari,
			// cari: textcari,
			// nobcnya: nomorbcnya,
			// ifndln: ifndl,
			// kontbc: kontrakbcnya,
			// exdo: $("#exdonya").val(),
		},
		success: function (data) {
			// alert(data);
			console.log("KONTRAK" + kontrakbcnya);
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#updateinvwip").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	// var katcari = document.getElementById("caribar").innerHTML;
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	// $("#textcari").val("");
	var textcari = $("#textcari").val();

	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir \n Proses dibatalkan", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdatawip",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			kat: katbar,
			kcari: katcari,
			cari: textcari,
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#updateinvwipbaru").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	var textcari = $("#textcari").val();
	var ifndl = $("#ifndln").val();

	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdatawipbaru",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			kat: katbar,
			kcari: katcari,
			cari: textcari,
			ifndln: ifndl,
		},
		success: function (data) {
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
			// loadtable();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#updateinvgf").click(function () {
	var tglawal = $("#tglawal").val();
	var tglakhir = $("#tglakhir").val();
	var currdept = $("#currdept").val();
	var katbar = $("#katbar").val();
	var katcari = $("input:radio[name=radios-inline]:checked").val();
	var textcari = $("#textcari").val();
	var ifndl = $("#ifndln").val();

	// alert(gbg);
	if (new Date(tglmysql(tglawal)) > new Date(tglmysql(tglakhir))) {
		pesan("Tanggal awal lebih besar dari tanggal akhir", "info");
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/getdatagf",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			dpt: currdept,
			kat: katbar,
			kcari: katcari,
			cari: textcari,
			ifndln: ifndl,
		},
		success: function (data) {
			window.location.reload();
			// $("#body-table").html(data.datagroup).show();
			// loadtable();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
var table;
function loadtable() {
	var table = $("#tabelnya").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "bcwip/get_data_wip",
			type: "POST",
			data: function (d) {
				d.filter_kategori = $("#katbar").val();
				d.xzzz = "OME";
				console.log("Filter kategori:", d.filter_kategori);
				console.log(d.zzz);
			},
			callback: function (x) {
				alert(x);
			},
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
				class: "borderbottomred",
			},
			{
				targets: [1],
				class: "borderbottomred",
			},
			{
				targets: [2],
				class: "borderbottomred",
			},
			{
				targets: [3],
				class: "borderbottomred",
			},
			{
				targets: [4],
				class: "borderbottomred",
			},
			{
				targets: [5],
				class: "borderbottomred",
			},
			{
				targets: [6],
				class: "text-right borderbottomred",
			},
			{
				targets: [7],
				class: "text-right borderbottomred",
			},
			{
				targets: [8],
				class: "text-center borderbottomred",
			},
		],
		pageLength: 50,
		scrollY: 500,
		paging: false,
		searching: false,
		// info: false,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});
	// $("#katbar").on("change", function () {
	// 	table.ajax.reload();
	// });
}
function loadtablegf() {
	var table = $("#tabelnya").DataTable({
		processing: true,
		serverSide: true,
		order: [],
		ajax: {
			url: base_url + "bcgf/get_data_gf",
			type: "POST",
			data: function (d) {
				d.filter_kategori = $("#katbar").val();
				console.log("Filter kategori:", d.filter_kategori);
			},
			callback: function (x) {
				alert(x);
			},
		},
		columnDefs: [
			{
				targets: [0],
				orderable: false,
				class: "borderbottomred",
			},
			{
				targets: [1],
				class: "borderbottomred",
			},
			{
				targets: [2],
				class: "borderbottomred",
			},
			{
				targets: [3],
				class: "borderbottomred",
			},
			{
				targets: [4],
				class: "borderbottomred",
			},
			{
				targets: [5],
				class: "borderbottomred",
			},
			{
				targets: [6],
				class: "borderbottomred",
			},
			{
				targets: [7],
				class: "text-right borderbottomred",
			},
			{
				targets: [8],
				class: "text-right borderbottomred",
			},
			{
				targets: [9],
				class: "text-right borderbottomred",
			},
			{
				targets: [10],
				class: "text-center borderbottomred",
			},
		],
		pageLength: 50,
		scrollY: 500,
		paging: false,
		searching: false,
		// info: false,
		dom: '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
	});
	// $("#katbar").on("change", function () {
	// 	table.ajax.reload();
	// });
}
$("#tglawal").change(function () {
	// alert("CUY");
});
$("#buttoncarigf").click(function () {
	$("#updateinvgf").click();
});
$("#viewinv").change(function () {
	var load =
		'<div class="spinner-border spinner-border-sm text-secondary" role="status"></div>';
	$("#loadview").html(load);
	var kisi = $(this).is(":checked") ? 1 : 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "inv/viewinv",
		data: {
			cek: kisi,
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
			$("#loadview").html("");
			// $("#body-table").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
// $("#caribar").click(function () {
// 	var dok = document.getElementById("caribar");
// 	if (dok.innerHTML == "Cari Barang") {
// 		dok.innerHTML = "Cari SKU";
// 	} else {
// 		dok.innerHTML = "Cari Barang";
// 	}
// });
