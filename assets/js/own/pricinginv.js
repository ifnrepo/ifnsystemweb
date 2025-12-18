var table = null;
var tabledet = null;
var jadi = 0;
$(document).ready(function(){
    if($("#tglcutoff").val()==''){
        $("#butgo").addClass('disabled');
    }
	$("#buthitungbom").addClass('disabled');
	$(".loadered").removeClass('hilang');
	$(".loaderedblue").removeClass('hilang');
    table = $('#tabelnya').DataTable({
        "destroy": true,
		// "processing": true,
		// "responsive":true,
		// "scrollX": true,
		// "fixedColumns": {
        //     "start": 1, // Fixes one column at the start
        //     "end": 1    // Optionally, fixes one column at the end
        // },
		"serverSide": true,
		"orderSequence": ['desc', 'asc'],
		"ordering": true, // Set true agar bisa di sorting
		"order": [[ 10, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
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
			// $(".loadered").addClass('hilang');
			jadi++;
			// // alert(api2.recordsFiltered);
			// // alert(api2.recordsFiltered);
            if(api2.recordsFiltered > 0){
				$("#jumlahkgs").text(rupiah(data[0]['totalkgs'],'.',',',2));
				$("#jumlahpcs").text(rupiah(data[0]['totalpcs'],'.',',',0));
				$("#jumlahrek").text(rupiah(api2.recordsFiltered,'.',',',0));
				$("#buthitungbom").removeClass('disabled');
				var jmlharga = data[0]['totalamount']==null ? 0 : data[0]['totalamount'];
				$("#totalhargadet").text(rupiah(jmlharga,'.',',',8));

				var jmlkgs = toAngka($("#jumlahkgsdet").text());
				$("#selisihkgs").text(rupiah(parseFloat(jmlkgs) - parseFloat(data[0]['totalkgs']).toFixed(2),'.',',',2));
				if(parseFloat($("#selisihkgs").text()) < 0){
					$("#selisihkgs").addClass('bg-red-lt');
				}
			}else{
				$("#jumlahkgs").text('0');
				$("#jumlahpcs").text('0');
				$("#jumlahrek").text('0');
				$("#totalhargadet").text('0');
				$("#selisihkgs").text('0');
				$("#selisihkgs").addClass('bg-red-lt');
			}
			
		},
		"ajax":
		{
			"url": base_url +"pricinginv/getdatainv", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				d.dept = $('#deptcut').val();
				d.tgl = $('#tglcut').val();
                d.periode = $("#periode").val();
				d.ctgr = $('#filterctgr').val();
				d.arty = $('#filterart').val();
				d.tgkosong = $('#ceklistgprodkosong').is(':checked');
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
		// "dom": '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{ "data": "dept_id",
				"className": "line-11",
				"render": function(data, type, row, meta){
					return "<span class='text-primary'>"+data+"</span><br><span class='text-pink font-11'>"+row.sublok.trim()+"</span>";
				}
			},
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
			{ "data": "id",
				"className": "line-11 font-11",
				"createdCell" : function(td, cellData, rowData, row, col){
					$(td).attr('id', cellData);
					$(td).attr('title', cellData);
				},
                "render": function(data, type, row, meta){
					return tglmysql(row.prod_date);
				}
			},
			{ "data": "insno",
				"className": "line-11 font-11",
                "render": function(data, type, row, meta){
					return "<span>"+row.nobontr+"</span><br><span class='text-pink'>"+row.insno+"</span>"
				}
            },
			{ "data": "nobale"},
			{ "data": "kodesatuan"},
			{ "data": "nomor_bc"},
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
			{ "data": "pcs_awal",
                "className": "text-right",
				"render": function(data, type, row, meta){
					var saldo = parseFloat(row.pcs_awal)+parseFloat(row.pcs_masuk)-parseFloat(row.pcs_keluar)+parseFloat(row.pcs_adj);
					var saldokgs = row.saldopcs+row.inpcs-row.outpcs+row.adjpcs;
					return rupiah(row.pcs_akhir,'.',',',0);
				}
            },
			{ "data": "id",
                "className": "text-right",
				"render": function(data, type, row, meta){
					var saldokg = parseFloat(parseFloat(row.kgs_awal).toFixed(2))+parseFloat(parseFloat(row.kgs_masuk).toFixed(2))-parseFloat(parseFloat(row.kgs_keluar).toFixed(2))+parseFloat(parseFloat(row.kgs_adj).toFixed(2));
					return rupiah(row.kgs_akhir,'.',',',2);
				}
            },
			{ "data": "urut",
				"className": "text-center line-11 font-11 text-muted",
				"render": function(data, type, row, meta){
					return "<span>"+row.urut+"</span><br><span>ID : "+row.id+"</span>";
				}
			},
			{ "data": "nomor_bc",
				"render" : function(data, type, row, meta){
					var but = '';
					but += '<div class="dropdown">';
                	but += '<a href="#" class="btn-action btn-pills text-red" title="More" data-bs-toggle="dropdown" aria-expanded="false">';
                    but += '<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="blue" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M12 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>';
                    but += '</a>';
                    but += '<div class="dropdown-menu dropdown-menu-end line-11 font-kecil">';
                    but += '<a href="'+base_url+'pricinginv/viewdetail/'+row.id+'" data-bs-toggle="modal" data-bs-target="#modal-largescroll" data-title="View Detail" class="dropdown-item py-1">View Detail</a>';
                    but += '<a href="'+base_url+'pricinginv/edittglprod/'+row.id+'" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl" class="dropdown-item py-1">Edit Tgl Produksi</a>';
                    but += '</div>';
                    but += '</div>';

					return but;
				}
			},
		],
    });

	tabledet = $('#tabeldetailnya').DataTable({
        "destroy": true,
		// "processing": true,
		// "responsive":true,
		// "scrollX": true,
		"serverSide": true,
		"orderSequence": ['desc', 'asc'],
		"ordering": true, // Set true agar bisa di sorting
		"order": [[ 7, 'asc' ]], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
		"initComplete": function(set, json){
			// alert('Data is Loaded');
			var json = table.ajax.json();
		},
		"fnDrawCallback": function(oSettings) {
			// alert('The table has been redrawn.');
			var api2x = this.api();
			var api2det = api2x.ajax.json();
            var data = api2x.rows({ page: 'current' }).data().toArray();
			var panjang = api2x.rows({ page: 'current' }).data().length;
			// $("#loadview").html('');
			// $(".loaderedblue").addClass('hilang');
			jadi++;
			// // alert(api2.recordsFiltered);
			// // alert(api2'.recordsFiltered);
            if(api2det.recordsFiltered > 0){
				$("#jumlahkgsdet").text(rupiah(data[0]['totalkgsdet'],'.',',',2));
				$("#jumlahpcsdet").text(rupiah(data[0]['totalpcsdet'],'.',',',0));
				$("#jumlahrekdet").text(rupiah(api2det.recordsFiltered,'.',',',0));
				// var jmlharga = data[0]['tothargadet']==null ? 0 : data[0]['tothargadet'];
				// $("#totalhargadet").text(rupiah(jmlharga,'.',',',8));
				var jmlkgs = toAngka($("#jumlahkgs").text());
				$("#selisihkgs").text(rupiah(parseFloat(data[0]['totalkgsdet']).toFixed(2) - parseFloat(jmlkgs),'.',',',2));
				// $("#jumlahpcsdet").text('-');
				if(parseFloat($("#selisihkgs").text()) < 0){
					$("#selisihkgs").addClass('bg-red-lt');
				}
			}else{
				$("#jumlahkgsdet").text('0');
				$("#jumlahrekdet").text('0');
				$("#jumlahpcsdet").text('0');
				$("#selisihkgs").text('0');
				$("#selisihkgs").addClass('bg-red-lt');
			}
			
			//data[0]['totalhargadet']
			
		},
		"ajax":
		{
			"url": base_url +"pricinginv/getdatainvdet", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				d.dept = $('#deptcut').val();
				d.tgl = $('#tglcut').val();
                d.periode = $("#periode").val();
				d.ctgr = $('#filterctgr').val();
				d.arty = $('#filterart').val();
				d.bcnotfound = $('#ceklisbcnotfoundcek').is(':checked');
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
		// "dom": '<"pull-left"l><"pull-right"f>t<"bottom-left"i><"bottom-right"p>',
		"columns": [
			{ "data": "dept_id",
				"className": "line-11",
				"render": function(data, type, row, meta){
					// return "<span class='text-primary'>"+row.dept_id+"/</span><span class='text-cyan'>"+row.urut+"</span>";
					return "<span class='text-primary'>"+row.dept_id+"</span>";
				}
			 },
			{ "data": "nama_barang",
				"className": "line-11",
				"render" : function(data, type, row, meta){
					return "<span class='text-pink font-11'>"+row.kode+"</span>"+"<br><span class='text-primary'>"+data+"</span>";
				}
			 },
			{ "data": "nobontr",
				"className": "font-kecil"
			 },
			{ "data": "pcs",
				"className": "font-kecil text-right",
				"render" : function(data, type, row, meta){
					return rupiah(row.pcs,'.',',',0);
				}
			 },
			{ "data": "kgs",
				"className": "font-kecil text-right",
				"render" : function(data, type, row, meta){
					return rupiah(row.kgs,'.',',',4);
				}
			 },
			{ "data": "jns_bc",
				"className" : "line-11",
				"render" : function(data, type, row, meta){
					if(row.nomor_bc == null || row.nomor_bc.trim() == ''){
						return "<span class='text-pink'>BC Not Found</span>";
					}else{
						return "BC. "+data+"<br><span class='text-cyan font-11'>"+row.nomor_bc+" Tgl."+row.tgl_bc+"</span>";
					}
				}
			},
			{ "data": "harga_akt",
				"className": "font-kecil text-right",
				"render" : function(data, type, row, meta){
					var j = (data === null) ? 0 : data;
					return rupiah(j,'.',',',8);
				}
			 },
			{ "data": "id",
				"className": "font-kecil text-right",
				"render" : function(data, type, row, meta){
					var s = (row.harga_akt === null) ? 0 : row.harga_akt;
					var k = (row.id_satuan == 22) ? row.kgs : row.pcs;
					return rupiah(s*(parseFloat(k)),'.',',',8);
				}
			 },
			{ "data": "urut",
				"className": "text-center line-11 font-11 text-muted",
				"render": function(data, type, row, meta){
					return "<span>"+row.urut+"</span><br><span>ID Pricing : "+row.id+"</span>";
				}
			},
		],
    });

	$("#buttoncari").click(function(){
		var isi = $("#textcari").val();
		table.search(isi).draw();
		tabledet.search(isi).draw();
		return false;
	})
	$("#buttonreset").click(function(){
		// $("#textcari").val('');
		// table.search('').draw();
		// tabledet.search('').draw();
		// table.ajax.reload();
		// tabledet.ajax.reload();
		// return false;
		$("#butgo").click();
	})
	$("#filterctgr").on('change',function(){
		jadi = 0;
		table.ajax.reload();
		tabledet.ajax.reload();
		// $("#tabeldetailnya").DataTable().ajax.reload()
		$(".loadered").removeClass('hilang');
	})
	$("#filterart").on('change',function(){
		jadi = 0;
		table.ajax.reload();
		tabledet.ajax.reload();
		// $("#tabeldetailnya").DataTable().ajax.reload()
		$(".loadered").removeClass('hilang');
	})
	$("#ceklisbcnotfoundcek").on('change',function(){
		jadi = 1;
		tabledet.ajax.reload();
		$(".loadered").removeClass('hilang');
	})
	$("#ceklistgprodkosong").on('change',function(){
		jadi = 1;
		table.ajax.reload();
		$(".loadered").removeClass('hilang');
	})
})
setInterval(() => {
	if(jadi == 2){
		$(".loadered").addClass('hilang');
	}
}, 500);

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
	var isi = $("#tglcutoff").val();
    if(isi!=''){
        $("#butgo").removeClass('disabled');
    }else{
        $("#butgo").addClass('disabled');
    }
})
$("#tglcutoff").on('change',function(){
	if($(this).val()!=''){
		$("#datakategori").removeClass('hilang');
	}else{
		$("#datakategori").addClass('hilang');
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "pricinginv/getdeptoncutoff",
		data: {
			tgl: $(this).val(),
		},
		success: function (data) {
			// window.location.reload();
            $("#deptpricing").html(data.datagroup);
            $("#deptpricing").change();
		},
		
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#butgo").click(function(){
    $.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "pricinginv/getdatacutoff",
		data: {
			tglcutoff: $("#tglcutoff").val(),
			deptcutoff: $("#deptpricing").val(),
			milik: $("#filterdln").val(),
		},
		success: function (data) {
			window.location.reload();
            // $("#deptpricing").html(data.datagroup);
            // $("#deptpricing").change();
		},
		
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
    // table.destroy();
})
// $(".tbl-bom").on('click',function(){
// 	$("#bcnotfoundcek").removeClass('hilang');
// 	var cek = $("#ceklisbcnotfoundcek").prop('checked');
// 	alert(cek);
// })
// $(".tbl-inv").on('click',function(){
// 	$("#bcnotfoundcek").addClass('hilang');
// 	var cek = $("#ceklisbcnotfoundcek").prop('checked');
// 	alert(cek);
// })
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