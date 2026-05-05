$(document).ready(function () {
	// alert('XXX');
	if($("#id").val()==$("#maxid").val()){
		$("#nextrec").addClass('disabled');
		$("#lastrec").addClass('disabled');
	}
	if($("#id").val()==$("#minid").val()){
		$("#firstrec").addClass('disabled');
		$("#prevrec").addClass('disabled');
	}
	loadnetting();
	loadsenshoku();
	loadgaichu();
	loadfin();
	loadfingoods();
	loadship();
});
$("#cekitem").on('click',function(){
	// pesan('Dalam tahap Pembuatan','info');
	// var xx = $(this).attr('rel');
	// alert(xx);
})
$("#firstrec").on('click',function(){
	$.ajax({
		type: "POST",
		url: base_url + "ponet/currentrec",
		data: {
			id: $("#minid").val(),
		},
		success: function (data) {
			window.location.href = base_url+'ponet/view/'+data;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#prevrec").on('click',function(){
	$.ajax({
		type: "POST",
		url: base_url + "ponet/prevrec",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			window.location.href = base_url+'ponet/view/'+data;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#nextrec").on('click',function(){
	$.ajax({
		type: "POST",
		url: base_url + "ponet/nextrec",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			window.location.href = base_url+'ponet/view/'+data;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#lastrec").on('click',function(){
	$.ajax({
		type: "POST",
		url: base_url + "ponet/currentrec",
		data: {
			id: $("#maxid").val(),
		},
		success: function (data) {
			window.location.href = base_url+'ponet/view/'+data;
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
function loadnetting(){
	// alert('Isi data NETTING !');
	var isi = 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ponet/loadnetting",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			if(data.jml!=0){
				// alert(data.data);
				// $("#prod-netting").html(data.datagroup).show();
				$("#prod-netting .load-netting").addClass('hilang');
				$("#sum-prod-netting").removeClass('hilang');
				if(data.rowsatu!=''){
					$("#kolom-prod-netting-1").removeClass('hilang');
					$("#detail-prod-netting-1").html(data.rowsatu).show();
				}
				if(data.rowdua!=''){
					$("#kolom-prod-netting-2").removeClass('hilang');
					$("#detail-prod-netting-2").html(data.rowdua).show();
				}
				if(data.rowtiga!=''){
					$("#kolom-prod-netting-3").removeClass('hilang');
					$("#detail-prod-netting-3").html(data.rowtiga).show();
				}
				if(data.rowempat!=''){
					$("#kolom-prod-netting-4").removeClass('hilang');
					$("#detail-prod-netting-4").html(data.rowempat).show();
				}
				if(data.rowtotal!=''){
					$("#sum-prod-netting").removeClass('hilang');
					$("#detail-sum-prod-netting").html(data.rowtotal).show();
				}
			}else{
				$("#prod-netting .load-netting").html('<div style="min-height:35px;"><span class="text-danger">Data Tidak ditemukan !</span></div>');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loadsenshoku(){
	// alert('Isi data NETTING !');
	var isi = 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ponet/loadsenshoku",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			if(data.jml!=0){
				// alert(data.data);
				// $("#prod-netting").html(data.datagroup).show();
				$("#prod-senshoku .load-senshoku").addClass('hilang');
				$("#sum-prod-senshoku").removeClass('hilang');
				if(data.rowsatu!=''){
					$("#kolom-prod-senshoku-1").removeClass('hilang');
					$("#detail-prod-senshoku-1").html(data.rowsatu).show();
				}
				if(data.rowdua!=''){
					$("#kolom-prod-senshoku-2").removeClass('hilang');
					$("#detail-prod-senshoku-2").html(data.rowdua).show();
				}
				if(data.rowtiga!=''){
					$("#kolom-prod-senshoku-3").removeClass('hilang');
					$("#detail-prod-senshoku-3").html(data.rowtiga).show();
				}
				if(data.rowempat!=''){
					$("#kolom-prod-senshoku-4").removeClass('hilang');
					$("#detail-prod-senshoku-4").html(data.rowempat).show();
				}
				if(data.rowtotal!=''){
					$("#sum-prod-senshoku").removeClass('hilang');
					$("#detail-sum-prod-senshoku").html(data.rowtotal).show();
				}
			}else{
				$("#prod-senshoku .load-senshoku").html('<div style="min-height:35px;"><span class="text-danger">Data Tidak ditemukan !</span></div>');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loadgaichu(){
	// alert('Isi data NETTING !');
	var isi = 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ponet/loadgaichu",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			if(data.jml!=0){
				// alert(data.data);
				// $("#prod-netting").html(data.datagroup).show();
				$("#prod-gaichu .load-gaichu").addClass('hilang');
				$("#sum-prod-gaichu").removeClass('hilang');
				if(data.rowsatu!=''){
					$("#kolom-prod-gaichu-1").removeClass('hilang');
					$("#detail-prod-gaichu-1").html(data.rowsatu).show();
				}
				if(data.rowdua!=''){
					$("#kolom-prod-gaichu-2").removeClass('hilang');
					$("#detail-prod-gaichu-2").html(data.rowdua).show();
				}
				if(data.rowtiga!=''){
					$("#kolom-prod-gaichu-3").removeClass('hilang');
					$("#detail-prod-gaichu-3").html(data.rowtiga).show();
				}
				if(data.rowempat!=''){
					$("#kolom-prod-gaichu-4").removeClass('hilang');
					$("#detail-prod-gaichu-4").html(data.rowempat).show();
				}
				if(data.rowtotal!=''){
					$("#sum-prod-gaichu").removeClass('hilang');
					$("#detail-sum-prod-gaichu").html(data.rowtotal).show();
				}
			}else{
				$("#prod-gaichu .load-gaichu").html('<div style="min-height:35px;"><span class="text-danger">Data Tidak ditemukan !</span></div>');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loadfin(){
	// alert('Isi data NETTING !');
	var isi = 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ponet/loadfinishing",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			if(data.jml!=0){
				// alert(data.data);
				// $("#prod-netting").html(data.datagroup).show();
				$("#prod-finishing .load-finishing").addClass('hilang');
				$("#sum-prod-finishing").removeClass('hilang');
				if(data.rowsatu!=''){
					$("#kolom-prod-finishing-1").removeClass('hilang');
					$("#detail-prod-finishing-1").html(data.rowsatu).show();
				}
				if(data.rowdua!=''){
					$("#kolom-prod-finishing-2").removeClass('hilang');
					$("#detail-prod-finishing-2").html(data.rowdua).show();
				}
				if(data.rowtiga!=''){
					$("#kolom-prod-finishing-3").removeClass('hilang');
					$("#detail-prod-finishing-3").html(data.rowtiga).show();
				}
				if(data.rowempat!=''){
					$("#kolom-prod-finishing-4").removeClass('hilang');
					$("#detail-prod-finishing-4").html(data.rowempat).show();
				}
				if(data.rowtotal!=''){
					$("#sum-prod-finishing").removeClass('hilang');
					$("#detail-sum-prod-finishing").html(data.rowtotal).show();
				}
			}else{
				$("#prod-finishing .load-finishing").html('<div style="min-height:35px;"><span class="text-danger">Data Tidak ditemukan !</span></div>');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loadfingoods(){
	// alert('Isi data NETTING !');
	var isi = 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ponet/loadfingoods",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			if(data.jml!=0){
				// alert(data.data);
				// $("#prod-netting").html(data.datagroup).show();
				$("#prod-fingoods .load-fingoods").addClass('hilang');
				$("#sum-prod-fingoods").removeClass('hilang');
				if(data.rowsatu!=''){
					$("#kolom-prod-fingoods-1").removeClass('hilang');
					$("#detail-prod-fingoods-1").html(data.rowsatu).show();
				}
				if(data.rowdua!=''){
					$("#kolom-prod-fingoods-2").removeClass('hilang');
					$("#detail-prod-fingoods-2").html(data.rowdua).show();
				}
				if(data.rowtiga!=''){
					$("#kolom-prod-fingoods-3").removeClass('hilang');
					$("#detail-prod-fingoods-3").html(data.rowtiga).show();
				}
				if(data.rowempat!=''){
					$("#kolom-prod-fingoods-4").removeClass('hilang');
					$("#detail-prod-fingoods-4").html(data.rowempat).show();
				}
				if(data.rowtotal!=''){
					$("#sum-prod-fingoods").removeClass('hilang');
					$("#detail-sum-prod-fingoods").html(data.rowtotal).show();
				}
			}else{
				$("#prod-fingoods .load-fingoods").html('<div style="min-height:35px;"><span class="text-danger">Data Tidak ditemukan !</span></div>');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function loadship(){
	// alert('Isi data NETTING !');
	var isi = 0;
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "ponet/loadship",
		data: {
			id: $("#id").val(),
		},
		success: function (data) {
			if(data.jml!=0){
				// alert(data.data);
				// $("#prod-netting").html(data.datagroup).show();
				$("#prod-shipped .load-shipped").addClass('hilang');
				$("#sum-prod-shipped").removeClass('hilang');

				$("#detail-sum-prod-shipped").html(data.datagroup).show();
			}else{
				$("#prod-shipped .load-shipped").html('<div style="min-height:35px;"><span class="text-danger">Data Tidak ditemukan !</span></div>');
			}
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}