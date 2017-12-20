$(document).ready(function(){
	$(".select2").select2();

	setSelect_status();
	setSelect_jenis();
	setSelect_hak_akses();

	$("#tambah_user").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$("#labelModalUser").text("Form Tambah Data User");
    	$("#btnSubmit_user").prop("value", "tambah");
    	$("#btnSubmit_user").text("Tambah");
    	$("#modal_user").modal();
    });

	$("#form_user").submit(function(e){
		e.preventDefault();
    	submit();
    	return false;
	});

    // onchange field
    	// username
    	$("#username").change(function(){
    		if(this.value !== ""){
    			$('.field-username').removeClass('has-error').addClass('has-success');
				$(".field-username span.help-block").text('');
    		}
    	});

    	// password
    	$("#password").change(function(){
    		if(this.value !== ""){
    			$('.field-password').removeClass('has-error').addClass('has-success');
				$(".field-password span.help-block").text('');
    		}
    	});

    	// konfirm password
    	$("#konf_password").change(function(){
    		if(this.value !== ""){
    			$('.field-konfirmasi-password').removeClass('has-error').addClass('has-success');
				$(".field-konfirmasi-password span.help-block").text('');
    		}
    	});

    	// status
    	$("#status").change(function(){
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');
    		}
    	});

    	//jenis
    	$("#jenis").change(function(){
    		if(this.value !== ""){
    			$('.field-jenis').removeClass('has-error').addClass('has-success');
				$(".field-jenis span.help-block").text('');

				setSelect_pengguna();
    		}
    		else{
    			$("#pengguna").find('option')
				        .remove()
				        .end()
				        .append($('<option>',{
				            value: "", 
				            text: "-- Pilih Pengguna --"
				        })).trigger('change');
    		}   		
    	});

    	// pengguna
    	$("#pengguna").change(function(){
    		if(this.value !== ""){
    			$('.field-pengguna').removeClass('has-error').addClass('has-success');
				$(".field-pengguna span.help-block").text('');
    		}
    	});

    	// hak akses
    	$("#hak_akses").change(function(){
    		if(this.value !== ""){
    			$('.field-hak-akses').removeClass('has-error').addClass('has-success');
				$(".field-hak-akses span.help-block").text('');
    		}
    	});
    // ===================================== //
});

// function get form
function getDataForm(){
	var data = new FormData();

	data.append('id_user', $('#id_user').val().trim()); // id user / username
	data.append('username', $('#username').val().trim()); // username
	data.append('password', $('#password').val().trim()); // password
	data.append('konf_password', $('#konf_password').val().trim()); // konf password
	data.append('status', $('#status').val().trim()); // status
	data.append('jenis', $('#jenis').val().trim()); // jenis
	data.append('pengguna', $('#pengguna').val().trim()); // pengguna
	data.append('hak_akses', $('#hak_akses').val().trim()); // hak akses
	data.append('action', $("#btnSubmit_user").val().trim()); // action

	return data;
}

function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/User.php',
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
					$("#modal_user").modal('hide');
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
				$("#modal_user").modal('hide');
				var toastText = ($("#btnSubmit_user").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				$("#tabel_user").DataTable().ajax.reload();
				$("#pengguna").find('option').remove().end();
				// setSelect_pengguna();
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_user").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function getEdit(id){

}

function setError(error){
	// username
	if(!jQuery.isEmptyObject(error.usernameError)){
		$('.field-username').removeClass('has-success').addClass('has-error');
		$(".field-username span.help-block").text(error.usernameError);
	}
	else{
		$('.field-username').removeClass('has-error').addClass('has-success');
		$(".field-username span.help-block").text('');	
	}

	// password
	if(!jQuery.isEmptyObject(error.passwordError)){
		$('.field-password').removeClass('has-success').addClass('has-error');
		$(".field-password span.help-block").text(error.passwordError);
	}
	else{
		$('.field-password').removeClass('has-error').addClass('has-success');
		$(".field-password span.help-block").text('');	
	}

	// konfirmasi password
	if(!jQuery.isEmptyObject(error.konf_passwordError)){
		$('.field-konfirmasi-password').removeClass('has-success').addClass('has-error');
		$(".field-konfirmasi-password span.help-block").text(error.konf_passwordError);
	}
	else{
		$('.field-konfirmasi-password').removeClass('has-error').addClass('has-success');
		$(".field-konfirmasi-password span.help-block").text('');	
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

	// jenis
	if(!jQuery.isEmptyObject(error.jenisError)){
		$('.field-jenis').removeClass('has-success').addClass('has-error');
		$(".field-jenis span.help-block").text(error.jenisError);
	}
	else{
		$('.field-jenis').removeClass('has-error').addClass('has-success');
		$(".field-jenis span.help-block").text('');	
	}

	// pengguna
	if(!jQuery.isEmptyObject(error.penggunaError)){
		$('.field-pengguna').removeClass('has-success').addClass('has-error');
		$(".field-pengguna span.help-block").text(error.penggunaError);
	}
	else{
		$('.field-nik').removeClass('has-error').addClass('has-success');
		$(".field-nik span.help-block").text('');	
	}

	// hak akses
	if(!jQuery.isEmptyObject(error.hak_aksesError)){
		$('.field-hak-akses').removeClass('has-success').addClass('has-error');
		$(".field-hak-akses span.help-block").text(error.hak_aksesError);
	}
	else{
		$('.field-hak-akses').removeClass('has-error').addClass('has-success');
		$(".field-hak-akses span.help-block").text('');	
	}
}

function setValue(value){
	$("#username").val(value.username).trigger('change'); // username
	$("#password").val(value.password).trigger('change'); // password
	$("#konf_password").val(value.konf_password).trigger('change'); // konfirmasi password
	$("#status").val(value.status).trigger('change'); // status
	$("#jenis").val(value.jenis).trigger('change'); // jenis
	$("#pengguna").val(value.pengguna).trigger('change'); // pengguna
	$("#hak_akses").val(value.hak_akses).trigger('change'); // hak akses
	$("#id_user").val(value.username);
}

function resetForm(){
	$('#form_user').trigger('reset');
	$('#form_user').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_user').find("span.pesan").text(""); // hapus semua span help-block
	$("#pengguna").val("").trigger('change');
	$('#id_user').val("");
}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status User --"},
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

// function set select jenis
function setSelect_jenis(){
	var arrJenis = [
		{value: "", text: "-- Pilih Jenis User --"},
		{value: "K", text: "KARYAWAN"},
		{value: "B", text: "BUYER"},
	];

	$.each(arrJenis, function(index, item){
		var option = new Option(item.text, item.value);
		$("#jenis").append(option);
	});
}

// function set select pengguna
function setSelect_pengguna(){
	var url = action = "";

	if($("#jenis").val() == "K"){
		url = base_url+"app/controllers/Karyawan.php";
		action = "get_select_karyawan";
	}
	else if($("#jenis").val() == "B"){
		url = base_url+"app/controllers/Buyer.php";
		action = "get_select_buyer";
	}

	$("#pengguna").find('option').remove().end();

	$.ajax({
		url: url,
		type: "post",
		dataType: "json",
		data: {"action": action},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#pengguna').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select hak akses
function setSelect_hak_akses(){
	var arrHakAkses = [
		{value: "", text: "-- Pilih Hak Akses --"},
		{value: "DIREKTUR", text: "HAK AKSES DIREKTUR"},
		{value: "BAGIAN ADMINISTRASI DAN KEUANGAN", text: "HAK AKSES BAGIAN ADMINISTRASI & KEUANGAN"},
		{value: "BAGIAN GUDANG", text: "HAK AKSES BAGIAN GUDANG"},
		{value: "BAGIAN ANALISA HARGA", text: "HAK AKSES BAGIAN ANALISA HARGA"},
		{value: "BAGIAN KIR", text: "HAK AKSES BAGIAN KIR"},
		{value: "BAGIAN TEKNISI DAN OPERASIONAL", text: "HAK AKSES BAGIAN TEKNISI & OPERASIONAL"},
		{value: "BUYER", text: "HAK AKSES BUYER"},
	];

	$.each(arrHakAkses, function(index, item){
		var option = new Option(item.text, item.value);
		$("#hak_akses").append(option);
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