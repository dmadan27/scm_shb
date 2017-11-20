$(document).ready(function(){
	var cekEdit = false;

	// cek status form, tambah/edit
	if(!jQuery.isEmptyObject(urlParams.id)){ // jika ada parameter get
		// edit_barang(urlParams.id);
		cekEdit = true;
	}

	$("#jabatan").select2();

	setSelect_status();
	setSelect_jabatan();

	$('#tgl_lahir').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "bottom auto",
        todayBtn: true,
        todayHighlight: true,
    });

    $('#tgl_masuk').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        orientation: "bottom auto",
        todayBtn: true,
        todayHighlight: true,
    });

    if(cekEdit) getEdit(urlParams.id);

    $("#form_karyawan").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// nik
    	$("#nik").change(function(){
    		if(this.value !== ""){
    			$('.field-nik').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-nik span.help-block").text('');	
    		}
    	});
    	// npwp
    	$("#npwp").change(function(){
    		if(this.value !== ""){
    			$('.field-npwp').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-npwp span.help-block").text('');	
    		}
    	});

    	// nama
    	$("#nama").change(function(){
    		if(this.value !== ""){
    			$('.field-nama').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-nama span.help-block").text('');	
    		}
    	});

    	// tempat lahir
    	$("#tempat_lahir").change(function(){
    		if(this.value !== ""){
    			$('.field-tempat-lahir').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-tempat-lahir span.help-block").text('');
    		}
    	});

    	// tgl lahir
    	$("#tgl_lahir").change(function(){
    		if(this.value !== ""){
    			$('.field-tgl-lahir').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-tgl-lahir span.help-block").text('');
    		}
    	});

    	// jenis kelamin
    	$('input[name=jk][type=radio]').change(function(){
			$(".field-jk span.help-block").text('');
		})

    	// alamat
    	$("#alamat").change(function(){
    		if(this.value !== ""){
    			$('.field-alamat').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-alamat span.help-block").text('');
    		}
    	});

    	// telp
    	$("#telp").change(function(){
    		if(this.value !== ""){
    			$('.field-telp').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-telp span.help-block").text('');	
    		}
    	});

    	// email
    	$("#email").change(function(){
    		if(this.value !== ""){
    			$('.field-email').removeClass('has-error').removeClass('has-error').addClass('has-success');
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

    	// no. induk
    	$("#no_induk").change(function(){
    		if(this.value !== ""){
    			$('.field-no-induk').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-no-induk span.help-block").text('');	
    		}
    	});

    	// tgl masuk
    	$("#tgl_masuk").change(function(){
    		if(this.value !== ""){
    			$('.field-tgl-masuk').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-tgl-masuk span.help-block").text('');	
    		}
    	});

    	// jabatan
    	$("#jabatan").change(function(){
    		if(this.value !== ""){
    			$('.field-jabatan').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-jabatan span.help-block").text('');
    		}
    	});

    	// status
    	$("#status").change(function(){
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');
    		}
    	});
    // ========================================= //
});


// function get form
function getDataForm(){
	var data = new FormData();
	var jk = ($('input[name=jk][type=radio]:checked').size() == 0) ? "" : $('input[name=jk][type=radio]:checked').val().trim();


	data.append('id_karyawan', $("#id_karyawan").val().trim()); // id
	data.append('nik', $("#nik").val().trim()); // nik
	data.append('npwp', $("#npwp").val().trim()); // npwp
	data.append('nama', $("#nama").val().trim()); // nama
	data.append('tempat_lahir', $("#tempat_lahir").val().trim()); // alamat
	data.append('tgl_lahir', $("#tgl_lahir").val().trim()); // alamat
	data.append('jk', jk); // alamat
	data.append('alamat', $("#alamat").val().trim()); // alamat
	data.append('telp', $("#telp").val().trim()); // telp
	data.append('email', $("#email").val().trim()); // telp
	data.append('foto', $("#foto")[0].files[0]); // foto
	data.append('no_induk', $("#no_induk").val().trim()); // no_induk
	data.append('tgl_masuk', $("#tgl_masuk").val().trim()); // tgl masuk
	data.append('id_pekerjaan', $("#jabatan").val().trim()); // jabatan
	data.append('status', $("#status").val().trim()); // status
	data.append('action', $("#btnSubmit_karyawan").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Karyawan.php',
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
				$("#modal_karyawan").modal('hide');
				var toastText = ($("#btnSubmit_karyawan").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				window.location.href = base_url+"index.php?m=karyawan&p=list";
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
			setLoading(false);
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get edit
function getEdit(id){
	resetForm();
	$(".field-foto").css("display", "none");
	$("#no_induk").prop("readonly", true);

	$.ajax({
		url: base_url+'app/controllers/Karyawan.php',
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
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
				window.location.href = base_url+"index.php?m=karyawan&p=list";
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
			setLoading(false);
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set error
function setError(error){
	// no induk
	if(!jQuery.isEmptyObject(error.no_indukError)){
		$('.field-no-induk').addClass('has-error');
		$(".field-no-induk span.help-block").text(error.no_indukError);
	}
	else{
		$('.field-no-induk').removeClass('has-error').addClass('has-success');
		$(".field-no-induk span.help-block").text('');
	}

	// nik
	if(!jQuery.isEmptyObject(error.nikError)){
		$('.field-nik').addClass('has-error');
		$(".field-nik span.help-block").text(error.nikError);
	}
	else{
		$('.field-nik').removeClass('has-error').addClass('has-success');
		$(".field-nik span.help-block").text('');
	}

	// npwp
	if(!jQuery.isEmptyObject(error.npwpError)){
		$('.field-npwp').addClass('has-error');
		$(".field-npwp span.help-block").text(error.npwpError);
	}
	else{
		$('.field-npwp').removeClass('has-error').addClass('has-success');
		$(".field-npwp span.help-block").text('');	
	}

	// nama
	if(!jQuery.isEmptyObject(error.namaError)){
		$('.field-nama').addClass('has-error');
		$(".field-nama span.help-block").text(error.namaError);
	}
	else{
		$('.field-nama').removeClass('has-error').addClass('has-success');
		$(".field-nama span.help-block").text('');
	}

	// tempat lahir
	if(!jQuery.isEmptyObject(error.tempat_lahirError)){
		$('.field-tempat-lahir').addClass('has-error');
		$(".field-tempat-lahir span.help-block").text(error.tempat_lahirError);
	}
	else{
		$('.field-alamat').removeClass('has-error').addClass('has-success');
		$(".field-alamat span.help-block").text('');
	}

	// tgl lahir
	if(!jQuery.isEmptyObject(error.tgl_lahirError)){
		$('.field-tgl-lahir').addClass('has-error');
		$(".field-tgl-lahir span.help-block").text(error.tgl_lahirError);
	}
	else{
		$('.field-alamat').removeClass('has-error').addClass('has-success');
		$(".field-alamat span.help-block").text('');
	}

	// telp
	if(!jQuery.isEmptyObject(error.telpError)){
		$('.field-telp').addClass('has-error');
		$(".field-telp span.help-block").text(error.telpError);
	}
	else{
		$('.field-telp').removeClass('has-error').addClass('has-success');
		$(".field-telp span.help-block").text('');
	}

	// email
	if(!jQuery.isEmptyObject(error.emailError)){
		$('.field-email').addClass('has-error');
		$(".field-email span.help-block").text(error.emailError);
	}
	else{
		$('.field-email').removeClass('has-error').addClass('has-success');
		$(".field-email span.help-block").text('');
	}

	// alamat
	if(!jQuery.isEmptyObject(error.alamatError)){
		$('.field-alamat').addClass('has-error');
		$(".field-alamat span.help-block").text(error.alamatError);
	}
	else{
		$('.field-alamat').removeClass('has-error').addClass('has-success');
		$(".field-alamat span.help-block").text('');
	}

	// foto
	if(!jQuery.isEmptyObject(error.fotoError)){
		$('.field-foto').addClass('has-error');
		$(".field-foto span.help-block").text(error.fotoError);
	}
	else{
		$('.field-foto').removeClass('has-error').addClass('has-success');
		$(".field-foto span.help-block").text('');
	}

	// jabatan
	if(!jQuery.isEmptyObject(error.id_pekerjaanError)){
		$('.field-jabatan').addClass('has-error');
		$(".field-jabatan span.help-block").text(error.id_pekerjaanError);
	}
	else{
		$('.field-jabatan').removeClass('has-error').addClass('has-success');
		$(".field-jabatan span.help-block").text('');
	}

	// status
	if(!jQuery.isEmptyObject(error.statusError)){
		$('.field-status').addClass('has-error');
		$(".field-status span.help-block").text(error.statusError);
	}
	else{
		$('.field-status').removeClass('has-error').addClass('has-success');
		$(".field-status span.help-block").text('');
	}
}

// function set value
function setValue(value){
	var jk = (value.jk=="") ? "" : $("input[name=jk][type=radio][value="+value.jk+"]").prop('checked', true); 
	jk;
	
	$('#no_induk').val(value.no_induk).trigger('change'); // no_induk
	$('#nik').val(value.nik).trigger('change'); // nik
	$('#npwp').val(value.npwp).trigger('change'); // npwp
	$('#nama').val(value.nama).trigger('change'); // nama
	$('#tempat_lahir').val(value.tempat_lahir).trigger('change'); // alamat
	$('#tgl_lahir').datepicker('update',value.tgl_lahir); // alamat
	$('#alamat').val(value.alamat).trigger('change'); // alamat
	$('#telp').val(value.telp).trigger('change'); // telp
	$('#email').val(value.email).trigger('change'); // email
	$('#tgl_masuk').datepicker('update',value.tgl_masuk); // email
	$('#jabatan').val(value.id_pekerjaan).trigger('change'); // alamat
	$('#status').val(value.status).trigger('change'); // status
	$('#id_karyawan').val(value.id);
}

// function reset form
function resetForm(){
	$('#form_karyawan').find("div.form-group .field").val('');
	$('#form_karyawan').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_karyawan').find("span.pesan").text(""); // hapus semua span help-block
	$('#id_karyawan').val("");
}

// function set select jabatan
function setSelect_jabatan(){
	$.ajax({
		url: base_url+"app/controllers/Karyawan.php",
		type: "post",
		dataType: "json",
		data: {"action": "getSelect_pekerjaan"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#jabatan').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status Karyawan --"},
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
		$('.form-karyawan').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-karyawan').unblock();
}