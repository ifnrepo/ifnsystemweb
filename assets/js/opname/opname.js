$(document).ready(function(){
    // alert('XXXX');
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
			// $("#dept_tuju").html(data);
			// $("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})