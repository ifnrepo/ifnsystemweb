$(document).ready(function(){
    // $(".loadered").removeClass('hilang');
	// alert('xxxx');
})

$("#updateopname").click(function(){
	$(this).html('Loading..')
	$(".loadered").removeClass('hilang');
	var isi = $("#textcarirekapopname").val().trim();
    $.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "opname/getdatareg",
		data: {
			dept: $("#currdeptreg").val(),
			milik: $("#kepemilikanreg").val(),
			exdo: $("#exdoreg").val(),
			cari: isi,
			perpage: $("#rekapopname-perpage").val()
		},
		success: function (data) {
			// window.location.reload();
			window.location.href = base_url + 'opname/regbarang';
			// $("#dept_tuju").html(data);
			// $("#dept_tuju").change();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
	// window.location.reload();
})
$("#kepemilikan").change(function(){
	$("#updateopname").click();
})
$("#exdo").change(function(){
	$("#updateopname").click();
})
$("#buttoncarirekapopname").click(function(){
	$("#updateopname").click();
})
$("#buttonresetrekapopname").click(function(){
	$("#textcarirekapopname").val('');
	$("#updateopname").click();
})
$('#textcarirekapopname').on('keypress', function(e) {
    if (e.which === 13) {
		$("#buttoncarirekapopname").click();
    }
});
$("#rekapopname-perpage").change(function(){
	$("#updateopname").click();
})
function gantislash(stri){
	let cek = stri.trim();
	let jadi = cek.replaceAll("/", "+");
	let hasilx = jadi.replaceAll("-", "?");
	let hasil = hasilx.replaceAll(" ", "%20");
	return hasil;
}