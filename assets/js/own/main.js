$(document).ready(function () {
	const deptallow = ["IT", "BC", "AR", "PP"];
	if(deptallow.includes($("#bagian").val()) && $("#jumlahdokbc").val() != '0'){
		setTimeout(() => {
			$("#getnotifikasi").off().click();
		}, 1000);
	}
});

$("#settglmonitoring").click(function(){
    $.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "main/settglmonitoring",
		data: {
			tglawal : $("#tglmonbcawal").val(),
			tglakhir : $("#tglmonbcakhir").val()
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