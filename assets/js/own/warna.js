var table = null;
$(document).ready(function () {
	setTimeout(() => {
		getcolor($("#cekrek").html());
	}, 200);
});
// $(window).on('load',function(){
// 	setTimeout(() => {
// 		alert($("#cekrek").html());
// 	}, 200);
// })

$(document).on('click','#trwarna',function(){
	var x = $(this).attr('rel');
	getcolor(x);
})

$("#perpagewarna").change(function(){
	addsession();
});
$("#btncari").click(function(){
	addsession();
});
$('#pencarianwarna').on('keypress', function(e) {
    if (e.which == 13) {
		addsession();
    }
});

function getcolor(idx){
	$.ajax({
		dataType: 'json',
		url: base_url + "warna/getcolor", // Ubah ke URL controller yang tepat
		type: "POST",
		data: { 
			id: idx ,
		},
		success: function (response) {
			$("#body-table-warna").html(response.datagroup).show();
			$("#datawarna h1").html('Color : '+response.warna);
			$("#body-table-dyestuff").html(response.obat).show();
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: ", status, error);
		},
	});
}

function addsession(){
	$.ajax({
		url: base_url + "warna/addsession", // Ubah ke URL controller yang tepat
		type: "POST",
		data: { 
			perpage: $("#perpagewarna").val() ,
			cari: $("#pencarianwarna").val()
		},
		success: function (response) {
			window.location.href = base_url+'warna';
		},
		error: function (xhr, status, error) {
			console.error("AJAX Error: ", status, error);
		},
	});
}