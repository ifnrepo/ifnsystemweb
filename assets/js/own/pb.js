var table;
$(document).ready(function () {
	$(".datatabledengandiv").DataTable({
		dom: "<'extra'>frtip",
	});
	$("div.extra").html($("#sisipkan").html()).insertAfter(".dataTables_filter");
	$(".dataTables_filter").css("float", "right");
});
$("#dept_kirim").change(function () {
	alert("XXX");
	// alert($(this).attr("rel"));
});
