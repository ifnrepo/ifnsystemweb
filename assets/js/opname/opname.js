$(document).ready(function(){
    // alert('XXXX');
	var isi = $("#deptstok").val();
	var peri = $("#periode").val();
	if(isi=='' || peri==''){
		$("#tambahstok").addClass('disabled');
	}else{
		$("#tambahstok").removeClass('disabled');
	}
	$("#keywordinputstok").focus();
})

$("#refreshperiode").click(function(){
    $.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/getperiode",
		data: {
			tgl: $("#tgl_so").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#batalsublok").click(function(){
	window.location.reload();
})
$("#tambahsublok").click(function(){
	if($("#deptsublok").val()==''){
		pesan('Pilih dahulu Departemen !','error');
		return false;
	}
	if($("#tambahsublok").html()=='Tambah Sublok'){
		$.ajax({
			// dataType: "json",
			type: "POST",
			url: base_url + "opname/getkodelokasi",
			data: {
				dept: $("#deptsublok").val(),
			},
			success: function (data) {
				$("#kode_lokasi").val(data);
				$('#tambahsublok').html('Simpan');
				$("#nama_lokasi").focus();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	}else{
		if($("#nama_lokasi").val()==''){
			pesan('Isi nama Lokasi terlebih dahulu !','info');
			return false;
		}
		if($("#tambahsublok").html()=='Update'){
			$.ajax({
				// dataType: "json",
				type: "POST",
				url: base_url + "opname/updatesublok",
				data: {
					id: $("#idsublok").val(),
					nama: $("#nama_lokasi").val()
				},
				success: function (data) {
					window.location.reload();
					// $("#dept_tuju").change();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}else{
			$.ajax({
				// dataType: "json",
				type: "POST",
				url: base_url + "opname/simpansublok",
				data: {
					kode: $("#kode_lokasi").val(),
					dept: $("#deptsublok").val(),
					nama: $("#nama_lokasi").val()
				},
				success: function (data) {
					window.location.reload();
					// $("#dept_tuju").change();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}
	}
})
$(document).on('click','#editsublok',function(){
	var idx = $(this).attr('rel');
	$.ajax({
			dataType: "json",
			type: "POST",
			url: base_url + "opname/editsublok",
			data: {
				id: $(this).attr('rel'),
			},
			success: function (data) {
				$("#idsublok").val(data['id']);
				$("#kode_lokasi").val(data['kode_lokasi']);
				$("#nama_lokasi").val(data['nama_lokasi']);
				$('#tambahsublok').html('Update');
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
})
$("#deptsublok").change(function(){
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/setdeptsublok",
		data: {
			dept: $("#deptsublok").val(),
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
})
$("#getsublok").click(function(){
	alert('GET Data');
})

$("#statusstok").change(function(){
	$("#deptstok").change();
})

$("#deptstok").change(function(){
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/filterstok",
		data: {
			status: $("#statusstok").val(),
			dept: $("#deptstok").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#cariinputstok").click(function(){
	var selectradio = $('input[name="radios-filter"]:checked').val();
	var isikeyword = $("#keywordinputstok").val(); 
	$("#cariinputstok").html('<span class="font-kecil"><i class="fa fa-circle-o-notch fa-spin mr-1"></i> Loading !</span>');
	$("#carinputstok").addClass('disabled');
	var lentext = selectradio=='carinobale' ? 0 : 3;
	if(isikeyword.length > lentext){
		if(selectradio=='cariidbarang'){
			// Berdasarkan ID Barang
			$.ajax({
				dataType: "json",
				type: "POST",
				url: base_url + "opname/cariidbarang",
				data: {
					keyw: isikeyword,
					dept: $("#deptid").val()
				},
				success: function (data) {
					$("#cariinputstok").html('Cari !');
					$("#carinputstok").removeClass('disabled');
					var jumlah = data.jumlah;
					if(jumlah==0){
						pesan('Data ID Barang tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
						return false;
					}else if(jumlah==1){
						$("#form-hasilcari").removeClass('hilang');
						$("#form-cari").addClass('hilang');
						$("#idbarang").val(data.hasil[0]['id_barang']);
						$("#po").val(data.hasil[0]['po']);
						$("#item").val(data.hasil[0]['item']);
						$("#dis").val(data.hasil[0]['dis']);
						$("#sku").val(data.hasil[0]['kode']);
						$("#spek").val(data.hasil[0]['nama_barang']);
						$("#insno").val(data.hasil[0]['insno']);
						$("#nobontr").val(data.hasil[0]['nobontr']);
						$("#dln").val(data.hasil[0]['dln']);
						$("#keywordinputstok").val('');
						$("#sku").focus();
					}else{
						// alert('Data ada 2 atau lebih');
						// $("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
						// $("#caribarangdouble").attr('rel2',selectradio);
						$("#caribarangdouble").attr('href',base_url+'opname/cari/caribarang/'+$("#deptid").val()+'/'+isikeyword.trim());
						$("#caribarangdouble").click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}else if(selectradio=='caripo'){
			// Berdasarkan PO atau Instruksi
			$.ajax({
				dataType: "json",
				type: "POST",
				url: base_url + "opname/cariinsnopo",
				data: {
					keyw: isikeyword,
					dept: $("#deptid").val()
				},
				success: function (data) {
					$("#cariinputstok").html('Cari !');
					$("#carinputstok").removeClass('disabled');
					var jumlah = data.jumlah;
					if(jumlah==0){
						pesan('Data PO atau Insno tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
						return false;
					}else if(jumlah==1){
						$("#form-hasilcari").removeClass('hilang');
						$("#form-cari").addClass('hilang');
						$("#idbarang").val(data.hasil[0]['id_barang']);
						$("#po").val(data.hasil[0]['po']);
						$("#item").val(data.hasil[0]['item']);
						$("#dis").val(data.hasil[0]['dis']);
						if(data.hasil[0]['po'].trim()==''){
							$("#sku").val(data.hasil[0]['kode']);
							$("#spek").val(data.hasil[0]['nama_barang']);
						}else{
							$("#sku").val(data.hasil[0]['skupo']);
							$("#spek").val(data.hasil[0]['spek']);
							$("#color").val(data.hasil[0]['color']);
						}
						$("#insno").val(data.hasil[0]['insno']);
						$("#nobontr").val(data.hasil[0]['nobontr']);
						$("#dln").val(data.hasil[0]['dln']);
						if($("#deptid").val()=='GF' || $("#deptid").val()=='GW'){
							$("#kgs").val(data.hasil[0]['kgs_akhir']);
							$("#pcs").val(data.hasil[0]['pcs_akhir']);
							$("#nobale").val(data.hasil[0]['nobale']);
							$("#satuan").val('PCS');
						}
						$("#keywordinputstok").val('');
						$("#sku").focus();
					}else{
						// alert('Data ada 2 atau lebih');
						// $("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
						// $("#caribarangdouble").attr('rel2',selectradio);
						$("#caribarangdouble").attr('href',base_url+'opname/cari/cariinsnopo/'+$("#deptid").val()+'/'+isikeyword.trim());
						$("#caribarangdouble").click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}else if(selectradio=='carispek'){
			// Berdasarkan Spek Barang
			$.ajax({
				dataType: "json",
				type: "POST",
				url: base_url + "opname/carispekbarang",
				data: {
					keyw: isikeyword,
					dept: $("#deptid").val()
				},
				success: function (data) {
					$("#cariinputstok").html('Cari !');
					$("#carinputstok").removeClass('disabled');
					var jumlah = data.jumlah;
					if(jumlah==0){
						pesan('Data Spek Barang tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
						return false;
					}else if(jumlah==1){
						$("#form-hasilcari").removeClass('hilang');
						$("#form-cari").addClass('hilang');
						$("#idbarang").val(data.hasil[0]['id_barang']);
						$("#po").val(data.hasil[0]['po']);
						$("#item").val(data.hasil[0]['item']);
						$("#dis").val(data.hasil[0]['dis']);
						if(data.hasil[0]['po'].trim()==''){
							$("#sku").val(data.hasil[0]['kode']);
							$("#spek").val(data.hasil[0]['nama_barang']);
						}else{
							$("#sku").val(data.hasil[0]['skupo']);
							$("#spek").val(data.hasil[0]['spek']);
							$("#color").val(data.hasil[0]['color']);
						}
						if($("#deptid").val()=='GF' || $("#deptid").val()=='GW'){
							$("#kgs").val(data.hasil[0]['kgs_akhir']);
							$("#pcs").val(data.hasil[0]['pcs_akhir']);
							$("#nobale").val(data.hasil[0]['nobale']);
							$("#satuan").val('PCS');
						}
						$("#insno").val(data.hasil[0]['insno']);
						$("#nobontr").val(data.hasil[0]['nobontr']);
						$("#dln").val(data.hasil[0]['dln']);
						$("#keywordinputstok").val('');
						$("#sku").focus();
					}else{
						// alert('Data ada 2 atau lebih');
						// $("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
						// $("#caribarangdouble").attr('rel2',selectradio);
						var newStr = isikeyword.replace(" ", "-"); 
						$("#caribarangdouble").attr('href',base_url+'opname/cari/carispekbarang/'+$("#deptid").val()+'/'+newStr);
						$("#caribarangdouble").click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}else{
			// Berdasarkan Nomor Bale
			$.ajax({
				dataType: "json",
				type: "POST",
				url: base_url + "opname/carinomorbale",
				data: {
					keyw: isikeyword,
					dept: $("#deptid").val()
				},
				success: function (data) {
					$("#cariinputstok").html('Cari !');
					$("#carinputstok").removeClass('disabled');
					var jumlah = data.jumlah;
					if(jumlah==0){
						pesan('Data Nomor Bale tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
						return false;
					}else if(jumlah==1){
						$("#form-hasilcari").removeClass('hilang');
						$("#form-cari").addClass('hilang');
						$("#idbarang").val(data.hasil[0]['id_barang']);
						$("#po").val(data.hasil[0]['po']);
						$("#item").val(data.hasil[0]['item']);
						$("#dis").val(data.hasil[0]['dis']);
						if(data.hasil[0]['po'].trim()==''){
							$("#sku").val(data.hasil[0]['kode']);
							$("#spek").val(data.hasil[0]['nama_barang']);
						}else{
							$("#sku").val(data.hasil[0]['skupo']);
							$("#spek").val(data.hasil[0]['spek']);
							$("#color").val(data.hasil[0]['color']);
						}
						$("#insno").val(data.hasil[0]['insno']);
						$("#nobontr").val(data.hasil[0]['nobontr']);
						$("#dln").val(data.hasil[0]['dln']);
						if($("#deptid").val()=='GF' || $("#deptid").val()=='GW'){
							$("#kgs").val(data.hasil[0]['kgs_akhir']);
							$("#pcs").val(data.hasil[0]['pcs_akhir']);
							$("#nobale").val(data.hasil[0]['nobale']);
							$("#satuan").val('PCS');
						}
						$("#satuan").val('PCS');
						$("#keywordinputstok").val('');
						$("#sku").focus();
					}else{
						// alert('Data ada 2 atau lebih');
						// $("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
						// $("#caribarangdouble").attr('rel2',selectradio);
						var newStr = isikeyword.replace(" ", "-"); 
						$("#caribarangdouble").attr('href',base_url+'opname/cari/carinomorbale/'+$("#deptid").val()+'/'+newStr);
						$("#caribarangdouble").click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}
	}else{
		pesan('Minimal 4 Huruf untuk memulai Pencarian','info');
		$("#cariinputstok").html('Cari !');
		$("#carinputstok").removeClass('disabled');
		return false;
	}
})
$("#cariinputmesin").click(function(){
	var selectradio = $('input[name="radios-filter"]:checked').val();
	var isikeyword = $("#keywordinputmesin").val(); 
	$("#carinputmesin").addClass('disabled');
	$("#cariinputmesin").html('<span class="font-kecil"><i class="fa fa-circle-o-notch fa-spin mr-1"></i> Loading !</span>');
	if(isikeyword.length > 3){
		$.ajax({
			dataType: "json",
			type: "POST",
			url: base_url + "opname/cariinsnomesin",
			data: {
				keyw: isikeyword,
				dept: $("#deptid").val()
			},
			success: function (data) {
				$("#cariinputmesin").html('Cari !');
				$("#carinputmesin").removeClass('disabled');
				var jumlah = data.jumlah;
				if(jumlah==0){
					pesan('Data PO atau Insno tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
					return false;
				}else if(jumlah==1){
					$("#form-hasilcari").removeClass('hilang');
					$("#form-cari").addClass('hilang');
					$("#idbarang").val(data.hasil[0]['id_barang']);
					$("#po").val(data.hasil[0]['po']);
					$("#item").val(data.hasil[0]['item']);
					$("#dis").val(data.hasil[0]['dis']);
					if(data.hasil[0]['po'].trim()==''){
						$("#sku").val(data.hasil[0]['kode']);
						$("#spek").val(data.hasil[0]['nama_barang']);
					}else{
						$("#sku").val(data.hasil[0]['skupo']);
						$("#spek").val(data.hasil[0]['spek']);
						$("#color").val(data.hasil[0]['color']);
					}
					$("#insno").val(data.hasil[0]['insno']);
					$("#nobontr").val(data.hasil[0]['nobontr']);
					$("#dln").val(data.hasil[0]['dln']);
					$("#keywordinputmesin").val('');
					$("#po").change();
					$("#sku").focus();
				}else{
					// alert('Data ada 2 atau lebih');
					// $("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
					// $("#caribarangdouble").attr('rel2',selectradio);
					var newStr = isikeyword.replace(" ", "-"); 
					$("#caribarangdouble").attr('href',base_url+'opname/cari/cariinsnomesin/'+$("#deptid").val()+'/'+newStr.trim());
					$("#caribarangdouble").click();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	}else{
		pesan('Minimal 4 Huruf untuk memulai Pencarian','info');
		$("#cariinputstok").html('Cari !');
		$("#carinputstok").removeClass('disabled');
		return false;
	}
})
$('#keywordinputstok').on('keydown', function(e) {
  if (e.key === "Enter") {
    $("#cariinputstok").click();
  }
});
$('#keywordinputmesin').on('keydown', function(e) {
  if (e.key === "Enter") {
    $("#cariinputmesin").click();
  }
});
$("#resetinputstok").click(function(){
	window.location.reload();
});
$('#pcs').on('keydown', function(e) {
  if (e.key === "Enter") {
    $("#pcs").blur();
  }
});
$("#pcs").blur(function(){
	var deptid = $("#deptid").val();
	if($("#po").val()!='' && (deptid!='GS' || deptid!='NT')){
		$.ajax({
			// dataType: "json",
			type: "POST",
			url: base_url + "opname/cariberatpo",
			data: {
				po: $("#po").val(),
				item: $("#item").val(),
				dis: $("#dis").val(),
				sat: $("#satuan").val()
			},
			success: function (data) {
				var pcs = parseFloat($("#pcs").val());
				var kgs = parseFloat(data);
				$("#kgs").val(pcs*kgs);
				$("#kgs").focus();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			},
		});
	}
})
$("#simpaninputstok").click(function(){
	if($("#idbarang").val()=='' && $("#po").val()==''){
		pesan('Barang yang akan di input tidak ada !','info');
		return false;
	}
	if($("#satuan").val()=='X'){
		pesan('Pilih satuan dahulu !','info');
		return false;
	}
	if(($("#pcs").val()=='' || $("#pcs").val()=='0') && ($("#kgs").val()=='' || $("#kgs").val()=='0')){
		pesan('Isi Pcs atau Berat barang !','info');
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/simpanentristok",
		data: {
			id: $("#id").val(),
			dept: $("#deptid").val(),
			po: $("#po").val(),
			item: $("#item").val(),
			dis: $("#dis").val(),
			idb: $("#idbarang").val(),
			insno: $("#insno").val(),
			nobontr: $("#nobontr").val(),
			exnet: $("#exnet").val(),
			stok: $("#stok").val(),
			dln: $("#dln").val(),
			nobale: $("#nobale").val(),
			satuan: $("#satuan").val(),
			pcs: $("#pcs").val(),
			kgs: $("#kgs").val(),
			ket: $("#ket").val(),
			nobc: $("#nomor_bc").val()
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#updateinputstok").click(function(){
	if($("#idbarang").val()=='' && $("#po").val()==''){
		pesan('Barang yang akan di input tidak ada !','info');
		return false;
	}
	if($("#satuan").val()=='X'){
		pesan('Pilih satuan dahulu !','info');
		return false;
	}
	if(($("#pcs").val()=='' || $("#pcs").val()=='0') && ($("#kgs").val()=='' || $("#kgs").val()=='0')){
		pesan('Isi Pcs atau Berat barang !','info');
		return false;
	}
	$(this).html('Loading..');
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/updateentristok",
		data: {
			id: $("#identristok").val(),
			po: $("#po").val(),
			item: $("#item").val(),
			dis: $("#dis").val(),
			idb: $("#idbarang").val(),
			insno: $("#insno").val(),
			nobontr: $("#nobontr").val(),
			exnet: $("#exnet").val(),
			stok: $("#stok").val(),
			dln: $("#dln").val(),
			nobale: $("#nobale").val(),
			satuan: $("#satuan").val(),
			pcs: $("#pcs").val(),
			kgs: $("#kgs").val(),
			ket: $("#ket").val(),
			urut: $("#urut").val(),
			nobc: $("#nomor_bc").val(),
			dept: $("#deptid").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$(document).on('click','#editentristok',function(){
	var obj = $(this);
	obj.html('Load');	
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/editentristok",
		data: {
			id: $(this).attr('rel'),
			page: $(this).attr('rel2'),
			kode: $(this).attr('rel3')
		},
		success: function (data) {
			// window.location.reload();
			obj.html('Edit');	
			var pcsc = data.pcs;
			$("#form-cari").addClass('hilang');
			$("#form-hasilcari").removeClass('hilang');
			$("#simpaninputstok").addClass('hilang');
			$("#updateinputstok").removeClass('hilang');
			$("#urutdata").removeClass('hilang');
			$("#po").val(data.po);
			$("#item").val(data.item);
			$("#dis").val(data.dis);
			$("#idbarang").val(data.id_barang);
			$("#insno").val(data.insno);
			$("#nobontr").val(data.nobontr);
			$("#exnet").val(data.exnet)
			$("#stok").val(data.stok);
			$("#dln").val(data.dln);
			$("#nomor_bc").val(data.nomor_bc);
			$("#nobale").val(data.nobale);
			$("#satuan").val(data.satuan);
			$("#pcs").val(data.pcsc);
			$("#kgs").val(data.kgsc);
			$("#ket").val(data.ket);
			$("#identristok").val(data.id);
			$("#urut").val(data.urut);
			if(data.po.trim()!=""){
				$("#spek").val(data.spek);
				$("#sku").val(data.skupo);
			}else{
				$("#spek").val(data.nama_barang);
				$("#sku").val(data.kode);
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$(document).on('click','#verifentristok',function(){
	var isi = $(this).attr('rel');
	$(this).html('Loading..');	
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "opname/verifentristok",
		data: {
			id: isi
		},
		success: function (data) {
			// alert(data);
			$("#kolomverif"+isi).html('<div class="font-kecil line-11 text-blue"><a href="#">Verified<br>'+data+'</a></div>');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$(document).on('click','#verifentrimesin',function(){
	var isi = $(this).attr('rel');
	$(this).html('Loading..');	
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "opname/verifentrimesin",
		data: {
			id: isi
		},
		success: function (data) {
			// alert(data);
			$("#kolomverif"+isi).html('<div class="font-kecil line-11 text-blue"><a href="#">Verified<br>'+data+'</a></div>');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$(document).on('click','#rilisentristok',function(){
	var isi = $(this).attr('rel');
	$(this).html('Loading..');	
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "opname/rilisentristok",
		data: {
			id: isi
		},
		success: function (data) {
			// alert(data);
			$("#kolomverif"+isi).html('<div class="font-kecil line-11 text-blue"><a href="#">Verified<br>'+data+'</a></div>');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$(document).on('click','#rilisentrimesin',function(){
	var isi = $(this).attr('rel');
	$(this).html('Loading..');	
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "opname/rilisentrimesin",
		data: {
			id: isi
		},
		success: function (data) {
			// alert(data);
			$("#kolomverif"+isi).html('<div class="font-kecil line-11 text-blue"><a href="#">Verified<br>'+data+'</a></div>');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$("#machnoonmesin").change(function(){
	$("#keywordinputmesin").focus();
	cekisidata();
})
$("#po").change(function(){
	cekisidata();
});
$("#resetdataonmachine").click(function(){
	window.location.reload();
});
$("#simpandataonmachine").click(function(){
	if($("#machnoonmesin").val()==''){
		pesan('Pilih Mesin terlebih dahulu !');
		return false;
	}
	if($("#po").val()=='' || $("#insno").val()==''){
		pesan('Po tidak sesuai, Cari PO kembali !');
		return false;
	}
	$(this).html('Loading..');
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/simpandataonmesin",
		data: {
			id: $("#id").val(),
			mesin: $("#machnoonmesin").val(),
			po: $("#po").val(),
			item: $("#item").val(),
			dis: $("#dis").val(),
			idbarang: $("#idbarang").val(),
			insno: $("#insno").val(),
			bunko: $("#bunko").val(),
			bunjmlbox: $("#bunjmlbox").val(),
			bunbrtbox: $("#bunbrtbox").val(),
			bunjmlmsn: $("#bunjmlmsn").val(),
			bunbrtmsn: $("#bunbrtmsn").val(),
			jnsbob: $("#jnsbob").val(),
			bobko: $("#bobko").val(),
			bobisi: $("#bobisi").val(),
			bobjmlmsn: $("#bobjmlmsn").val(),
			jmbobspl: $("#jmbobspl").val(),
			lot_dari: $("#lot_dari").val(),
			lot_sampai: $("#lot_sampai").val(),
			rpm: $("#rpm").val(),
		},
		success: function (data) {
			window.location.reload();
			// alert(data);
			// $("#kolomverif"+isi).html('<div class="font-kecil line-11 text-blue"><a href="#">Verified<br>'+data+'</a></div>');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$("#updatedataonmachine").click(function(){
	if($("#machnoonmesin").val()==''){
		pesan('Pilih Mesin terlebih dahulu !');
		return false;
	}
	if($("#po").val()=='' || $("#insno").val()==''){
		pesan('Po tidak sesuai, Cari PO kembali !');
		return false;
	}
	$(this).html('Loading..');
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/updatedataonmesin",
		data: {
			id: $("#identristok").val(),
			idstok: $("#idstokopname").val(),
			mesin: $("#machnoonmesin").val(),
			po: $("#po").val(),
			item: $("#item").val(),
			dis: $("#dis").val(),
			idbarang: $("#idbarang").val(),
			insno: $("#insno").val(),
			bunko: $("#bunko").val(),
			bunjmlbox: $("#bunjmlbox").val(),
			bunbrtbox: $("#bunbrtbox").val(),
			bunjmlmsn: $("#bunjmlmsn").val(),
			bunbrtmsn: $("#bunbrtmsn").val(),
			jnsbob: $("#jnsbob").val(),
			bobko: $("#bobko").val(),
			bobisi: $("#bobisi").val(),
			bobjmlmsn: $("#bobjmlmsn").val(),
			jmbobspl: $("#jmbobspl").val(),
			lot_dari: $("#lot_dari").val(),
			lot_sampai: $("#lot_sampai").val(),
			rpm: $("#rpm").val(),
		},
		success: function (data) {
			window.location.reload();
			// alert(data);
			// $("#kolomverif"+isi).html('<div class="font-kecil line-11 text-blue"><a href="#">Verified<br>'+data+'</a></div>');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$("#jnsbob").change(function(){
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "opname/getberatbobin",
		data: {
			bob: $("#jnsbob").val(),
		},
		success: function (data) {
			$("#bobko").val(data);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$("#carikodesublok").click(function(){
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "opname/carisublok",
		data: {
			cari: $("#carisublok").val(),
		},
		success: function (data) {
			// $("#bobko").val(data);
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$("#resetcarisublok").click(function(){
	$("#carisublok").val('');
	$("#carikodesublok").click();
})
$("#caridataentry").click(function(){
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "opname/carientri",
		data: {
			cari: $("#carientri").val(),
		},
		success: function (data) {
			// $("#bobko").val(data);
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	})
})
$("#resetdataentry").click(function(){
	$("#carientri").val('');
	$("#caridataentry").click();
})
$('#carisublok').on('keypress', function(e) {
    if (e.which === 13) {
		$("#carikodesublok").click();
    }
});
$('#carientri').on('keypress', function(e) {
    if (e.which === 13) {
		$("#caridataentry").click();
    }
});
function cekisidata(){
	if($("#machnoonmesin").val()!='' && $("#po").val()!=''){
		$("#cardkosong").addClass('hilang');
		$("#cardisi").removeClass('hilang');
		$("#bunko").focus();
	}
}