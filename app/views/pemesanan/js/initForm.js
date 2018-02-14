$(document).ready(function(){
	$(".select2").select2();

	setSelect_buyer();
	setSelect_produk();
	setSelect_ketKarung();
	setSelect_kemasan();
	setSelect_status();

	$('#tgl').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });

    $('#waktu_pengiriman').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });

    $('#batas_waktu_pengiriman').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });

    $("#form_pemesanan").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// tgl
    	$("#tgl").change(function(){
    		if(this.value !== ""){
    			$('.field-tgl').removeClass('has-error').addClass('has-success');
				$(".field-tgl span.help-block").text('');	
    		}
    	});

    	// no kontrak
    	$("#no_kontrak").change(function(){
    		if(this.value !== ""){
    			$('.field-no-kontrak').removeClass('has-error').addClass('has-success');
				$(".field-no-kontrak span.help-block").text('');	
    		}
    	});

    	// buyer
    	$("#buyer").change(function(){
    		if(this.value !== ""){
    			$('.field-buyer').removeClass('has-error').addClass('has-success');
				$(".field-buyer span.help-block").text('');	
    		}
    	});

    	// produk
    	$("#produk").change(function(){
    		if(this.value !== ""){
    			$('.field-produk').removeClass('has-error').addClass('has-success');
				$(".field-produk span.help-block").text('');

				// get satuan produk
				get_satuanProduk(this.value);	
    		}
    	});

    	// jumlah produk
    	$("#jumlah").change(function(){
    		if(this.value !== ""){
    			$('.field-jumlah-produk').removeClass('has-error').addClass('has-success');
				$(".field-jumlah-produk span.help-block").text('');	
    		}
    	});

    	// jumlah karung
    	$("#jumlah_karung").change(function(){
    		if(this.value !== ""){
    			$('.field-jumlah-karung').removeClass('has-error').addClass('has-success');
				$(".field-jumlah-karung span.help-block").text('');	
    		}
    	});

    	// ket karung
    	$("#ket_karung").change(function(){
    		if(this.value !== ""){
    			$('.field-ket-karung').removeClass('has-error').addClass('has-success');
				$(".field-ket-karung span.help-block").text('');	
    		}
    	});

    	// kemasan
    	$("#kemasan").change(function(){
    		if(this.value !== ""){
    			$('.field-kemasan').removeClass('has-error').addClass('has-success');
				$(".field-kemasan span.help-block").text('');	
    		}
    	});

    	// waktu pengiriman
    	$("#waktu_pengiriman").change(function(){
    		if(this.value !== ""){
    			$('.field-waktu-pengiriman').removeClass('has-error').addClass('has-success');
				$(".field-waktu-pengiriman span.help-block").text('');

				// cek jadwal	
    		}
    	});

    	// batas waktu pengiriman
    	$("#batas_waktu_pengiriman").change(function(){
    		if(this.value !== ""){
    			$('.field-batas-waktu').removeClass('has-error').addClass('has-success');
				$(".field-batas-waktu span.help-block").text('');

				// cek jadwal	
    		}
    	});

    	// keterangan
    	$("#ket").change(function(){
    		if(this.value !== ""){
    			$('.field-ket').removeClass('has-error').addClass('has-success');
				$(".field-ket span.help-block").text('');	
    		}
    	});

    	// lampiran
    	$("#lampiran").change(function(){
    		if(this.value !== ""){
    			$('.field-lampiran').removeClass('has-error').addClass('has-success');
				$(".field-lampiran span.help-block").text('');	
    		}
    	});

    	// status
    	$("#status").change(function(){
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');	
    		}
    	});
    // ==================================

});

// function get form
function getDataForm(){
	var data = new FormData();
	
	data.append('id_pemesanan', $("#id_pemesanan").val().trim()); // id
	data.append('tgl', $("#tgl").val().trim()); // tgl
	data.append('no_kontrak', $("#no_kontrak").val().trim()); // no kontrak
	data.append('buyer', $("#buyer").val().trim()); // buyer
	data.append('produk', $("#produk").val().trim()); // produk
	data.append('jumlah', $("#jumlah").val().trim()); // jumlah produk
	data.append('jumlah_karung', $("#jumlah_karung").val().trim()); // jumlah karung
	data.append('ket_karung', $("#ket_karung").val().trim()); // keterangan karung
	data.append('kemasan', $("#kemasan").val().trim()); // kemasan
	data.append('waktu_pengiriman', $("#waktu_pengiriman").val().trim()); // waktu pengiriman
	data.append('batas_waktu_pengiriman', $("#batas_waktu_pengiriman").val().trim()); // batas waktu pengiriman
	data.append('ket', $("#ket").val().trim()); // keterangan
	data.append('status', $("#status").val().trim()); // status
	data.append('lampiran', $("#lampiran")[0].files[0]); // lampiran
	data.append('action', $("#btnSubmit_pemesanan").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Pemesanan.php',
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
			}
			else{
				window.location.href = base_url+"index.php?m=pemesanan&p=list";
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
			setLoading(false);
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function reset form
// function resetForm(){
// 	$('#form_hargaBasis').trigger('reset');
// 	$('#form_hargaBasis').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
// 	$('#form_hargaBasis').find("span.pesan").text(""); // hapus semua span help-block
// 	$('#id_harga_basis').val("");
// }

function getEdit(id){
	resetForm();
	$("#labelModalHargaBasis").text("Form Edit Data Harga Basis");
	$("#btnSubmit_hargaBasis").prop("value", "edit");
	$("#btnSubmit_hargaBasis").text("Edit");

	$.ajax({
		url: base_url+'app/controllers/Harga_basis.php',
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
				$("#modal_hargaBasis").modal();
			}
			else{
				setLoading(false);
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            resetForm();
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_hargaBasis").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function setError(error){
	// tgl
	if(!jQuery.isEmptyObject(error.tglError)){
		$('.field-tgl').removeClass('has-success').addClass('has-error');
		$(".field-tgl span.help-block").text(error.tglError);
	}
	else{
		$('.field-tgl').removeClass('has-error').addClass('has-success');
		$(".field-tgl span.help-block").text('');	
	}

	// no kontrak
	if(!jQuery.isEmptyObject(error.no_kontrakError)){
		$('.field-no-kontrak').removeClass('has-success').addClass('has-error');
		$(".field-no-kontrak span.help-block").text(error.no_kontrakError);
	}
	else{
		$('.field-no-kontrak').removeClass('has-error').addClass('has-success');
		$(".field-no-kontrak span.help-block").text('');	
	}

	// buyer
	if(!jQuery.isEmptyObject(error.buyerError)){
		$('.field-buyer').removeClass('has-success').addClass('has-error');
		$(".field-buyer span.help-block").text(error.buyerError);
	}
	else{
		$('.field-buyer').removeClass('has-error').addClass('has-success');
		$(".field-buyer span.help-block").text('');	
	}

	// produk
	if(!jQuery.isEmptyObject(error.produkError)){
		$('.field-produk').removeClass('has-success').addClass('has-error');
		$(".field-produk span.help-block").text(error.produkError);
	}
	else{
		$('.field-produk').removeClass('has-error').addClass('has-success');
		$(".field-produk span.help-block").text('');	
	}

	// jumlah produk
	if(!jQuery.isEmptyObject(error.jumlahError)){
		$('.field-jumlah-produk').removeClass('has-success').addClass('has-error');
		$(".field-jumlah-produk span.help-block").text(error.jumlahError);
	}
	else{
		$('.field-jumlah-produk').removeClass('has-error').addClass('has-success');
		$(".field-jumlah-produk span.help-block").text('');	
	}

	// jumlah karung
	if(!jQuery.isEmptyObject(error.jumlah_karungError)){
		$('.field-jumlah-karung').removeClass('has-success').addClass('has-error');
		$(".field-jumlah-karung span.help-block").text(error.jumlah_karungError);
	}
	else{
		$('.field-jumlah-karung').removeClass('has-error').addClass('has-success');
		$(".field-jumlah-karung span.help-block").text('');	
	}

	// keterangan karung
	if(!jQuery.isEmptyObject(error.ket_karungError)){
		$('.field-ket-karung').removeClass('has-success').addClass('has-error');
		$(".field-ket-karung span.help-block").text(error.ket_karungError);
	}
	else{
		$('.field-ket-karung').removeClass('has-error').addClass('has-success');
		$(".field-ket-karung span.help-block").text('');	
	}

	// kemasan
	if(!jQuery.isEmptyObject(error.kemasanError)){
		$('.field-kemasan').removeClass('has-success').addClass('has-error');
		$(".field-kemasan span.help-block").text(error.kemasanError);
	}
	else{
		$('.field-kemasan').removeClass('has-error').addClass('has-success');
		$(".field-kemasan span.help-block").text('');	
	}

	// waktu pengiriman
	if(!jQuery.isEmptyObject(error.waktu_pengirimanError)){
		$('.field-waktu-pengiriman').removeClass('has-success').addClass('has-error');
		$(".field-waktu-pengiriman span.help-block").text(error.waktu_pengirimanError);
	}
	else{
		$('.field-waktu-pengiriman').removeClass('has-error').addClass('has-success');
		$(".field-waktu-pengiriman span.help-block").text('');	
	}

	// batas waktu pengiriman
	if(!jQuery.isEmptyObject(error.batas_waktu_pengirimanError)){
		$('.field-batas-waktu').removeClass('has-success').addClass('has-error');
		$(".field-batas-waktu span.help-block").text(error.batas_waktu_pengirimanError);
	}
	else{
		$('.field-batas-waktu').removeClass('has-error').addClass('has-success');
		$(".field-batas-waktu span.help-block").text('');	
	}

	// keterangan
	if(!jQuery.isEmptyObject(error.ketError)){
		$('.field-ket').removeClass('has-success').addClass('has-error');
		$(".field-ket span.help-block").text(error.ketError);
	}
	else{
		$('.field-ket').removeClass('has-error').addClass('has-success');
		$(".field-ket span.help-block").text('');	
	}

	// lampiran
	if(!jQuery.isEmptyObject(error.lampiranError)){
		$('.field-lampiran').removeClass('has-success').addClass('has-error');
		$(".field-lampiran span.help-block").text(error.lampiranError);
	}
	else{
		$('.field-lampiran').removeClass('has-error').addClass('has-success');
		$(".field-lampiran span.help-block").text('');	
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

// function setValue(value){
// 	var harga_basis = parseFloat(value.harga_basis) ? parseFloat(value.harga_basis) : value.harga_basis;

// 	$("#tgl").datepicker('update',value.tgl);
// 	$("#jenis").val(value.jenis).trigger('change');;
// 	$("#harga_basis").val(harga_basis).trigger('change');;
// 	$("#id_harga_basis").val(value.id).trigger('change');;
// }

function get_satuanProduk(id){
	$.ajax({
		url: base_url+"app/controllers/Produk.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_satuan_produk", "id": id},
		success: function(data){
			$('.satuan-produk').text(data);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select buyer
function setSelect_buyer(){
	$.ajax({
		url: base_url+"app/controllers/Buyer.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_buyer"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#buyer').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select produk
function setSelect_produk(){
	$.ajax({
		url: base_url+"app/controllers/Produk.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_produk"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#produk').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select ket karung
function setSelect_ketKarung(){
	var arrketKarung = [
		{value: "", text: "-- Pilih Keterangan Karung --"},
		{value: "JUMLAH PASTI", text: "JUMLAH PASTI"},
		{value: "PERKIRAAN", text: "PERKIRAAN"},
	];

	$.each(arrketKarung, function(index, item){
		var option = new Option(item.text, item.value);
		$("#ket_karung").append(option);
	});
}

// function set select kemasan
function setSelect_kemasan(){
	var arrKemasan = [
		{value: "", text: "-- Pilih Jenis Kemasan --"},
		{value: "KARUNG GONI", text: "KARUNG GONI"},
		{value: "KARUNG PLASTIK", text: "KARUNG PLASTIK"},
	];

	$.each(arrKemasan, function(index, item){
		var option = new Option(item.text, item.value);
		$("#kemasan").append(option);
	});
}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status --"},
		{value: "S", text: "SUKSES"},
		{value: "P", text: "PROSES"},
		{value: "W", text: "PENDING"},
		{value: "R", text: "REJECT"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#status").append(option);
	});

	$("#status").val("P").trigger('change');
}

// function loading modal
function setLoading(block=true){
	if(block === true){
		$('.form-pemesanan').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-pemesanan').unblock();
}