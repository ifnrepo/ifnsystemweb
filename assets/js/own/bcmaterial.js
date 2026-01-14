var table = null;
$(document).ready(function () {
	// alert("OKE");
	var jmlrek = $("#jumlahrek").text();
	var jmlpc = $("#jumlahpc").text();
	var jmlkg = $("#jumlahkg").text();
	// var jmlidr = $("#jumlahid").text();
	// var jmlusd = $("#jumlahus").text();
	$("#jumlahrekod").text(rupiah(jmlrek, ".", ",", 0));
	$("#jumlahpcs").text('Loading...');
	$("#jumlahkgs").text('Loading...');
	// $("#jumlahidr").text(rupiah(jmlidr, ".", ",", 2));
	// $("#jumlahusd").text(rupiah(jmlusd, ".", ",", 2));
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
				// $("#jumlahrekod").text(rupiah(api2.recordsFiltered,'.',',',0));
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
				// $("#jumlahrekod").text('0');
			}
		},
		"ajax":
		{
			"url": base_url +"bcmaterial/getdatabaru/1", // URL file untuk proses select datanya
			"type": "POST",
			"data": function(d){
				d.filt = $("#katbarang").val();
				d.exdo = 'all';
				d.stok = 'all';
				d.buyer = 'all';
				d.exnet = 'all';
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
			{"data": 'kodeinv',"sortable": false, 
				render: function (data, type, row, meta) {
					return meta.row + meta.settings._iDisplayStart + 1;
				}  
			},
			{ "data": "kodeinv",
				"className": "line-11",
				"render": function(data, type, row, meta){
					var lokal = row.imdo==0 ? 'LO' : 'IM';
					var sku = row.po.trim() == '' ? lokal+'-'+row.kode : viewsku(row.po,row.item,row.dis) ;
					var spek = row.po.trim() == '' ? row.nama_barang : row.spek ;
					var idbrg = row.id_barang == null ? 0 : row.id_barang;
					var ide = 'OME-'+encodeURIComponent(gantislash(row.po.trim()))+'-'+encodeURIComponent(gantislash(row.item.trim()))+'-'+row.dis+'-'+idbrg+'-'+encodeURIComponent(gantislash(row.nobontr.trim()))+'-'+encodeURIComponent(gantislash(row.insno.trim()))+'-'+encodeURIComponent(gantislash(row.nobale.trim()))+'-'+encodeURIComponent(row.nomor_bc.trim());
					return "<span class='hilang'>"+spek+"</span><span class='text-pink font-11'>"+sku+"</span>"+"<br><a href='"+base_url+"bcmaterial/getdatabyid/"+idbrg+"' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail'>"+spek+"</a>";
				}
			},
			{ "data": "kodesatuan"},
			{ "data": "saldokgs",
				"className" : "text-right line-12",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					var pcs = rupiah(row.saldopcs,'.',',',0);
					var kgs = rupiah(row.saldokgs,'.',',',2);
					return "<span class='text-teal font-11'>"+pcs+"</span>"+"<br><span>"+kgs+"</span>";
				}
			},
			{ "data": "inkgs",
				"className" : "text-right line-12",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					var pcs = rupiah(row.inpcs,'.',',',0);
					var kgs = rupiah(row.inkgs,'.',',',2);
					return "<span class='text-teal font-11'>"+pcs+"</span>"+"<br><span>"+kgs+"</span>";
				}
			},
			{ "data": "outkgs",
				"className" : "text-right line-12",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					var pcs = rupiah(row.outpcs,'.',',',0);
					var kgs = rupiah(row.outkgs,'.',',',2);
					return "<span class='text-teal font-11'>"+pcs+"</span>"+"<br><span>"+kgs+"</span>";
				}
			},
			{ "data": "adjkgs",
				"className" : "text-right line-12",
				"render": function(data, type, row, meta){
					// return rupiah(data,'.',',',2);
					var pcs = rupiah(row.adjpcs,'.',',',0);
					var kgs = rupiah(row.adjkgs,'.',',',2);
					return "<span class='text-teal font-11'>"+pcs+"</span>"+"<br><span>"+kgs+"</span>";
				}
			},
			{ "data": "kodeinv",
				"className": "text-right line-12",
				"render": function(data, type, row, meta){
					var kgssaldo = parseFloat(row.saldokgs)+parseFloat(row.inkgs)-parseFloat(row.outkgs)+parseFloat(row.adjkgs);
					var pcssaldo = parseFloat(row.saldopcs)+parseFloat(row.inpcs)-parseFloat(row.outpcs)+parseFloat(row.adjpcs);
					var saldokgs = row.saldopcs+row.inpcs-row.outpcs+row.adjpcs;
					// return rupiah(saldo,'.',',',2);
					return "<span class='text-teal font-11'>"+rupiah(pcssaldo,'.',',',0)+"</span>"+"<br><span>"+rupiah(kgssaldo,'.',',',2)+"</span>";
				}
			 },
			{ "data": "kgs_taking",
				"className" : "text-right line-12",
				"render": function(data, type, row, meta){
					var pcs = rupiah(row.pcs_taking,'.',',',0);
					var kgs = rupiah(row.kgs_taking,'.',',',2);
					return "<span class='text-teal font-11'>"+pcs+"</span>"+"<br><span>"+kgs+"</span>";
				}
			},
			{ "data": "kodeinv",
				"className" : "text-center line-12 font-kecil",
				"render": function(data, type, row, meta){
					var pcstaking = row.pcs_taking==null ? 0 : parseFloat(row.pcs_taking);
					var kgstaking = row.kgs_taking==null ? 0 : parseFloat(row.kgs_taking);
					var kgssaldo = parseFloat(row.saldokgs)+parseFloat(row.inkgs)-parseFloat(row.outkgs)+parseFloat(row.adjkgs);
					var pcssaldo = parseFloat(row.saldopcs)+parseFloat(row.inpcs)-parseFloat(row.outpcs)+parseFloat(row.adjpcs);
					if($("#tglopname").val()!=''){
						// return 'MOMO';
						var cekpcs = pcssaldo-pcstaking;
						var cekkgs = kgssaldo-kgstaking;
						if(cekpcs != 0 && cekkgs != 0){
							return '<span class="text-red">TIDAK SESUAI</span>';
						}else{
							if(cekpcs==0 && cekkgs != 0){
								return '<span class="text-pink">SELISIH BERAT</span>';
							}else{
								if(cekpcs!=0 && cekkgs == 0){
									return '<span class="text-pink">SELISIH QTY</span>';
								}else{
									return '<span class="text-green">SESUAI</span>';
								}
							}
						}
					}else{
						return '...';
					}
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
});
// var butoncari = false;
// $("#buttoncaribckeluar").click(function () {
// 	butoncari = true;
// 	$("#updatebckeluar").click();
// });

$("#updatebcmaterial").click(function () {
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
		url: base_url + "bcmaterial/getdata",
		data: {
			tga: tglawal,
			tgk: tglakhir,
			punya: milik,
			katbar: kat
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
function gantislash(stri){
	let cek = stri.trim();
	let jadi = cek.replaceAll("/", "+");
	let hasilx = jadi.replaceAll("-", "?");
	let hasil = hasilx.replaceAll(" ", "%20");
	return hasil;
}
