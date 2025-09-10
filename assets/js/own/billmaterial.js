$(document).ready(function () {
	// var url = window.location.href;
	// var pisah = url.split("/");
	// // alert(pisah[5]);
	// if (pisah[2] == "localhost") {
	// 	if (pisah[5] == "dataout") {
	// 		getdatadetailout();
	// 	}
	// } else {
	// 	if (pisah[4] == "addinvoice" || pisah[4] == "editinvoice") {
	// 		// getdatainvoice();
	// 	}
	// 	if (pisah[5] == "dataout") {
	// 		getdatadetailout();
	// 	}
	// }
	// $("#dept_kirim").change();
	// alert('OKEE');
});
$("#buttoncari").click(function(){
	var inputcari = $("#textcari").val();
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "billmaterial/carisku",
		data: {
			kode: inputcari,
		},
		success: function (data) {
			// alert(data);
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
$("#kosongkankatcari").click(function(){
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "billmaterial/kosongkancari",
		data: {
			kode: '',
		},
		success: function (data) {
			// alert(data);
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
$("#dept_kirim").change(function () {
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "in/depttuju",
		data: {
			kode: $(this).val(),
		},
		success: function (data) {
			// alert(data);
			// window.location.reload();
			$("#dept_tuju").html(data);
			// $("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});

$("#resetdetailbarang").click(function(){
	window.location.reload();
})
$("#simpandetailbarang").click(function(){
	if($("#id_barang").val() == ''){
		pesan('Barang harus di isi!')
		return false;
	}
	if($("#nobontr").val() == ''){
		pesan('Nomor IB harus di isi!')
		return false;
	}
	if($("#persen").val() == '' || $("#persen").val() == '0' || $("#persen").val() == '-'){
		pesan('Persen harus di isi!')
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "billmaterial/simpandetail",
		data: {
			idhead: $("#id_header").val(),
			id: $("#id_barang").val(),
			nobontr: $("#nobontr").val(),
			persen: $("#persen").val()
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
$("#updatedetailbarang").click(function(){
	if($("#id_barang").val() == ''){
		pesan('Barang harus di isi!')
		return false;
	}
	if($("#nobontr").val() == ''){
		pesan('Nomor IB harus di isi!')
		return false;
	}
	if($("#persen").val() == '' || $("#persen").val() == '0' || $("#persen").val() == '-'){
		pesan('Persen harus di isi!')
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "billmaterial/updatedetail",
		data: {
			idhead: $("#id_header").val(),
			iddet: $("#id_detail").val(),
			id: $("#id_barang").val(),
			nobontr: $("#nobontr").val(),
			persen: $("#persen").val()
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
$(document).on("click", "#editdetailbillmaterial", function () {
	var rel = $(this).attr("rel");
	var rel2 = $(this).attr("rel2");
	var rel3 = $(this).attr("rel3");
	var rel4 = $(this).attr("rel4");
	var rel5 = $(this).attr("rel5");
	$("#id_barang").val(rel2);
	$("#id_detail").val(rel);
	$("#nobontr").val(rel3);
	$("#persen").val(rel4);
	$("#spekbarangnya").text(rel5);
	$("#simpandetailbarang").addClass('hilang');
	$("#updatedetailbarang").removeClass('hilang');
	$("#cont-spek").removeClass('hilang');
});
$("#simpanmaterial").click(function(){
	if($("#po").val() == '' && $("#item").val()=='' && $("#dis").val()=='' && $("#id_barang").val() == ''){
		pesan('PO / Barang harus di isi!','error')
		return false;
	}
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "billmaterial/simpandata",
		data: {
			po: $("#po").val(),
			item: $("#item").val(),
			dis: $("#dis").val(),
			id_barang: $("#id_barang").val(),
			nobale: $("#nobale").val(),
			insno: $("#insno").val(),
			nobontr: $("#nobontr").val(),
			dl: $("#dl").val(),
		},
		success: function (data) {
			if(data==0){
				pesan('Data sudah ada, tidak bisa disimpan','error');
			}else{
				window.location.href = base_url+'billmaterial/edit/'+data;
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})

$(document).on("click", "#verifikasirekord", function () {
	var rel = $(this).attr("rel");
	var jmlverif = $("#jmlverif").val();
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "in/verifikasirekord",
		data: {
			id: rel,
		},
		success: function (data) {
			// alert(data[0]["name"]);
			$("#" + rel).html(
				"<div class='text-primary line-12' style='font-size: 11px !important;'>Verifikasi :" +
					data[0]["name"] +
					"<br>" +
					data["0"]["verif_tgl"] +
					"</div>",
			);
			$("#jmlverif").val(parseFloat(jmlverif) + 1);
			$("#infoverif").html(
				"Verifikasi : " + $("#jmlverif").val() + "/" + $("#jmlrek").val(),
			);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});

$("#xsimpanin").click(function () {
	var rekord = $("#jmlrek").val();
	var verif = $("#jmlverif").val();
	if (rekord != verif) {
		pesan("Semua rekord harus diverifikasi !", "error");
		return false;
	} else {
		$("#carisimpanin").click();
	}
});
$("#butgo").click(function () {
	getdatain();
	// window.location.reload();
});
//End JS
function getdatain() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "in/getdata",
		data: {
			dept_id: $("#dept_kirim").val(),
			dept_tuju: $("#dept_tuju").val(),
		},
		success: function (data) {
			// alert(data.datagroup);
			// $("#body-table").html(data.datagroup).show();
			// $("#jumlahrekod").text(rupiah(data.jmlrek, ".", ",", 0));
			// $("#jumlahpcs").text(rupiah(data.jmlpcs, ".", ",", 0));
			// $("#jumlahkgs").text(rupiah(data.jmlkgs, ".", ",", 2));
			// $("#jumlahrekode").text(rupiah(data.jmlreke, ".", ",", 0));
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
			// alert(data.jmlrek);
			// window.location.reload();
			$("#body-table").html(data.datagroup).show();
			if (data.jmlrek == 0) {
				$("#simpanout").addClass("disabled");
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
