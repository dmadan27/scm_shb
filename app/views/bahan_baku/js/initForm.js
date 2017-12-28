$(document).ready(function(){
	setSelect_satuan();
    $("#tambah_bahanBaku").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$(".field-foto").css("display", "block");
		$(".field-stok").css("display", "block");
    	$("#labelModalBahanBaku").text("Form Tambah Data Bahan Baku");
    	$("#btnSubmit_bahan_baku").prop("value", "tambah");
    	$("#btnSubmit_bahan_baku").text("Tambah");
    	$("#modal_bahan_baku").modal();
    });

    $("#form_bahan_baku").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// kode bahan baku
    	$("#kd_bahan_baku").change(function(){
    		if(this.value !== ""){
    			$('.field-kd-bahan-baku').removeClass('has-error').addClass('has-success');
				$(".field-kd-bahan-baku span.help-block").text('');
    		}
    	});

    	// nama
    	$("#nama").change(function(){
    		if(this.value !== ""){
    			$('.field-nama').removeClass('has-error').addClass('has-success');
				$(".field-nama span.help-block").text('');
    		}
    	});

    	// satuan
    	$("#satuan").change(function(){
    		if(this.value !== ""){
    			$('.field-satuan').removeClass('has-error').addClass('has-success');
				$(".field-satuan span.help-block").text('');
				$('.satuan-stok').text(this.value);
    		}
    	});

    	// ket
    	$("#ket").change(function(){
    		if(this.value !== ""){
    			$('.field-ket').removeClass('has-error').addClass('has-success');
				$(".field-ket span.help-block").text('');
    		}
    	});

    	// foto
    	$("#foto").change(function(){
    		if(this.value !== ""){
    			$('.field-foto').removeClass('has-error').addClass('has-success');
				$(".field-foto span.help-block").text('');
    		}
    	});

    	// stok awal
    	$("#stok").change(function(){
    		if(this.value !== ""){
    			$('.field-stok').removeClass('has-error').addClass('has-success');
				$(".field-stok span.help-block").text('');
    		}
    	});
    // ========================================= //
});

// function get form
function getDataForm(){
	var data = new FormData();

	data.append('id_bahan_baku', $("#id_bahan_baku").val().trim()); // id
	data.append('kd_bahan_baku', $("#kd_bahan_baku").val().trim()); // kode bahan baku
	data.append('nama', $("#nama").val().trim()); // nama
	data.append('satuan', $("#satuan").val().trim()); // satuan
	data.append('ket', $("#ket").val().trim()); // ket
	data.append('foto', $("#foto")[0].files[0]); // foto
	data.append('stok', $("#stok").val().trim()); // stok
	data.append('action', $("#btnSubmit_bahan_baku").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Bahan_baku.php',
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
					$("#modal_bahan_baku").modal('hide');
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
				$("#modal_bahan_baku").modal('hide');
				var toastText = ($("#btnSubmit_bahan_baku").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				$("#tabel_bahanBaku").DataTable().ajax.reload();
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_bahan_baku").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get edit
function getEdit(id){
	resetForm();
	$(".field-foto").css("display", "none");
	$(".field-stok").css("display", "none");
	$("#labelModalBahanBaku").text("Form Edit Data Bahan Baku");
	$("#btnSubmit_bahan_baku").prop("value", "edit");
	$("#btnSubmit_bahan_baku").text("Edit");

	$.ajax({
		url: base_url+'app/controllers/Bahan_baku.php',
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
				$("#modal_bahan_baku").modal();
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
			}	
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_bahan_baku").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set error
function setError(error){
	// kd_bahan_baku
	if(!jQuery.isEmptyObject(error.kd_bahan_bakuError)){
		$('.field-kd-bahan-baku').removeClass('has-success').addClass('has-error');
		$(".field-kd-bahan-baku span.help-block").text(error.kd_bahan_bakuError);
	}
	else{
		$('.field-kd-bahan-baku').removeClass('has-error').addClass('has-success');
		$(".field-kd-bahan-baku span.help-block").text('');
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

	// satuan
	if(!jQuery.isEmptyObject(error.satuanError)){
		$('.field-satuan').removeClass('has-success').addClass('has-error');
		$(".field-satuan span.help-block").text(error.satuanError);
	}
	else{
		$('.field-satuan').removeClass('has-error').addClass('has-success');
		$(".field-satuan span.help-block").text('');
	}

	// ket
	if(!jQuery.isEmptyObject(error.ketError)){
		$('.field-ket').removeClass('has-success').addClass('has-error');
		$(".field-ket span.help-block").text(error.ketError);
	}
	else{
		$('.field-ket').removeClass('has-error').addClass('has-success');
		$(".field-ket span.help-block").text('');
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

	// stok
	if(!jQuery.isEmptyObject(error.stokError)){
		$('.field-stok').removeClass('has-success').addClass('has-error');
		$(".field-stok span.help-block").text(error.stokError);
	}
	else{
		$('.field-stok').removeClass('has-error').addClass('has-success');
		$(".field-stok span.help-block").text('');
	}
}

// function set value
function setValue(value){
	var stok = parseFloat(value.stok) ? parseFloat(value.stok) : value.stok;

	$('#kd_bahan_baku').val(value.kd_bahan_baku).trigger('change'); // kode bahan baku
	$('#nama').val(value.nama).trigger('change'); // nama
	$('#satuan').val(value.satuan).trigger('change'); // satuan
	$('#ket').val(value.ket).trigger('change'); // ket
	$('#stok').val(stok).trigger('change'); // stok
	$('#id_bahan_baku').val(value.id);
}

// function reset form
function resetForm(){
	$('#form_bahan_baku').trigger('reset');
	$('#form_bahan_baku').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_bahan_baku').find("span.pesan").text(""); // hapus semua span help-block
	$('#id_bahan_baku').val("");
}

// function set select satuan
function setSelect_satuan(){
	var arrSatuan = [
		{value: "", text: "-- Pilih Satuan --"},
		{value: "KG", text: "KG"},
		{value: "PCS", text: "PCS"},
	];

	$.each(arrSatuan, function(index, item){
		var option = new Option(item.text, item.value);
		$("#satuan").append(option);
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