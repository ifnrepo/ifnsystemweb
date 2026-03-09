$(document).ready(function(){
    // $("#play").click();
    var url = window.location.href;
	var pisah = url.split("/");
	// alert(pisah[5]);
	if (pisah[2] == "localhost") {
		if (pisah[5] == "scandata") {
			getdatatemp();
            // alert('ada');

		}
	} else {
		if (pisah[5] == "scandata") {
			// getdatadetailib();
            // alert('ada');
            getdatatemp();
		}
	}
})

$("#contoh").blur(function(){
    var isi = $(this).val();
    insertdatainstruksi(isi);
})

function insertdatainstruksi(x){
    var masuk = x.split("-");
    if(x==''){
        alert('DATA KOSONG !');
        return false;
    }
    let insnoe = masuk[0];
    let lote = masuk[1];
    let jlre = masuk[2];
    if(insnoe===undefined || insnoe.trim()==''){
        alert('DATA ANEH, PERIKSA DATA INSNO !');
        return false;
    }
    if(lote===undefined || lote.trim()==''){
        alert('DATA ANEH, PERIKSA DATA LOT !');
        return false;
    }
    if(jlre===undefined || jlre.trim()==''){
        alert('DATA ANEH, PERIKSA DATA JALUR !');
        return false;
    }
    $.ajax({
        dataType: 'json',
        type : "POST",
        url : base_url + "sublok/inimasukdata",
        data : {insno : insnoe,lot: lote, jlr: jlre},
        success : function(data){
            if(data.datapo.length == 1){
                // alert('Data ada satu');
                $("#jalurnya").val(jlre);
                $("#lotnya").val(lote);
                $("#insnonya").val(insnoe);
                isiketemp(data.datapo[0]['po']+data.datapo[0]['item']+data.datapo[0]['dis']);
            }else{
                if(data.datapo.length > 1){
                    // alert('Data lebih dari 1');
                    // for(let lp=0; lp < data.datapo.length; lp++){
                        // isiketemp(data.datapo[lp]['po']);
                        let kode = insnoe.replaceAll('-','@');
                        let xkode = kode.replaceAll(' ','-');
                        $("#jalurnya").val(jlre);
                        $("#lotnya").val(lote);
                        $("#insnonya").val(insnoe);
                        $("#pilihpoadadua").attr('href',base_url+'sublok/pilihpo/'+xkode);
                        document.getElementById('pilihpoadadua').click();
                    // }
                }else{
                    alert('DATA INSTRUKSI TIDAK DITEMUKAN !');
                    return false;
                }
            }
        }
    })
}
function isiketemp(po){
    $.ajax({
        dataType: 'json',
        type : "POST",
        url : base_url+"sublok/tambahketemp",
        data : {
            id: $("#idreal").val(),
            lot: $("#lotnya").val(),
            jlr: $("#jalurnya").val(),
            ins: $("#insnonya").val(),
            ind: po
        },
        success : function(data){
            getdatatemp();
            if($("#input-manual").hasClass('hilang')){
                $("#play").click();
            }
            // $("#keluar").click();
            // if(data==1){
            //     document.getElementById('kebase').click();
            // }
        }
    })
}
function getdatatemp() {
	$.ajax({
		dataType: "json",
		type: "POST",
		url: base_url + "sublok/getdatatemp",
		data: {
			id_header: $("#idreal").val(),
		},
		success: function (data) {
			// alert(data.jmlrek);
			// window.location.reload();
			// $("#jmlrek").val(data.jmlrek);
			$("#body-table").html(data.datagroup).show();
            kosongkanform();
			// $("#totalharga").val(rupiah(data.totalharga, ".", ",", 2));
			// if (data.jmlrek > 0) {
			// 	$("#jn_ib").attr("disabled", true);
			// 	$("#pilihsup").addClass("disabled");
			// }
			// hitunggrandtotal();
		},
		error: function (xhr, ajaxOptions, thrownError) {
			console.log(xhr.status);
			console.log(thrownError);
		},
	});
}
function kosongkanform(){
    $("#jalurnya").val('');
    $("#lotnya").val('');
    $("#insnonya").val('');
    $("#inputinsno").val('');
    $("#inputlot").val('');
    $("#inputjalur").val('');
}