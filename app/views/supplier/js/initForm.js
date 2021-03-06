$(document).ready(function(){
	$("#supplier_utama").select2();
	$("#supplier_utama").prop("disabled", true);

	setSelect_status();
	setSelect_supplierUtama();
    $("#tambah_supplier").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$("#labelModalSupplier").text("Form Tambah Data Supplier");
    	$("#btnSubmit_supplier").prop("value", "tambah");
    	$("#btnSubmit_supplier").text("Tambah");
    	$("#modal_supplier").modal();
    });

    $("#form_supplier").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// nik
    	$("#nik").change(function(){
    		if(this.value !== ""){
    			$('.field-nik').removeClass('has-error').addClass('has-success');
				$(".field-nik span.help-block").text('');	
    		}
    	});
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
    			$('.field-telp').addClass('has-success');
				$(".field-telp span.help-block").text('');
    		}
    	});

    	// email
    	$("#email").change(function(){
    		if(this.value !== ""){
    			$('.field-email').addClass('has-success');
				$(".field-email span.help-block").text('');
    		}
    	});

    	// status
    	$("#status").change(function(){
    		// jika tidak diisi
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');

    			if(this.value === '0'){
    				$("#supplier_utama").prop("disabled", false);
    				$("#supplier_utama").focus();
    			}
    			else{
    				$("#supplier_utama").prop("disabled", true);
    				$("#supplier_utama").val("").trigger("change");
    			} 
    		}
    		else{
    			$("#supplier_utama").prop("disabled", true);
    			$("#supplier_utama").val("").trigger("change");	
    		}
    	});

    	// supplier utama
    	$("#supplier_utama").change(function(){
    		if(this.value !== ""){
    			$('.field-supplier-utama').removeClass('has-error').addClass('has-success');
				$(".field-supplier-utama span.help-block").text('');
    		}
    	});
    // ========================================= //
});

// function get form
function getDataForm(){
	var data = new FormData();
	var supplier_utama = ($("#status").val()!=="0") ? $("#id_supplier").val() : $("#supplier_utama").val();

	data.append('id_supplier', $("#id_supplier").val().trim()); // id
	data.append('nik', $("#nik").val().trim()); // nik
	data.append('npwp', $("#npwp").val().trim()); // npwp
	data.append('nama', $("#nama").val().trim()); // nama
	data.append('alamat', $("#alamat").val().trim()); // alamat
	data.append('telp', $("#telp").val().trim()); // telp
	data.append('email', $("#email").val().trim()); // alamat
	data.append('status', $("#status").val().trim()); // status
	data.append('supplier_utama', supplier_utama); // supplier utama
	data.append('action', $("#btnSubmit_supplier").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Supplier.php',
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
					$("#modal_supplier").modal('hide');
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
				$("#modal_supplier").modal('hide');
				var toastText = ($("#btnSubmit_supplier").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				$("#tabel_supplier").DataTable().ajax.reload();
				$('#supplier_utama').find('option').remove().end();
				setSelect_supplierUtama();
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_supplier").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get edit
function getEdit(id){
	resetForm();
	$("#labelModalSupplier").text("Form Edit Data Supplier");
	$("#btnSubmit_supplier").prop("value", "edit");
	$("#btnSubmit_supplier").text("Edit");

	$.ajax({
		url: base_url+'app/controllers/Supplier.php',
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
				if(data.status==='1'){
					$("#supplier_utama option").prop("disabled", false);
					$('#supplier_utama option[value="'+data.supplier_utama+'"]').prop("disabled", true);
				}
				else $("#supplier_utama option").prop("disabled", false);

				setValue(data);
				$("#modal_supplier").modal();
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
			}	
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_supplier").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set error
function setError(error){
	// nik
	if(!jQuery.isEmptyObject(error.nikError)){
		$('.field-nik').removeClass('has-success').addClass('has-error');
		$(".field-nik span.help-block").text(error.nikError);
	}
	else{
		$('.field-nik').removeClass('has-error').addClass('has-success');
		$(".field-nik span.help-block").text('');	
	}

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

	// email
	if(!jQuery.isEmptyObject(error.emailError)){
		$('.field-email').removeClass('has-success').addClass('has-error');
		$(".field-email span.help-block").text(error.emailError);
	}
	else{
		$('.field-email').removeClass('has-error').addClass('has-success');
		$(".field-email span.help-block").text('');
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

	// status
	if(!jQuery.isEmptyObject(error.statusError)){
		$('.field-status').removeClass('has-success').addClass('has-error');
		$(".field-status span.help-block").text(error.statusError);
	}
	else{
		$('.field-status').removeClass('has-error').addClass('has-success');
		$(".field-status span.help-block").text('');
	}

	// supplier utama
	if(!jQuery.isEmptyObject(error.supplierUtamaError)){
		$('.field-supplier-utama').removeClass('has-success').addClass('has-error');
		$(".field-supplier-utama span.help-block").text(error.supplierUtamaError);
	}
	else{
		$('.field-supplier-utama').removeClass('has-error').addClass('has-success');
		$(".field-supplier-utama span.help-block").text('');
	}
}

// function set value
function setValue(value){
	$('#nik').val(value.nik).trigger('change'); // nik
	$('#npwp').val(value.npwp).trigger('change'); // npwp
	$('#nama').val(value.nama).trigger('change'); // nama
	$('#telp').val(value.telp).trigger('change'); // telp
	$('#alamat').val(value.alamat).trigger('change'); // alamat
	$('#status').val(value.status).trigger('change'); // status
	$('#id_supplier').val(value.id);

	if(value.status==='0'){
		$('#supplier_utama').val(value.supplier_utama).trigger('change'); // supplier utama
		$("#supplier_utama").prop("disabled", false);
	}
	else{
		$("#supplier_utama").prop("disabled", true);
		$('#supplier_utama').val("").trigger('change');
	}
}

// function reset form
function resetForm(){
	$('#form_supplier').trigger('reset');
	$('#form_supplier').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_supplier').find("span.pesan").text(""); // hapus semua span help-block
	$("#supplier_utama").val("").trigger('change');
	$("#supplier_utama option").prop("disabled", false);
	$("#supplier_utama").prop("disabled", true);
	$('#id_supplier').val("");
}

// function set select supplier utama
function setSelect_supplierUtama(){
	$.ajax({
		url: base_url+"app/controllers/Supplier.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_supplierUtama"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#supplier_utama').append(option).trigger('change');
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
		{value: "", text: "-- Pilih Status Supplier --"},
		{value: "1", text: "UTAMA"},
		{value: "0", text: "PENGGANTI"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#status").append(option);
	});
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