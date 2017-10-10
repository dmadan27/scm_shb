$(document).ready(function(){
	$("#supplier_inti").select2();
	$("#supplier_inti").prop("disabled", true);

	setSelect_status();
	setSelect_supplierInti();
    $("#tambah_supplier").click(function(){
    	// bersihkan modal dan tampilkan modal
    	resetForm();
    	$("#labelModalSupplier").text("Form Tambah Data Supplier");
    	$("#btnSubmit_supplier").prop("value", "tambah");
    	$("#modal_supplier").modal();
    });

    $("#form_supplier").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// nik

    	// npwp

    	// nama

    	// telp

    	// alamat

    	// foto

    	// status
    	$("#status").change(function(){
    		// jika tidak diisi
    		if(this.value !== ""){
    			// hapus error

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
    // ========================================= //
});

// function get view
function getView(id){

}

// function get form
function getDataForm(){
	var data = new FormData();
	var supplier_inti = ($("#status").val()!=="0") ? "" : $("#supplier_inti").val();

	data.append('id_supplier', $("#id_supplier").val().trim()); // id
	data.append('nik', $("#nik").val().trim()); // nik
	data.append('npwp', $("#npwp").val().trim()); // npwp
	data.append('nama', $("#nama").val().trim()); // nama
	data.append('telp', $("#telp").val().trim()); // telp
	data.append('alamat', $("#alamat").val().trim()); // alamat
	data.append('foto', $("#foto")[0].files[0]); // foto
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
				if(output.errorDB){ // jika db error
					setLoading();
					swal("Pesan Error", "Koneksi Database Error, Silahkan Coba Lagi", "error");
					resetForm();
					$("modal_supplier").modal('hide');
				}
				else setError(output.setError);
				setValue(output.setValue);
			}
			else{
				$.toast({
					heading: 'Pesan Berhasil',
					text: 'Data Berhasil di Simpan',
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("modal_supplier").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get edit
function getEdit(id){
	resetForm();
	$("#labelModalSupplier").text("Form Edit Data Supplier");
	$("#btnSubmit_supplier").prop("value", "edit");
	$("#modal_supplier").modal();
}

// function set error
function setError(error){
	// nik
	if(!jQuery.isEmptyObject(error.nikError)){
		$('.field-nik').addClass('has-error');
		$(".field-nik span.help-block").text(error.nikError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-nik').removeClass('has-error');
		$(".field-nik span.help-block").text('');
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');	
	}

	// npwp
	if(!jQuery.isEmptyObject(error.npwpError)){
		$('.field-npwp').addClass('has-error');
		$(".field-npwp span.help-block").text(error.npwpError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-npwp').removeClass('has-error');
		$(".field-npwp span.help-block").text('');	
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');
	}

	// nama
	if(!jQuery.isEmptyObject(error.namaError)){
		$('.field-nama').addClass('has-error');
		$(".field-nama span.help-block").text(error.namaError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-nama').removeClass('has-error');
		$(".field-nama span.help-block").text('');
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');	
	}

	// telp
	if(!jQuery.isEmptyObject(error.telpError)){
		$('.field-telp').addClass('has-error');
		$(".field-telp span.help-block").text(error.telpError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-telp').removeClass('has-error');
		$(".field-telp span.help-block").text('');
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');	
	}

	// alamat
	if(!jQuery.isEmptyObject(error.alamatError)){
		$('.field-alamat').addClass('has-error');
		$(".field-alamat span.help-block").text(error.alamatError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-alamat').removeClass('has-error');
		$(".field-alamat span.help-block").text('');
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');	
	}

	// status
	if(!jQuery.isEmptyObject(error.statusError)){
		$('.field-status').addClass('has-error');
		$(".field-status span.help-block").text(error.statusError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-status').removeClass('has-error');
		$(".field-status span.help-block").text('');
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');	
	}

	// supplier inti
	if(!jQuery.isEmptyObject(error.supplierIntiError)){
		$('.field-supplier-inti').addClass('has-error');
		$(".field-supplier-inti span.help-block").text(error.supplierIntiError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-supplier-inti').removeClass('has-error');
		$(".field-supplier-inti span.help-block").text('');
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');	
	}

	// foto
	if(!jQuery.isEmptyObject(error.fotoError)){
		$('.field-foto').addClass('has-error');
		$(".field-foto span.help-block").text(error.fotoError);
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-remove form-control-feedback t-0"></span>');
	}
	else{
		$('.field-foto').removeClass('has-error');
		$(".field-foto span.help-block").text('');
		$(".field-nik span.help-block").append('<span class="glyphicon glyphicon-ok form-control-feedback t-0"></span>');	
	}
}

// function set value
function setValue(value){

}

// function reset form
function resetForm(){

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
function setLoading(unblock=true){
	if(unblock === true){
		$('.modal-content').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.modal-content').unblock();
}