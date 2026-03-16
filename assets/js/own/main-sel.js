$(document).ready(function () {
	// alert('XXX');
});
$("#sel-kirimgf").on('change',function(){
	// alert($(this).val());
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "main/getdatapengirimangf",
		data: {
			kode: $(this).val()
		},
		success: function (xdata) {
			// window.location.reload();
			chartkirim.updateSeries([{
				data: xdata // New data
			}])
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})
$("#sel-loss-date").on('change',function(){
	// alert($(this).val());
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "main/getdatapengirimanloss",
		data: {
			kode: $(this).val()
		},
		success: function (xdata) {
			// window.location.reload();
			chartloss.updateOptions({
				series: xdata['data'],
				labels: xdata['label'] // New data
			});
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
})