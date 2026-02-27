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
	$("#butgo").click();
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