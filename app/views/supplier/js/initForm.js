$(document).ready(function(){
	$("#supplier_inti").select2();
	$("#supplier_inti").prop("disabled", true);

	setSelect_status();
	setSelect_supplierInti();
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
   //  	swal({
  	// 		title: 'Apakah Anda Yakin ?',
		 //  	text: "Cek Kembali Data Sebelum di Simpan!",
		 //  	type: 'warning',
		 //  	showCancelButton: true,
		 //  	confirmButtonColor: '#3085d6',
		 //  	cancelButtonColor: '#d33',
		 //  	confirmButtonText: 'Ya !',
		 //  	closeOnConfirm: true,
			// },function(){
    			
   //  		}
   //  	);
    	submit();
    	return false;
    });

    // onchange field
    	// nik
    	$("#nik").change(function(){
    		if(this.value !== ""){
    			$('.field-nik').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-nik span.help-block").text('');	
				$(".field-nik span.setError").css("display", "none");
				$(".field-nik span.setSuccess").css("display", "block");
    		}
    	});
    	// npwp
    	$("#npwp").change(function(){
    		if(this.value !== ""){
    			$('.field-npwp').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-npwp span.help-block").text('');	
				$(".field-npwp span.setError").css("display", "none");
				$(".field-npwp span.setSuccess").css("display", "block");
    		}
    	});

    	// nama
    	$("#nama").change(function(){
    		if(this.value !== ""){
    			$('.field-nama').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-nama span.help-block").text('');	
				$(".field-nama span.setError").css("display", "none");
				$(".field-nama span.setSuccess").css("display", "block");
    		}
    	});

    	// telp
    	$("#telp").change(function(){
    		if(this.value !== ""){
    			$('.field-telp').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-telp span.help-block").text('');	
				$(".field-telp span.setError").css("display", "none");
				$(".field-telp span.setSuccess").css("display", "block");
    		}
    	});

    	// alamat
    	$("#alamat").change(function(){
    		if(this.value !== ""){
    			$('.field-alamat').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-alamat span.help-block").text('');	
				$(".field-alamat span.setError").css("display", "none");
				$(".field-alamat span.setSuccess").css("display", "block");
    		}
    	});

    	// status
    	$("#status").change(function(){
    		// jika tidak diisi
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');	
				$(".field-status span.setError").css("display", "none");
				$(".field-status span.setSuccess").css("display", "block");

    			if(this.value === '0'){
    				$("#supplier_inti").prop("disabled", false);
    				$("#supplier_inti").focus();
    			}
    			else{
    				$("#supplier_inti").prop("disabled", true);
    				$("#supplier_inti").val("").trigger("change");
    			} 
    		}
    		else{
    			$("#supplier_inti").prop("disabled", true);
    			$("#supplier_inti").val("").trigger("change");	
    		}
    	});

    	// supplier inti
    	$("#supplier_inti").change(function(){
    		if(this.value !== ""){
    			$('.field-supplier-inti').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-supplier-inti span.help-block").text('');	
				$(".field-supplier-inti span.setError").css("display", "none");
				$(".field-supplier-inti span.setSuccess").css("display", "block");
    		}
    	});
    // ========================================= //
});

// function get view
function getView(id){

}

// function get form
function getDataForm(){
	var data = new FormData();
	var supplier_inti = ($("#status").val()!=="0") ? $("#id_supplier").val() : $("#supplier_inti").val();

	data.append('id_supplier', $("#id_supplier").val().trim()); // id
	data.append('nik', $("#nik").val().trim()); // nik
	data.append('npwp', $("#npwp").val().trim()); // npwp
	data.append('nama', $("#nama").val().trim()); // nama
	data.append('telp', $("#telp").val().trim()); // telp
	data.append('alamat', $("#alamat").val().trim()); // alamat
	data.append('status', $("#status").val().trim()); // status
	data.append('supplier_inti', supplier_inti); // supplier inti
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
				setValue(output.setValue);
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
				$('#supplier_inti').find('option').remove().end();
				setSelect_supplierInti();
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading();
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
					$("#supplier_inti option").prop("disabled", false);
					$('#supplier_inti option[value="'+data.supplier_inti+'"]').prop("disabled", true);
				}
				else $("#supplier_inti option").prop("disabled", false);

				setValue(data);
				$("#modal_supplier").modal();
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading();
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
		$('.field-nik').addClass('has-error');
		$(".field-nik span.help-block").text(error.nikError);
		$(".field-nik span.setError").css("display", "block");
		$(".field-nik span.setSuccess").css("display", "none");
	}
	else{
		$('.field-nik').removeClass('has-error').addClass('has-success');
		$(".field-nik span.help-block").text('');
		$(".field-nik span.setError").css("display", "none");
		$(".field-nik span.setSuccess").css("display", "block");	
	}

	// npwp
	if(!jQuery.isEmptyObject(error.npwpError)){
		$('.field-npwp').addClass('has-error');
		$(".field-npwp span.help-block").text(error.npwpError);
		$(".field-npwp span.setError").css("display", "block");
		$(".field-npwp span.setSuccess").css("display", "none");
	}
	else{
		$('.field-npwp').removeClass('has-error').addClass('has-success');
		$(".field-npwp span.help-block").text('');	
		$(".field-npwp span.setError").css("display", "none");
		$(".field-npwp span.setSuccess").css("display", "block");
	}

	// nama
	if(!jQuery.isEmptyObject(error.namaError)){
		$('.field-nama').addClass('has-error');
		$(".field-nama span.help-block").text(error.namaError);
		$(".field-nama span.setError").css("display", "block");
		$(".field-nama span.setSuccess").css("display", "none");
	}
	else{
		$('.field-nama').removeClass('has-error').addClass('has-success');
		$(".field-nama span.help-block").text('');
		$(".field-nama span.setError").css("display", "none");
		$(".field-nama span.setSuccess").css("display", "block");
	}

	// telp
	if(!jQuery.isEmptyObject(error.telpError)){
		$('.field-telp').addClass('has-error');
		$(".field-telp span.help-block").text(error.telpError);
		$(".field-telp span.setError").css("display", "block");
		$(".field-telp span.setSuccess").css("display", "none");
	}
	else{
		$('.field-telp').removeClass('has-error').addClass('has-success');
		$(".field-telp span.help-block").text('');
		$(".field-telp span.setError").css("display", "none");
		$(".field-telp span.setSuccess").css("display", "block");
	}

	// alamat
	if(!jQuery.isEmptyObject(error.alamatError)){
		$('.field-alamat').addClass('has-error');
		$(".field-alamat span.help-block").text(error.alamatError);
		$(".field-alamat span.setError").css("display", "block");
		$(".field-alamat span.setSuccess").css("display", "none");
	}
	else{
		$('.field-alamat').removeClass('has-error').addClass('has-success');
		$(".field-alamat span.help-block").text('');
		$(".field-alamat span.setError").css("display", "none");
		$(".field-alamat span.setSuccess").css("display", "block");
	}

	// status
	if(!jQuery.isEmptyObject(error.statusError)){
		$('.field-status').addClass('has-error');
		$(".field-status span.help-block").text(error.statusError);
		$(".field-status span.setError").css("display", "block");
		$(".field-status span.setSuccess").css("display", "none");
	}
	else{
		$('.field-status').removeClass('has-error').addClass('has-success');
		$(".field-status span.help-block").text('');
		$(".field-status span.setError").css("display", "none");
		$(".field-status span.setSuccess").css("display", "block");
	}

	// supplier inti
	if(!jQuery.isEmptyObject(error.supplierIntiError)){
		$('.field-supplier-inti').addClass('has-error');
		$(".field-supplier-inti span.help-block").text(error.supplierIntiError);
		$(".field-supplier-inti span.setError").css("display", "block");
		$(".field-supplier-inti span.setSuccess").css("display", "none");
	}
	else{
		$('.field-supplier-inti').removeClass('has-error').addClass('has-success');
		$(".field-supplier-inti span.help-block").text('');
		$(".field-supplier-inti span.setError").css("display", "none");
		$(".field-supplier-inti span.setSuccess").css("display", "block");
	}
}

// function set value
function setValue(value){
	$('#nik').val(value.nik); // nik
	$('#npwp').val(value.npwp); // npwp
	$('#nama').val(value.nama); // nama
	$('#telp').val(value.telp); // telp
	$('#alamat').val(value.alamat); // alamat
	$('#status').val(value.status); // status
	$('#id_supplier').val(value.id);

	if(value.status==='0'){
		$('#supplier_inti').val(value.supplier_inti).trigger('change'); // supplier inti
		$("#supplier_inti").prop("disabled", false);
	}
	else{
		$("#supplier_inti").prop("disabled", true);
		$('#supplier_inti').val("").trigger('change');
	}
}

// function reset form
function resetForm(){
	document.getElementById('form_supplier').reset();
	$('#form_supplier').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_supplier').find("span.pesan").text(""); // hapus semua span help-block
	$('#form_supplier').find("span.setError, span.setSuccess").css("display", "none"); // hapus semua span icon
	$("#supplier_inti").val("").trigger('change');
	$("#supplier_inti option").prop("disabled", false);
	$("#supplier_inti").prop("disabled", true);
	$('#id_supplier').val("");
}

// function set select supplier inti
function setSelect_supplierInti(){
	$.ajax({
		url: base_url+"app/controllers/Supplier.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_supplierInti"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#supplier_inti').append(option).trigger('change');
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
		{value: "1", text: "INTI"},
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