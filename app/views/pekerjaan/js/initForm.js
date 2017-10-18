$(document).ready(function(){

	$("#tambah_pekerjaan").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$("#labelModalPekerjaan").text("Form Tambah Data Pekerjaan");
    	$("#btnSubmit_pekerjaan").prop("value", "tambah");
    	$("#btnSubmit_pekerjaan").text("Tambah");
    	$("#modal_pekerjaan").modal();
    });

    $("#form_pekerjaan").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// jabatan/pekerjaan
    	$("#jabatan").change(function(){
    		if(this.value !== ""){
    			$('.field-jabatan').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-jabatan span.help-block").text('');	
    		}
    	});

    	// keterangan
    	$("#ket").change(function(){
    		if(this.value !== ""){
    			$('.field-ket').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-ket span.help-block").text('');	
    		}
    	});
    // ==================================

});

// function get form
function getDataForm(){
	var data = new FormData();
	
	data.append('id_pekerjaan', $("#id_pekerjaan").val().trim()); // id
	data.append('jabatan', $("#jabatan").val().trim()); // jabatan
	data.append('ket', $("#ket").val().trim()); // keterangan
	data.append('action', $("#btnSubmit_pekerjaan").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Pekerjaan.php',
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
					$("#modal_pekerjaan").modal('hide');
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
				$("#modal_pekerjaan").modal('hide');
				var toastText = ($("#btnSubmit_pekerjaan").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				$("#tabel_pekerjaan").DataTable().ajax.reload();
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading();
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_pekerjaan").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function reset form
function resetForm(){
	$('#form_pekerjaan').trigger('reset');
	$('#form_pekerjaan').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_pekerjaan').find("span.pesan").text(""); // hapus semua span help-block
	$('#id_pekerjaan').val("");
}

function getEdit(id){
	resetForm();
	$("#labelModalPekerjaan").text("Form Edit Data Pekerjaan");
	$("#btnSubmit_pekerjaan").prop("value", "edit");
	$("#btnSubmit_pekerjaan").text("Edit");

	$.ajax({
		url: base_url+'app/controllers/Pekerjaan.php',
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
				$("#modal_pekerjaan").modal();
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading();
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_pekerjaan").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function setError(error){
	if(!jQuery.isEmptyObject(error.jabatanError)){
		$('.field-jabatan').addClass('has-error');
		$(".field-jabatan span.help-block").text(error.jabatanError);
	}
	else{
		$('.field-jabatan').removeClass('has-error').addClass('has-success');
		$(".field-jabatan span.help-block").text('');	
	}

	if(!jQuery.isEmptyObject(error.ketError)){
		$('.field-keterangan').addClass('has-error');
		$(".field-keterangan span.help-block").text(error.ketError);
	}
	else{
		$('.field-keterangan').removeClass('has-error').addClass('has-success');
		$(".field-keterangan span.help-block").text('');	
	}
}

function setValue(value){
	$("#jabatan").val(value.jabatan);
	$("#ket").val(value.ket);
	$("#id_pekerjaan").val(value.id);
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