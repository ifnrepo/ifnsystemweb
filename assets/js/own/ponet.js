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