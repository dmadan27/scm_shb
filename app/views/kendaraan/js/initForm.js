$(document).ready(function(){
	// setSelect_jenis();
	$('#tahun').datepicker({
        autoclose: true,
        format: "yyyy",
        viewMode: "years", 
    	minViewMode: "years",
        todayHighlight: true,
    });

    setSelect_supir();

    $("#tambah_kendaraan").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$(".field-foto").css("display", "block");
    	$(".field-foto a.fileinput-exists").trigger('click');
    	$("#labelModalKendaraan").text("Form Tambah Data Kendaraan");
    	$("#btnSubmit_kendaraan").prop("value", "tambah");
    	$("#btnSubmit_kendaraan").text("Tambah");
    	$("#modal_kendaraan").modal();
    });
});

function getView(id){

}

// function get form
function getDataForm(){
	var data = new FormData();

	data.append('id_kendaraan', $("#id_kendaraan").val().trim()); // id
	data.append('nopol', $("#nopol").val().trim()); // nik
	data.append('tahun', $("#tahun").val().trim()); // npwp
	data.append('jenis', $("#jenis").val().trim()); // nama
	data.append('muatan', $("#muatan").val().trim()); // telp
	data.append('foto', $("#foto")[0].files[0]); // foto
	data.append('status', $("#status").val().trim()); // status
	data.append('action', $("#btnSubmit_kendaraan").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Kendaraan.php',
		type: 'POST',
		dataType: 'json',
		data: data,
		contentType: false,
		cache: false,
		processData: false,
		beforeSend: function(){
			setLoading();
		},
		success: function(output){
			setLoading(false);
			console.log(output);
			if(!output.status){ // jika gagal
				resetForm();
				if(output.errorDB){ // jika db error
					setLoading();
					swal("Pesan Error", "Koneksi Database Error, Silahkan Coba Lagi", "error");
					$("#modal_karyawan").modal('hide');
				}
				else{
					$.toast({
						heading: 'Pesan Error',
						text: 'Harap Cek Kembali Form Isian!',
						position: 'top-right',
			            loaderBg: '#ff6849',
			            icon: 'error',
			            hideAfter: 3000,
			            stack: 6
					});
					setError(output.setError);
				}
				setValue(output.setValue);
			}
			else{
				resetForm();
				$(".field-foto a.fileinput-exists").trigger('click');
				$("#modal_kendaraan").modal('hide');
				var toastText = ($("#btnSubmit_kendaraan").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				$("#tabel_kendaraan").DataTable().ajax.reload();
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading();
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_kendaraan").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get edit
function getEdit(id){
	resetForm();
	$(".field-foto").css("display", "none");
	$("#labelModalKendaraan").text("Form Edit Data Kendaraan");
	$("#btnSubmit_kendaraan").prop("value", "edit");
	$("#btnSubmit_kendaraan").text("Edit");

	$.ajax({
		url: base_url+'app/controllers/Kendaraan.php',
		type: 'post',
		dataType: 'json',
		data: {"id": id, "action": "getEdit"},
		beforeSend: function(){
			setLoading();
		},
		success: function(data){
			if(data){
				console.log(data);
				setLoading(false);
				setValue(data);
				$("#modal_kendaraan").modal();
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading();
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_kendaraan").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set value
function setError(error){
}

// function set value
function setValue(value){
	
}

// function reset form
function resetForm(){
	
}

// function set select supir
function setSelect_supir(){

}

// function loading modal
function setLoading(block=true){
	if(block === true){
		$('.modal-content').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.modal-content').unblock();
}

