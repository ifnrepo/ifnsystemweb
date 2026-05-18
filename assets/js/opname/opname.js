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
	if(isikeyword.length > 3){
		if(selectradio=='cariidbarang'){
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
						pesan('Data Barang tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
						return false;
					}else if(jumlah==1){
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
						$("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
						$("#caribarangdouble").attr('rel2',selectradio);
						$("#caribarangdouble").attr('href',base_url+'opname/cari/caribarang/'+$("#deptid").val()+'/'+data.hasil[0].id_barang);
						$("#caribarangdouble").click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}else if(selectradio=='caripo'){
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
						$("#keywordinputstok").val('');
						$("#sku").focus();
					}else{
						alert('Data ada 2 atau lebih');
						$("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
						$("#caribarangdouble").attr('rel2',selectradio);
						$("#caribarangdouble").attr('href',base_url+'opname/cari/cariinsnopo/'+$("#deptid").val()+'/'+data.hasil[0].id_barang);
						$("#caribarangdouble").click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					console.log(xhr.status);
					console.log(thrownError);
				},
			});
		}else{
			alert('Cari Berdasarkan Spek Barang');
		}
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
$("#resetinputstok").click(function(){
	window.location.reload();
});
$('#pcs').on('keydown', function(e) {
  if (e.key === "Enter") {
    $("#pcs").blur();
  }
});
$("#pcs").blur(function(){
	if($("#po").val()!=''){
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
			ket: $("#ket").val()
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
// $("#caribarangdouble").click(function(){
// 	var rel = $(this).attr('rel');
// 	var rel2 = $(this).attr('rel2'); //Caribarang berdasarkan
// 	alert(rel);
// 	alert(rel2);
// })