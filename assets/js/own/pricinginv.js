$(document).ready(function(){
    if($("#tglcutoff").val()=='all'){
        $("#butgo").addClass('disabled');
    }
})
var table = null;

$("#blpricing").on('change',function(){
    updatedata();
})
$("#thpricing").on('change',function(){
    $("#blpricing").change();
})
$("#butref").click(function(){
    $("#blpricing").change();
})
$("#deptpricing").on('change',function(){
    $.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "pricinginv/gettglcutoff",
		data: {
			dept: $(this).val(),
		},
		success: function (data) {
			// window.location.reload();
            $("#tglcutoff").html(data.datagroup);
            $("#tglcutoff").change();
		},
		
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	}); 
})
$("#tglcutoff").on('change',function(){
    var isi = $(this).val();
    if(isi!='all'){
        $("#butgo").removeClass('disabled');
    }else{
        $("#butgo").addClass('disabled');
    }
})
$("#butgo").click(function(){
    $(".loadered").removeClass('hilang');
    table = $('#tabelnya').DataTable({
        "destroy": true,
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
			// $("#loadview").html('');
			$(".loadered").addClass('hilang');
			// // alert(api2.recordsFiltered);
			// // alert(api2.recordsFiltered);
            // if(api2.recordsFiltered > 0){
			// 	$("#jumlahkgs").text(rupiah(data[0]['totalkgs'],'.',',',2));
			// 	$("#jumlahpcs").text(rupiah(data[0]['totalpcs'],'.',',',0));
			// 	$("#sawalpcs").text(rupiah(data[0]['sawalpcs'],'.',',',0));
			// 	$("#sawalkgs").text(rupiah(data[0]['sawalkgs'],'.',',',2));
			// 	$("#inkgs").text(rupiah(data[0]['totalinkgs'],'.',',',2));
			// 	$("#outkgs").text(rupiah(data[0]['totaloutkgs'],'.',',',2));
			// 	$("#adjkgs").text(rupiah(data[0]['totaladjkgs'],'.',',',2));
			// 	$("#inpcs").text(rupiah(data[0]['totalinpcs'],'.',',',0));
			// 	$("#outpcs").text(rupiah(data[0]['totaloutpcs'],'.',',',0));
			// 	$("#adjpcs").text(rupiah(data[0]['totaladjpcs'],'.',',',0));
			// 	$("#jumlahrekod").text(rupiah(api2.recordsFiltered,'.',',',0));
			// }else{
			// 	$("#jumlahkgs").text('0');
			// 	$("#jumlahpcs").text('0');
			// 	$("#sawalpcs").text('0');
			// 	$("#sawalkgs").text('0');
			// 	$("#inkgs").text('0');
			// 	$("#outkgs").text('0');
			// 	$("#adjkgs").text('0');
			// 	$("#inpcs").text('0');
			// 	$("#outpcs").text('0');
			// 	$("#adjpcs").text('0');
			// 	$("#jumlahrekod").text('0');
			// }
		},
		"ajax":
		{
			"url": base_url +"pricinginv/getdatainv", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				d.dept = $('#deptpricing').val();
				d.tgl = $('#tglcutoff').val();
                d.periode = $("#periode").val();
				// d.stok = $('#idstok').val();
				// d.buyer = $('#idbuyer').val();
				// d.exnet = $('#idexnet').val();
				// d.dataneh = $('#dataneh').is(':checked');
			// 	d.filtinv = $('#filterinv').val();
			// 	d.filtact = $('#filteract').val();
            }
		},
		"deferRender": true,
		"aLengthMenu": [[5, 10, 25, 50, 100],[ 5, 10, 25, 50, 100]], // Combobox Limit
		"pageLength": 25,
		"dom": '<"pull-left"l>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{ "data": "id",
                "className": "line-11",
				"render": function(data, type, row, meta){
					var sku = row.po.trim() == '' ? row.kode : viewsku(row.po,row.item,row.dis) ;
					var spek = row.po.trim() == '' ? row.nama_barang : row.spek ;
					var idbrg = row.id_barang == null ? 0 : row.id_barang;
					// var ide = 'OME-'+encodeURIComponent(gantislash(row.po.trim()))+'-'+encodeURIComponent(gantislash(row.item.trim()))+'-'+row.dis+'-'+idbrg+'-'+encodeURIComponent(gantislash(row.nobontr.trim()))+'-'+encodeURIComponent(gantislash(row.insno.trim()))+'-'+encodeURIComponent(row.nobale.trim())+'-'+encodeURIComponent(row.nomor_bc.trim());
					return "<span class='hilang'>"+spek+"</span><span class='text-pink font-11'>"+sku+"</span>"+"<br><span class='text-primary'>"+spek+"</span>";
				}
            },
			{ "data": "insno",
                "render": function(data, type, row, meta){
					return "<span>"+row.nobontr+"</span><br><span>"+row.insno+"</span>"
				}
            },
			{ "data": "id"},
			{ "data": "nomor_bc"},
			{ "data": "nobale"},
			{ "data": "stok",
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
			{ "data": "id",
                "className": "text-right",
				"render": function(data, type, row, meta){
					var saldo = parseFloat(row.saldopcs)+parseFloat(row.inpcs)-parseFloat(row.outpcs)+parseFloat(row.adjpcs);
					var saldokgs = row.saldopcs+row.inpcs-row.outpcs+row.adjpcs;
					return rupiah(saldo,'.',',',0);
				}
            },
			{ "data": "id",
                "className": "text-right",
				"render": function(data, type, row, meta){
					var saldo = parseFloat(parseFloat(row.saldokgs).toFixed(2))+parseFloat(parseFloat(row.inkgs).toFixed(2))-parseFloat(parseFloat(row.outkgs).toFixed(2))+parseFloat(parseFloat(row.adjkgs).toFixed(2));
					return rupiah(saldo.toFixed(2),'.',',',2);
				}
            },
			{ "data": "id"},
		],
    });
    // table.destroy();
})
function updatedata(){
    $.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "pricinginv/getdata",
		data: {
			bl: $("#blpricing").val(),
			th: $("#thpricing").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}