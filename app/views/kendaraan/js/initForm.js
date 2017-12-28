$(document).ready(function(){
	
	$('#tahun').datepicker({
        autoclose: true,
        format: "yyyy",
        viewMode: "years", 
    	minViewMode: "years",
        todayHighlight: true,
    });

	$("#supir").select2();

    setSelect_supir();
    setSelect_status();
    setSelect_jenis();

    $("#tambah_kendaraan").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$(".field-foto").css("display", "block");
    	$("#labelModalKendaraan").text("Form Tambah Data Kendaraan");
    	$("#btnSubmit_kendaraan").prop("value", "tambah");
    	$("#btnSubmit_kendaraan").text("Tambah");
    	$("#modal_kendaraan").modal();
    });

    $("#form_kendaraan").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// no polis
    	$("#no_polis").change(function(){
    		if(this.value !== ""){
    			$('.field-no-polis').removeClass('has-error').addClass('has-success');
				$(".field-no-polis span.help-block").text('');	
    		}
    	});

    	// supir
    	$("#supir").change(function(){
    		if(this.value !== ""){
    			$('.field-supir').removeClass('has-error').addClass('has-success');
				$(".field-supir span.help-block").text('');	
    		}
    	});

    	// pendamping
    	$("#pendamping").change(function(){
    		if(this.value !== ""){
    			$('.field-pendamping').removeClass('has-error').addClass('has-success');
				$(".field-pendamping span.help-block").text('');	
    		}
    	});

    	// status
    	$("#status").change(function(){
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');	
    		}
    	});

    	// tahun
    	$("#tahun").change(function(){
    		if(this.value !== ""){
    			$('.field-tahun').removeClass('has-error').addClass('has-success');
				$(".field-tahun span.help-block").text('');	
    		}
    	});

    	// jenis
    	$("#jenis").change(function(){
    		if(this.value !== ""){
    			$('.field-jenis').removeClass('has-error').addClass('has-success');
				$(".field-jenis span.help-block").text('');	
    		}
    	});

    	// muatan
    	$("#muatan").change(function(){
    		if(this.value !== ""){
    			$('.field-muatan').removeClass('has-error').addClass('has-success');
				$(".field-muatan span.help-block").text('');	
    		}
    	});

    	// foto
    	$("#foto").change(function(){
    		if(this.value !== ""){
    			$('.field-foto').removeClass('has-error').removeClass('has-error').addClass('has-success');
				$(".field-foto span.help-block").text('');	
    		}
    	});
    // ================================================ //
});

function getView(id){

}

// function get form
function getDataForm(){
	var data = new FormData();

	data.append('id_kendaraan', $("#id_kendaraan").val().trim()); // id
	data.append('no_polis', $("#no_polis").val().trim()); // nopol
	data.append('id_supir', $("#supir").val().trim()); // supir
	data.append('pendamping', $("#pendamping").val().trim()); // pendamping
	data.append('status', $("#status").val().trim()); // status
	data.append('tahun', $("#tahun").val().trim()); // tahun
	data.append('jenis', $("#jenis").val().trim()); // jenis
	data.append('muatan', $("#muatan").val().trim()); // muatan
	data.append('foto', $("#foto")[0].files[0]); // foto
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
				setValue(output.setValue);
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
			}
			else{
				resetForm();
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
	// no_polis
	if(!jQuery.isEmptyObject(error.no_polisError)){
		$('.field-no-polis').removeClass('has-success').addClass('has-error');
		$(".field-no-polis span.help-block").text(error.no_polisError);
	}
	else{
		$('.field-no-polis').removeClass('has-error').addClass('has-success');
		$(".field-no-polis span.help-block").text('');	
	}

	// supir
	if(!jQuery.isEmptyObject(error.id_supirError)){
		$('.field-supir').removeClass('has-success').addClass('has-error');
		$(".field-supir span.help-block").text(error.id_supirError);
	}
	else{
		$('.field-supir').removeClass('has-error').addClass('has-success');
		$(".field-supir span.help-block").text('');	
	}

	// pendamping
	if(!jQuery.isEmptyObject(error.pendampingError)){
		$('.field-pendamping').removeClass('has-success').addClass('has-error');
		$(".field-pendamping span.help-block").text(error.pendampingError);
	}
	else{
		$('.field-pendamping').removeClass('has-error').addClass('has-success');
		$(".field-pendamping span.help-block").text('');	
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

	// tahun
	if(!jQuery.isEmptyObject(error.tahunError)){
		$('.field-tahun').removeClass('has-success').addClass('has-error');
		$(".field-tahun span.help-block").text(error.tahunError);
	}
	else{
		$('.field-tahun').removeClass('has-error').addClass('has-success');
		$(".field-tahun span.help-block").text('');	
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

	// muatan
	if(!jQuery.isEmptyObject(error.muatanError)){
		$('.field-muatan').removeClass('has-success').addClass('has-error');
		$(".field-muatan span.help-block").text(error.muatanError);
	}
	else{
		$('.field-muatan').removeClass('has-error').addClass('has-success');
		$(".field-muatan span.help-block").text('');	
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
}

// function set value
function setValue(value){
	var muatan = parseFloat(value.muatan) ? parseFloat(value.muatan) : value.muatan;

	$('#no_polis').val(value.no_polis).trigger('change');
	$('#supir').val(value.id_supir).trigger('change');
	$('#pendamping').val(value.pendamping).trigger('change');
	$('#status').val(value.status).trigger('change');
	$('#tahun').datepicker('update',value.tahun);
	$('#jenis').val(value.jenis).trigger('change');
	$('#muatan').val(muatan).trigger('change');
	$('#id_kendaraan').val(value.id);
}

// function reset form
function resetForm(){
	$('#form_kendaraan').trigger('reset');
	$('#form_kendaraan').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_kendaraan').find("span.pesan").text(""); // hapus semua span help-block
	$('#id_kendaraan').val("");
	$('#supir').val("").trigger('change');
}

// function set select supir
function setSelect_supir(){
	$.ajax({
		url: base_url+"app/controllers/Kendaraan.php",
		type: "post",
		dataType: "json",
		data: {"action": "getSelect_supir"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#supir').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select jenis
function setSelect_jenis(){
	var arrStatus = [
		{value: "", text: "-- Pilih Jenis Kendaraan --"},
		{value: "C", text: "COLT DIESEL"},
		{value: "F", text: "FUSSO"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#jenis").append(option);
	});
}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status Kendaraan --"},
		{value: "1", text: "TERSEDIA"},
		{value: "0", text: "TIDAK TERSEDIA"},
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

