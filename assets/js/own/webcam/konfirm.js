$(document).ready(function(){
    // $("#play").click();
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
            if(data.datagroup.length == 1){
                alert('Data ada satu');
                isiketemp(data.datagroup[0])
            }else{
                if(data.datagroup.length > 1){
                    alert('Data lebih dari 1');
                }
            }
            // if(data.length > 0){
            //     $.ajax({
            //         dataType: 'json',
            //         type : "POST",
            //         url : "konfirm/kembali",
            //         data : {},
            //         success : function(data){
            //             if(data==1){
            //                 document.getElementById('kebase').click();
            //             }
            //         }
            //     })
            // }
        }
    })
}
function isiketemp(po,jm=1){
    alert(po);
    if(jm==1){

    }
}