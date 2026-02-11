$(document).ready(function(){
    $("#play").click();
})

function insertdataizin(x){
    // const isi = ["IE","IP"];
    // if(isi.includes(x)){
        var jn = x.substr(0,2);
        var nom = x.substr(2,11);
        $.ajax({
            dataType: 'json',
            type : "POST",
            url : "subkok/cekdata",
            data : {jenis : jn,id : nom},
            success : function(data){
                if(data.length > 0){
                    $.ajax({
                        dataType: 'json',
                        type : "POST",
                        url : "konfirm/kembali",
                        data : {},
                        success : function(data){
                            if(data==1){
                                document.getElementById('kebase').click();
                            }
                        }
                    })
                }
            }
        })
    // }else{
    //     swal('Error','Cek Nilai Qrcode','danger');
    // }
}