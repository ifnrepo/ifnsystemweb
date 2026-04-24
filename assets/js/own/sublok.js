$(document).ready(function () {
	// alert('XXXX');
});
$("#thsublok").change(function(){
	$("#butgo").click();
})
$("#blsublok").change(function(){
	$("#butgo").click();
})
$("#sublokasi").change(function(){
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "sublok/filterdata",
		data: {
			// dept: $("#deptsublok").val(),
			// bulan: $("#blsublok").val(),
			// tahun: $("#thsublok").val(),
			sub: $("#sublokasi").val()
			// ctgr: $("#kategcost").val(),
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#butgo").click(function () {
	// alert($("#dept").val());
	$.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "sublok/getdata",
		data: {
			dept: $("#deptsublok").val(),
			bulan: $("#blsublok").val(),
			tahun: $("#thsublok").val(),
			// sub: $("#sublokasi").val()
			// ctgr: $("#kategcost").val(),
		},
		success: function (data) {
			// alert(data);
			window.location.reload();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
});

$("#adddata").click(function () {
	if($("#sublokasi").val()==''){
		alert('Pilih sublokasi');
		return false;
	}
	$("#adddata").attr('href',base_url+'sublok/adddata/'+$("#sublokasi").val());
	// $.ajax({
	// 	dataType: "json",
	// 	type: "POST",
	// 	url: base_url + "sublok/getlokasi",
	// 	data: {
	// 		dari: $(this).val(),
	// 		// ke: $(this).val(),
	// 	},
	// 	success: function (data) {
	// 		// if (data.jmlrek > 0) {
	// 		// 	// $("#div-filter2").removeClass("hilang");
	// 		$("#sublokasi").html(data.datagroup);
	// 		// } else {
	// 		// 	// $("#div-filter2").addClass("hilang");
	// 		// }
	// 		// getdataout();
	// 	},
	// 	error: function (xhr, ajaxOptions, thrownError) {
	// 		console.log(xhr.status);
	// 		console.log(thrownError);
	// 	},
	// });
});
$("#manual").click(function(){
	if($("#play").hasClass('disabled')){
		$("#play").removeClass('disabled');
		$("#stop").removeClass('disabled');
		$("#scanner").removeClass('disabled');
		$(this).html('Manual Mode');
		$(".input-manual").addClass('hilang');
		$(".input-scanner").addClass('hilang');
		$(".laser-area").removeClass('hilang');
		$("#scanned-QR").html('');
	}else{
		$("#stop").click();
		$("#play").addClass('disabled');
		$("#stop").addClass('disabled');
		$("#scanner").addClass('disabled');
		$(this).html('Auto Mode');
		$(".input-manual").removeClass('hilang');
		$(".input-scanner").addClass('hilang');
		$(".laser-area").addClass('hilang');
		$("#inputinsno").focus();
		$("#scanned-QR").html('');
	}
});
$("#scanner").click(function(){
	if($("#play").hasClass('disabled')){
		$("#play").removeClass('disabled');
		$("#stop").removeClass('disabled');
		$("#manual").removeClass('disabled');
		$(this).html('Scan Mode');
		$(".input-manual").addClass('hilang');
		$(".input-scanner").addClass('hilang');
		$(".laser-area").removeClass('hilang');
		$("#scanned-QR").html('');
	}else{
		$("#stop").click();
		$("#play").addClass('disabled');
		$("#stop").addClass('disabled');
		$("#manual").addClass('disabled');
		$(this).html('Normal Mode');
		$(".input-manual").addClass('hilang');
		$(".input-scanner").removeClass('hilang');
		$(".laser-area").addClass('hilang');
		$("#inputscanner").focus();
		$("#scanned-QR").html('');
	}
});
$("#bersihkan-input-manual").click(function(){
	$("#inputinsno").val('');
	$("#inputlot").val('');
	$("#inputjalur").val('');
	$("#inputscanner").val('');
	$("#inputinsno").focus();
});
$("#bersihkan-input-scanner").click(function(){
	$("#inputscanner").val('');
	$("#inputlot").val('');
	$("#inputjalur").val('');
	$("#inputinsno").val('');
	$("#inputscanner").focus();
});
$("#simpan-input-manual").click(function(){
	if($("#inputinsno").val()==''){
		alert('Instruksi harus di isi !');
		return false;
	}
	if($("#inputlot").val()==''){
		alert('Lot Instruksi harus di isi !');
		return false;
	}
	if($("#inputjalur").val()==''){
		alert('Jalur Jaring harus di isi !');
		return false;
	}
	var isi = $("#inputinsno").val().toUpperCase().trim()+'-'+$("#inputlot").val().trim()+'-'+$("#inputjalur").val().trim();
	insertdatainstruksi(isi);
})
$("#simpan-input-scanner").click(function(){
	if($("#inputscanner").val()==''){
		alert('Instruksi haus di isi !');
		return false;
	}

	var isi = $("#inputscanner").val().toUpperCase().trim();
	insertdatainstruksi(isi);
})
$("#inputscanner").blur(function(){
	if($("#inputscanner").val()==''){
		// alert('Instruksi haus di isi !');
		return false;
	}

	var isi = $("#inputscanner").val().toUpperCase().trim();
	insertdatainstruksi(isi);
	$("#inputscanner").val('');
	$("#inputscanner").focus();
})