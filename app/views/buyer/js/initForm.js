$(document).ready(function(){
	setSelect_status();

	$("#tambah_buyer").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$("#labelModalBuyer").text("Form Tambah Data Buyer");
    	$("#btnSubmit_buyer").prop("value", "tambah");
    	$("#btnSubmit_buyer").text("Tambah");
    	$("#modal_buyer").modal();
    });

    $("#form_buyer").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// npwp
    	$("#npwp").change(function(){
    		if(this.value !== ""){
    			$('.field-npwp').removeClass('has-error').addClass('has-success');
				$(".field-npwp span.help-block").text('');
    		}
    	});

    	// nama
    	$("#nama").change(function(){
    		if(this.value !== ""){
    			$('.field-nama').removeClass('has-error').addClass('has-success');
				$(".field-nama span.help-block").text('');
    		}
    	});

    	// alamat
    	$("#alamat").change(function(){
    		if(this.value !== ""){
    			$('.field-alamat').removeClass('has-error').addClass('has-success');
				$(".field-alamat span.help-block").text('');
    		}
    	});

    	// telp
    	$("#telp").change(function(){
    		if(this.value !== ""){
    			$('.field-telp').removeClass('has-error').addClass('has-success');
				$(".field-telp span.help-block").text('');
    		}
    	});

    	// email
    	$("#email").change(function(){
    		if(this.value !== ""){
    			$('.field-email').removeClass('has-error').addClass('has-success');
				$(".field-email span.help-block").text('');
    		}
    	});

    	// foto
    	$("#foto").change(function(){
    		if(this.value !== ""){
    			$('.field-foto').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-foto span.help-block").text('');	
    		}
    	});

    	// status
    	$("#status").change(function(){
    		// jika tidak diisi
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');
    		}
    	});
    // ======================================= //

});

// function get data form
function getDataForm(){
	var data = new FormData();
	
	data.append('id_buyer', $("#id_buyer").val().trim()); // id
	data.append('npwp', $("#npwp").val().trim()); // npwp
	data.append('nama', $("#nama").val().trim()); // nama
	data.append('alamat', $("#alamat").val().trim()); // alamat
	data.append('telp', $("#telp").val().trim()); // telp
	data.append('email', $("#email").val().trim()); // alamat
	data.append('foto', $("#foto")[0].files[0]); // foto
	data.append('status', $("#status").val().trim()); // status
	data.append('action', $("#btnSubmit_buyer").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Buyer.php',
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
				setValue(output.setValue);
				if(output.errorDB){ // jika db error
					setLoading();
					swal("Pesan Error", "Koneksi Database Error, Silahkan Coba Lagi", "error");
					$("#modal_buyer").modal('hide');
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
			}
			else{
				resetForm();
				$("#modal_buyer").modal('hide');
				var toastText = ($("#btnSubmit_buyer").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				$("#tabel_buyer").DataTable().ajax.reload();
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_buyer").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get edit
function getEdit(id){
	resetForm();
	$(".field-foto").css("display", "none");
	$("#labelModalBuyer").text("Form Edit Data Buyer");
	$("#btnSubmit_buyer").prop("value", "edit");
	$("#btnSubmit_buyer").text("Edit");

	$.ajax({
		url: base_url+'app/controllers/Buyer.php',
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
				$("#modal_buyer").modal();
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
			}	
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_buyer").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set error
function setError(error){
	// npwp
	if(!jQuery.isEmptyObject(error.npwpError)){
		$('.field-npwp').removeClass('has-success').addClass('has-error');
		$(".field-npwp span.help-block").text(error.npwpError);
	}
	else{
		$('.field-npwp').removeClass('has-error').addClass('has-success');
		$(".field-npwp span.help-block").text('');
	}

	// nama
	if(!jQuery.isEmptyObject(error.namaError)){
		$('.field-nama').removeClass('has-success').addClass('has-error');
		$(".field-nama span.help-block").text(error.namaError);
	}
	else{
		$('.field-nama').removeClass('has-error').addClass('has-success');
		$(".field-nama span.help-block").text('');
	}

	// telp
	if(!jQuery.isEmptyObject(error.telpError)){
		$('.field-telp').removeClass('has-success').addClass('has-error');
		$(".field-telp span.help-block").text(error.telpError);
	}
	else{
		$('.field-telp').removeClass('has-error').addClass('has-success');
		$(".field-telp span.help-block").text('');
	}

	// alamat
	if(!jQuery.isEmptyObject(error.alamatError)){
		$('.field-alamat').removeClass('has-success').addClass('has-error');
		$(".field-alamat span.help-block").text(error.alamatError);
	}
	else{
		$('.field-alamat').removeClass('has-error').addClass('has-success');
		$(".field-alamat span.help-block").text('');
	}

	// email
	if(!jQuery.isEmptyObject(error.emailError)){
		$('.field-email').removeClass('has-success').addClass('has-error');
		$(".field-email span.help-block").text(error.emailError);
	}
	else{
		$('.field-email').removeClass('has-error').addClass('has-success');
		$(".field-email span.help-block").text('');
	}

	// foto
	if(!jQuery.isEmptyObject(error.fotoError)){
		$('.field-foto').removeClass('has-success').addClass('has-error');
		$(".field-foto span.help-block").text(error.fotoError);
	}
	else{
		$('.field-foto').removeClass('has-error').addClass('has-success');
		$(".field-foto span.help-block").text('');	
	}

	// status
	if(!jQuery.isEmptyObject(error.statusError)){
		$('.field-status').removeClass('has-success').addClass('has-error');
		$(".field-status span.help-block").text(error.statusError);
	}
	else{
		$('.field-status').removeClass('has-error').addClass('has-success');
		$(".field-status span.help-block").text('');
	}

}

// function set value
function setValue(value){
	$('#npwp').val(value.npwp).trigger('change'); // npwp
	$('#nama').val(value.nama).trigger('change'); // nama
	$('#telp').val(value.telp).trigger('change'); // telp
	$('#alamat').val(value.alamat).trigger('change'); // alamat
	$('#email').val(value.email).trigger('change'); // email
	$('#status').val(value.status).trigger('change'); // status
	$('#id_buyer').val(value.id);
}

// function reset form
function resetForm(){
	$('#form_buyer').trigger('reset');
	$('#form_buyer').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_buyer').find("span.pesan").text(""); // hapus semua span help-block
	$('#id_buyer').val("");
}

function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status Buyer --"},
		{value: "1", text: "AKTIF"},
		{value: "0", text: "NON-AKTIF"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#status").append(option);
	});

	$("#status").prop('disabled', true);
	$('#status option[value=1]').attr('selected','selected');
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
