$(document).ready(function () {
	$(".tgl").datepicker({
		showButtonPanel: true,
		autoclose: true,
		format: "dd-mm-yyyy",
		todayHighlight: true,
		todayBtn: "linked",
  		// clearBtn: true,
	});
	
	var url = window.location.href;
	var pisah = url.split("/");
	// alert(pisah[5]);
	if (pisah[2] == "localhost") {
		if (pisah[5] == "dataout") {
			// getdatadetailout();
		}
	} else {
		if (pisah[4] == "addinvoice" || pisah[4] == "editinvoice") {
			// getdatainvoice();
		}
		if (pisah[5] == "dataout") {
			// getdatadetailout();
		}
	}
	if ($("#errornya").val() != "" && $("#errornya").length > 0) {
		var ini = $("#errornya").val();
		var isipesan = "Periksa Stok Barang " + ini + " !";
		if (ini == "Nobontr Kosong") {
			var isipesan = "Masih ada data yang belum pakai Nomor IB, cek data !";
		}
		pesan(isipesan, "info");
	}
	var errosimpan = $("#errorparam").val();
	if (errosimpan == 1) {
		pesan("Dept Asal & Dept Tujuan harus diset terlebih dahulu !", "info");
	}
	$("#dept_kirim").change();
});
$("#dept_kirim").change(function () {
	var kirim = $(this).val();
	var darike = $("#tujuanbon").html();
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "out/depttuju",
		data: {
			kode: $(this).val(),
		},
		success: function (data) {
			if (kirim == "GS" || kirim == "GP" || kirim == "GM") {
				$("#adddataout").addClass("hilang");
				$("#buttonpilih2").removeClass("hilang");
			} else {
				$("#adddataout").removeClass("hilang");
				$("#buttonpilih2").addClass("hilang");
				$("#adddataout").html('<i class="fa fa-plus"></i><span class="ml-1">Tambah Data '+darike+'</span>');
			}
			$("#dept_tuju").html(data);
			$("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#dept_tuju").change(function () {
	// alert($(this).val());
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getkettuju",
		data: {
			dari: $("#dept_kirim").val(),
			ke: $(this).val(),
		},
		success: function (data) {
			if (data.jmlrek > 0) {
				$("#div-filter2").removeClass("hilang");
				$("#filterbon2").html(data.datagroup);
			} else {
				$("#div-filter2").addClass("hilang");
			}
			// getdataout();
			activateselectproses($("#dept_kirim").val(),$(this).val());
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#simpandetailbarang").click(function () {
	if ($("#id_barang").val() == "") {
		pesan("Isi / Cari nama barang", "error");
		return;
	}
	if ($("#id_satuan").val() == "") {
		pesan("Isi Satuan barang", "error");
		return;
	}
	if (
		($("#pcs").val() == "" || $("#pcs").val() == "0") &&
		($("#kgs").val() == "" || $("#kgs").val() == "0")
	) {
		pesan("Isi Qty atau Kgs", "error");
		return;
	}
	document.formbarangout.submit();
});
$("#bl").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "out/ubahperiode",
		data: {
			bl: $(this).val(),
			th: $("#th").val(),
		},
		success: function (data) {
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$("#th").change(function () {
	$("#bl").change();
});
$("#butgo").click(function () {
	getdataout();
});
$("#xsimpanout").click(function () {
	$("#simpanout").click();
});
// Form Tambah data Pengeluaran Biasa
$(".formpencarian").find('#po').on('keypress',function(e){
	if (e.which === 13) {
		$("#pencarianitembarang").click();
	}
})
$(".formpencarian").find('#id_barang').on('keypress',function(e){
	if (e.which === 13) {
		$("#pencarianitembarang").click();
	}
})
$("#simpanitembarang").click(function(){
	if($("#po").val()=='' && $("#id_barang").val()=='' && $("#speknya").val()==''){
		pesan('Isi PO, ID Barang, atau Spesifikasi untuk mencari barang !','info');
		return false;
	}
	if(($("#pcsout").val()=='' || $("#pcsout").val()=='0' || $("#pcsout").val()=='-') && ($("#kgsout").val()=='' || $("#kgsout").val()=='0' || $("#kgsout").val()=='-')){
		pesan('Pcs/Kgs Harus di isi !','info');
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/simpanbarangoutketemp",
		data: {
			idhead: $("#idhead").val(),
			po: $("#po").val(),
			item: $("#item").val(),
			dis: $("#dis").val(),
			idb: $("#idbarang").val(),
			insno: $("#insno").val(),
			insnosel: $("#insno-sel").val(),
			nobontr: $("#nobontr").val(),
			pcs: toAngka($("#pcsout").val()),
			kgs: toAngka($("#kgsout").val())
		},
		success: function (data) {
			kosongkanforminputbarang();
			getdatadetailtemp();
			$(".formpencarian").removeClass('hilang');
			$(".hasilpencarian").addClass('hilang');
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#batalkanitembarang").click(function(){
	kosongkanforminputbarang();
	$(".formpencarian").removeClass('hilang');
	$(".hasilpencarian").addClass('hilang');
});
$("#pencarianitembarang").click(function(){
	$(this).html('<i class="fa fa-circle-o-notch fa-spin mr-1"></i> Loading ..');
	var isiisbarang = $("#id_barang").val().trim();
	if($("#po").val()=='' && $("#id_barang").val()=='' && $("#spek").val()==''){
		$(this).html('Cari');
		pesan('Isi PO, ID Barang, atau Spesifikasi untuk mencari barang !','info');
		return false;
	}
	if($("#id_barang").val()!='' && isiisbarang.length <= 3){
		pesan('Isi Panjang ID Barang harus lebih dari 3 Karakter','info');
		$(this).html('Cari');
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/cekdatabarang",
		data: {
			po: $("#po").val().trim(),
			no: $("#item").val().trim(),
			dis: $("#dis").val().trim(),
			idb: $("#id_barang").val().trim(),
			spek: $("#spek").val().trim(),
		},
		success: function (data) {
			$("#pencarianitembarang").html('Cari');
			if(data.jml == 0){
				$("#pencarianitembarang").html('Cari');
				pesan('Barang yang anda cari tidak Ada \r\n pastikan PO, ID Barang atau Spesifikasi ditulis sesuai !','info');
				return false;
			}else{
				if(data.jml > 1){ // Data Pencarian barang lebih dari 1
					// alert('Ada lebih dari 1 !');
					var idb = $("#id_barang").val().trim();
					var po = $("#po").val().trim();
					var no = $("#item").val().trim();
					var dis = $("#dis").val().trim();
					kosongkanforminputbarang();
					if(data.mode=='brg'){
						$("#pencarianitembarangdobel").attr('href',base_url+'out/cekdatabarangdobel/brg/'+idb);
                        document.getElementById('pencarianitembarangdobel').click();
					}else{
						if(data.mode=='po'){
							$("#pencarianitembarangdobel").attr('href',base_url+'out/cekdatabarangdobel/po/'+po+'/'+no+'/'+dis);
							document.getElementById('pencarianitembarangdobel').click();
						}
					}
				}else{
					// Data Pencarian hanya 1 Barang
					// alert('Data ada 1');
					kosongkanforminputbarang();
					if(data.mode=='brg'){
						$.ajax({
							dataType: "json",
							type: "POST",
							url: base_url + "out/getdatabarangbyid/brg/"+data.idrek,
							data: {
							},
							success: function (data) {
								$("#idbarang").val(data.id);
								$("#id_barang").val(data.kode);
								$("#spek").val(data.nama_barang);
								$("#sku").val(data.kode);
								$("#speknya").val(data.nama_barang);
								$("#insno-sel").addClass('hilang');
								$("#insno").removeClass('hilang');
								$(".formpencarian").addClass('hilang');
								$(".hasilpencarian").removeClass('hilang');
								$("#insno").focus();
							},
							error: function (xhr, ajaxOptions, thrownError) {
								console.log(xhr.status);
								console.log(thrownError);
							},
						});
					}else{
						if(data.mode=='po'){
							$.ajax({
								dataType: "json",
								type: "POST",
								url: base_url + "out/getdatabarangbyid/po/"+data.idrek,
								data: {
								},
								success: function (data) {
									$("#po").val(data.po);
									$("#item").val(data.item);
									$("#dis").val(data.dis);
									$("#sku").val(data.sku);
									$("#speknya").val(data.spek);
									$("#jalamimi").val(parseFloat(data.jala)+parseFloat(data.mimi));
									$("#insno").addClass('hilang');
									$("#insno-sel").removeClass('hilang');
									$(".formpencarian").addClass('hilang');
									$(".hasilpencarian").removeClass('hilang');
									$("#kgsout").attr('readonly','readonly');
									isidatainsno(data.id);
									$("#insno-sel").focus();
								},
								error: function (xhr, ajaxOptions, thrownError) {
									console.log(xhr.status);
									console.log(thrownError);
								},
							});
						}
					}
				}
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});
$('#pcsout').on('keyup change', function() {
	var berat = parseFloat(toAngka($('#jalamimi').val())) || 0;
	var qty = parseInt(toAngka($('#pcsout').val())) || 0;
	
	var total = berat * qty;
	// Update the display with 2 decimal places
	$('#kgsout').val(rupiah(total.toFixed(2),'.',',',2));
});

// $(".hasilpencarian").find('#pcs').blur(function(){
// 	alert('MASUK');
// 	// if($(".hasilpencarian").find('#kgs').attr('readonly') !== undefined ){
// 	// 	alert('MASUK 2');
// 	// 	if($(".hasilpencarian").find('#pcs').val() != '' || $(".hasilpencarian").find('#pcs').val() != 0){
// 	// 		alert('MASUK 3');
// 	// 		var nilai = parseFloat($(".hasilpencarian").find('#pcs').val());
// 	// 		var hasil = nilai * parseFloat($("#jalamimi").val());
// 	// 		alert(hasil);
// 	// 	}
// 	// }
// })
function kosongkanforminputbarang(){
	$("#pencarianitembarang").html('Cari');
	$("#kgs").removeAttr('readonly');
	$("#insno").removeClass('hilang');
	$("#insno-sel").addClass('hilang');
	$("#po").val('');
	$("#item").val('');
	$("#dis").val('');
	$("#idbarang").val('');
	$("#id_barang").val('');
	$("#spek").val('');
	$("#sku").val('');
	$("#speknya").val('');
	$("#insno").val('');
	$("#nobontr").val('');
	$("#pcsout").val('');
	$("#kgsout").val('');
}
function isidatainsno(idx){
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/caridatainsno",
		data: {
			id: idx,
		},
		success: function (data) {
			// alert(data.jumtotdet);
			// window.location.reload();
			$("#insno-sel").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
// End Form Tambah data Pengeluaran Biasa
function activateselectproses(dari,ke){
	// $.ajax({
	// 	// dataType: "json",
	// 	type: "POST",
	// 	url: base_url + "out/cekselecp",
	// 	data: {
	// 		bl: $(this).val(),
	// 		th: $("#th").val(),
	// 	},
	// 	success: function (data) {
	// 		alert('ada');
	// 	},
	// 	error: function (xhr, ajaxOptions, thrownError) {
	// 		console.log(xhr.status);
	// 		console.log(thrownError);
	// 	},
	// });
}
function getdatadetailtemp() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getdatadetailtemp",
		data: {
			id: $("#idhead").val(),
		},
		success: function (data) {
			// alert(data.jumtotdet);
			// window.location.reload();
			$("#tabeltempbarang").html(data.datagroup).show();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function getdataout() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getdata",
		data: {
			dept_id: $("#dept_kirim").val(),
			dept_tuju: $("#dept_tuju").val(),
			filterbon: $("#filterbon").val(),
			filterbon2: $("#filterbon2").val(),
			filterproses: $("#filterproses").val(),
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
function getdatadetailout() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "out/getdatadetailout",
		data: {
			id_header: $("#id_header").val(),
		},
		success: function (data) {
			// alert(data.jumtotdet);
			// window.location.reload();
			$("#body-table").html(data.datagroup).show();
			$("#jmlrek").val(data.jmlrek);
			$("#jumtotdet").html('Total Kgs : '+rupiah(data.jumtotdet,'.',',',2));
			if (data.jmlrek == 0) {
				$("#xsimpanout").addClass("disabled");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
$("#resetdetailbarang").click(function () {
	$("#id_barang").val("");
	$("#nama_barang").val("");
	$("#id_satuan").val("");
	$("#pcs").val("");
	$("#kgs").val("");
	$("#id").val("");
	$("#keterangan").val("");
	$("#spekbarangnya").text("");
	$("#cont-spek").addClass("hilang");
});
$("#nama_barang").on("keyup", function (e) {
	if (e.key === "Enter" || e.keyCode === 13) {
		$("#caribarang").click();
		$("#caribarang").focus();
	}
});
