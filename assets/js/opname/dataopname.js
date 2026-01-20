$(document).ready(function(){
    $(".loadered").removeClass('hilang');
	table = $('#tabelnya').DataTable({
		// "processing": true,
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
				// $("#sawalpcs").text(rupiah(data[0]['sawalpcs'],'.',',',0));
				// $("#sawalkgs").text(rupiah(data[0]['sawalkgs'],'.',',',2));
				// $("#inkgs").text(rupiah(data[0]['totalinkgs'],'.',',',2));
				// $("#outkgs").text(rupiah(data[0]['totaloutkgs'],'.',',',2));
				// $("#adjkgs").text(rupiah(data[0]['totaladjkgs'],'.',',',2));
				// $("#inpcs").text(rupiah(data[0]['totalinpcs'],'.',',',0));
				// $("#outpcs").text(rupiah(data[0]['totaloutpcs'],'.',',',0));
				// $("#adjpcs").text(rupiah(data[0]['totaladjpcs'],'.',',',0));
				$("#jumlahrekod").text(rupiah(api2.recordsFiltered,'.',',',0));
			}else{
				$("#jumlahkgs").text('0');
				$("#jumlahpcs").text('0');
				// $("#sawalpcs").text('0');
				// $("#sawalkgs").text('0');
				// $("#inkgs").text('0');
				// $("#outkgs").text('0');
				// $("#adjkgs").text('0');
				// $("#inpcs").text('0');
				// $("#outpcs").text('0');
				// $("#adjpcs").text('0');
				$("#jumlahrekod").text('0');
			}
		},
		"ajax":
		{
			"url": base_url +"opname/getdataopname", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				d.filt = 'all';
				d.exdo = 'all';
				d.stok = 'all';
				d.buyer = 'all';
				d.exnet = 'all';
				d.dataneh = 'all';
			// 	d.filtinv = $('#filterinv').val();
			// 	d.filtact = $('#filteract').val();
            }
		},
		"deferRender": true,
		"aLengthMenu": [[5, 10, 25, 50, 100],[ 5, 10, 25, 50, 100]], // Combobox Limit
		"pageLength": 25,
		"dom": '<"pull-left"l>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{"data": 'id',"sortable": false, 
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}  
			},
			{"data": 'dept_id',
				render: function (data, type, row, meta) {
					return data;
				}
			},
			{ "data": "id",
				"className": "line-11 font-kecil",
				"render": function(data, type, row, meta){
					var lokal = row.imdo==0 ? 'LO' : 'IM';
					var sku = row.po.trim() == '' ? lokal+'-'+row.kode : viewsku(row.po,row.item,row.dis) ;
					var spek = row.po.trim() == '' ? row.nama_barang : row.spek ;
					var idbrg = row.id_barang == null ? 0 : row.id_barang;
					var ide = 'OME-'+encodeURIComponent(gantislash(row.po.trim()))+'-'+encodeURIComponent(gantislash(row.item.trim()))+'-'+row.dis+'-'+idbrg+'-'+encodeURIComponent(gantislash(row.nobontr.trim()))+'-'+encodeURIComponent(gantislash(row.insno.trim()))+'-'+encodeURIComponent(gantislash(row.nobale.trim()))+'-'+encodeURIComponent(row.nomor_bc.trim())+'-'+row.deptt;
					return "<span class='hilang'>"+spek+"</span><span class='text-pink font-11'>"+sku+"</span>"+"<br><a href='#' title='View Detail'>"+spek.trim()+"</a>";
				}
			},
			{ "data": "stok",
				"className" : "text-center",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					var stok = row.stok==1 ? 'A' : (row.stok==2 ? 'B' : '');
					return stok;
				}
			},
			{ "data": "kodesatuan"},
			{ "data": "insno",
				"className": "line-11 font-kecil"
			},
			{ "data": "nobontr",
				"className": "line-11 font-kecil"
			},
			{ "data": "nobale",
				"className": "line-11 font-kecil"
			},
			{ "data": "pcs",
				"className" : "text-right line-12",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					var pcs = rupiah(row.pcs,'.',',',0);
					return pcs;
				}
			},
			{ "data": "kgs",
				"className" : "text-right line-12",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					var kgs = rupiah(row.kgs,'.',',',2);
					return kgs;
				}
			},
			{ "data": "id",
				"className" : "text-center",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					// var kgs = rupiah(row.sumkgs,'.',',',0);
					var lokal = row.imdo==0 ? 'LO' : 'IM';
					var sku = row.po.trim() == '' ? lokal+'-'+row.kode : viewsku(row.po,row.item,row.dis) ;
					var spek = row.po.trim() == '' ? row.nama_barang : row.spek ;
					var idbrg = row.id_barang == null ? 0 : row.id_barang;
					var ide = 'OME-'+encodeURIComponent(gantislash(row.po.trim()))+'-'+encodeURIComponent(gantislash(row.item.trim()))+'-'+row.dis+'-'+idbrg+'-'+encodeURIComponent(gantislash(row.nobale.trim()))+'-'+row.dept_id;
					return '<a href="'+base_url+"opname/editrekapopname/"+row.id+'" class="btn btn-sm btn-success mr-1" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Data Stok Opname" style="padding:0 3px !important">Edit</a><a href="#" data-href="'+base_url+"opname/hapusrekapopname/"+row.id+'" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data '+spek+' ('+sku+')" style="padding:0 3px !important">Hapus</a>';
				}
			},
		],
	});
	$("#buttoncari").click(function(){
		$(".loadered").removeClass('hilang');
		var isi = $("#textcari").val();
		table.search(isi).draw();
		return false;
	})
	$("#buttonreset").click(function(){
		$(".loadered").removeClass('hilang');
		$("#textcari").val('');
		table.search('').draw();
		return false;
	})
	$("#dataneh").on("change", function () {
		table.ajax.reload();
		$(".loadered").removeClass('hilang');
	});
	if($("#tglopname").val() != ''){
		$("#headopname").html('Opname<br>'+$("#tglopname").val());
		$("#cekaneh").removeClass('hilang');
	}else{
		$("#headopname").html('Opname<br>');
		$("#cekaneh").addClass('hilang');
	}
})

$("#updateopname").click(function(){
    $.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/getdata",
		data: {
			dept: $("#currdeptopname").val(),
		},
		success: function (data) {
			window.location.reload();
			// $("#dept_tuju").html(data);
			// $("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
	// window.location.reload();
})
function gantislash(stri){
	let cek = stri.trim();
	let jadi = cek.replaceAll("/", "+");
	let hasilx = jadi.replaceAll("-", "?");
	let hasil = hasilx.replaceAll(" ", "%20");
	return hasil;
}