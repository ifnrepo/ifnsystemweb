$(document).ready(function () {});
$("#tambahpersonil").click(function () {
	if ($("#sidikjari_personil").val() == "") {
		pesan("Sidik Jari tidak boleh kosong !", "error");
		return;
	}
	if ($("#nama_personil").val() == "") {
		pesan("Nama tidak boleh kosong !", "error");
		return;
	}
	if ($("#nip").val() == "") {
		pesan("NIP Personil tidak boleh kosong !", "error");
		return;
	}
	if ($("#bagian_id").val() == "") {
		pesan("Bagian tidak boleh kosong !", "error");
		return;
	}
	if ($("#id_pendidikan").val() == "") {
		pesan("pendidikan tidak boleh kosong !", "error");
		return;
	}
	if ($("#id_agama").val() == "") {
		pesan("Agama tidak boleh kosong !", "error");
		return;
	}
	if ($("#jenis_kelamin").val() == "") {
		pesan("Jenis Kelamin tidak boleh kosong !", "error");
		return;
	}
	if ($("#keterangan").val() == "") {
		pesan("Keterangan Kelamin tidak boleh kosong !", "error");
		return;
	}
	if ($("#status_aktif").val() == "") {
		pesan("Status aktif tidak boleh kosong !", "error");
		return;
	}
	if ($("#id_status").val() == "") {
		pesan("Status  tidak boleh kosong !", "error");
		return;
	}
	if ($("#tlp").val() == "") {
		pesan("Telephone  tidak boleh kosong !", "error");
		return;
	}
	if ($("#tgl_masuk").val() == "") {
		pesan("Tanggal Masuk tidak boleh kosong !", "error");
		return;
	}
	if ($("#tempat_lahir").val() == "") {
		pesan("Tempat Lahir tidak boleh kosong !", "error");
		return;
	}
	if ($("#tgl_lahir").val() == "") {
		pesan("Tanggal Lahir tidak boleh kosong !", "error");
		return;
	}
	if ($("#rt").val() == "") {
		pesan("RT tidak boleh kosong !", "error");
		return;
	}
	if ($("#rw").val() == "") {
		pesan("RW tidak boleh kosong !", "error");
		return;
	}
	if ($("#desa").val() == "") {
		pesan("Desa tidak boleh kosong !", "error");
		return;
	}
	if ($("#kabupaten").val() == "") {
		pesan("Kabupaten tidak boleh kosong !", "error");
		return;
	}


	if ($("#no_jamsostek").val() == "") {
		pesan("Jamsostek tidak boleh kosong !", "error");
		return;
	}
	if ($("#no_bpjs").val() == "") {
		pesan("BPJS tidak boleh kosong !", "error");
		return;
	}
	if ($("#no_npwp").val() == "") {
		pesan("NPWP tidak boleh kosong !", "error");
		return;
	}
	if ($("#no_ktp").val() == "") {
		pesan("KTP tidak boleh kosong !", "error");
		return;
	}
	if ($("#norekening_bank").val() == "") {
		pesan("Rek Bank tidak boleh kosong !", "error");
		return;
	}
	if ($("#atas_nama").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#namabank").val() == "") {
		pesan("tidak boleh kosong !", "error");
		return;
	}
	if ($("#cabang").val() == "") {
		pesan("tidak boleh kosong !", "error");
		return;
	}
	if ($("#no_e-fin").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#email").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#jabatan_id").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#status_karyawan").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#jamkerja_normal").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#subpekerjaan").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#grup_id").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#penilai_kerja").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	if ($("#jabatan_penilai").val() == "") {
		pesan(" tidak boleh kosong !", "error");
		return;
	}
	document.formtambahpersonil.submit();
});



// $("#editpersonil").click(function () {
// 	if ($("#foto_personil").val() == "" && $("#foto_personil").val() == "") {
//         pesan("Foto tidak boleh kosong !", "error");
//         return;
//     }
// 	if ($("#nama_personil").val() == "") {
// 		pesan("Nama tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#nip").val() == "") {
// 		pesan("NIP Personil tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#bagian").val() == "") {
// 		pesan("Bagian tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#status_aktif").val() == "") {
// 		pesan("Status aktif tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#tgl_masuk").val() == "") {
// 		pesan("Tanggal Masuk tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#tempat_lahir").val() == "") {
// 		pesan("Tempat Lahir tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#tgl_lahir").val() == "") {
// 		pesan("Tanggal Lahir tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#rt").val() == "") {
// 		pesan("RT tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#rw").val() == "") {
// 		pesan("RW tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#desa").val() == "") {
// 		pesan("Desa tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#kabupaten").val() == "") {
// 		pesan("Kabupaten tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#pendidikan").val() == "") {
// 		pesan("pendidikan tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#status").val() == "") {
// 		pesan("Status tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#tlp").val() == "") {
// 		pesan("Tlp tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#agama").val() == "") {
// 		pesan("Agama tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#jenis_kelamin").val() == "") {
// 		pesan("Jenis Kelamin tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#keterangan").val() == "") {
// 		pesan("Keterangan tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#no_jamsostek").val() == "") {
// 		pesan("Jamsostek tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#no_bpjs").val() == "") {
// 		pesan("BPJS tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#no_npwp").val() == "") {
// 		pesan("NPWP tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#no_ktp").val() == "") {
// 		pesan("KTP tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#norekening_bank").val() == "") {
// 		pesan("Rek Bank tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#atas_nama").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#namabank").val() == "") {
// 		pesan("tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#cabang").val() == "") {
// 		pesan("tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#no_e-fin").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#email").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#jabatan").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#status_karyawan").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#jamkerja_normal").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#subpekerjaan").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#grup").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#penilai_kerja").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	if ($("#jabatan_penilai").val() == "") {
// 		pesan(" tidak boleh kosong !", "error");
// 		return;
// 	}
// 	document.formtambahpersonil.submit();
// });

$("#simpandata").click(function () {
	document.formkolom.submit();
});

var loadFile = function(event) {
    var output = document.getElementById("gbimage");
    var isifile = event.target.files[0];

    if (!isifile) {
        output.src = "<?= base_url($path . 'image.jpg'); ?>";  
        $("#okesubmit").addClass("disabled");
    } else {
        output.src = URL.createObjectURL(isifile);
        output.onload = function() {
            URL.revokeObjectURL(output.src); 
        };
        $("#okesubmit").removeClass("disabled");  
    }
};


    $("#filter").change(function () {
        $.ajax({
            url: base_url + "personil/filter", // Ubah ke URL controller yang tepat
            type: "POST",
            data: { filter: $(this).val() },
            success: function (response) {
                $("#table-default").html(response); // Ganti konten di dalam #table-default
            },
            error: function (xhr, status, error) {
                console.error("AJAX Error: ", status, error);
            }
        });
    });




  




