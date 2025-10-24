$(document).ready(function () {

});

$("#settglmonitoring").click(function(){
    // alert('Ada');
    // var chart = $("#chart-dokbcmasuk");
    // chart.updateOptions({
    //     title: {
    //         text: 'New Chart Title'
    //     },
    //     colors: ['#FF0000', '#00FF00']
    // });
    // chart.render();
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