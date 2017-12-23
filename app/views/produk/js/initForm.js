$(document).ready(function(){
	var cekEdit = false;

	// cek status form, tambah/edit
	if(!jQuery.isEmptyObject(urlParams.id)){ // jika ada parameter get
		// edit_barang(urlParams.id);
		cekEdit = true;
	}

	$("#bahan_baku").select2();

	setSelect_satuan();
	setSelect_bahanBaku();

	if(cekEdit) getEdit(urlParams.id);

	$("#btnTambah_komposisi").click(function(){
		add_komposisi();
	});

    $("#form_produk").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// kode produk
    	$("#kd_produk").change(function(){
    		if(this.value !== ""){
    			$('.field-produk').removeClass('has-error').addClass('has-success');
				$(".field-produk span.help-block").text('');
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

    	// bahan baku
		$("#bahan_baku").change(function(){
    		if(this.value !== ""){
    			$('.field-bahan-baku').removeClass('has-error').addClass('has-success');
				$(".field-bahan-baku span.help-block").text('');
    		}
    	});    	
    // ========================================= //
});

// function cek bahan baku dilist
function validBahanBaku(bahan_baku){
	var ada = false;

    $.each(listKomposisi, function(i, item){
    	if(bahan_baku==item.id_bahan_baku && item.status != "hapus") ada = true;
    });

    return ada;
}

// function add komposisi
function add_komposisi(){
	var index = indexKomposisi++;
	var kode_bahan_baku = $("#bahan_baku option:selected").text().split(' - ')[0];
	var bahan_baku_text = $("#bahan_baku option:selected").text().split(' - ')[1];
	var bahan_baku_value = $("#bahan_baku").val().trim();
	var dataKomposisi = {
		aksi: "tambah", status: "", 
		index: index, id: "",
		id_bahan_baku: bahan_baku_value, 
	};

	// validasi komposisi
	if(validBahanBaku(bahan_baku_value)){
		$.toast({
            heading: 'Pesan Error',
            text: bahan_baku_text+' Sudah Ada Di List !',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3000,
            stack: 6
        });
		indexKomposisi -= 1;
	}
	else{
		listKomposisi.push(dataKomposisi);
		$("#tabel_komposisi > tbody:last-child").append(
			"<tr>"+
				"<td></td>"+ // nomor
				"<td>"+kode_bahan_baku+"</td>"+ // kode
				"<td>"+bahan_baku_text+"</td>"+ // bahan baku
				"<td>"+btnAksi(index)+"</td>"+ // aksi
			"</tr>"
		);
		numberingList();
		$('#bahan_baku').select2().val('').trigger('change');
	}

	console.log(dataKomposisi);
	console.log(listKomposisi);
}

function numberingList(){
	$('#tabel_komposisi tbody tr').each(function (index) {
        $(this).children("td:eq(0)").html(index + 1);
    });
}

function btnAksi(index){
	var btn = '<button type="button" class="btn btn-danger btn-sm bnt-flat" onclick="delList('+index+',this)" title="Hapus dari list">'+
              '<i class="fa fa-trash"></button>';
    return btn;
}

function delList(index, val){
	$(val).parent().parent().remove(); // hapus data ditabel
	$.each(listKomposisi, function(i, item){
		if(item.index == index) item.status = "hapus";
	});
	numberingList(); // reset ulang nomer
	console.log(listKomposisi);
}

// function get form
function getDataForm(){
	var dataProduk = new FormData();

	dataProduk.append('id_produk', $("#id_produk").val().trim()); // id
	dataProduk.append('kd_produk', $("#kd_produk").val().trim()); // kode produk
	dataProduk.append('nama', $("#nama").val().trim()); // nama
	dataProduk.append('satuan', $("#satuan").val().trim()); // satuan
	dataProduk.append('ket', $("#ket").val().trim()); // ket
	dataProduk.append('foto', $("#foto")[0].files[0]); // foto
	dataProduk.append('stok', $("#stok").val().trim()); // stok

	var data = {
		"action" : $("#btnSubmit_produk").val().trim(),
		"dataProduk": dataProduk,
	}

	return data;
}

// function submit
function submit(){
	var data = getDataForm();
	data.dataKomposisi = listKomposisi;

	$.ajax({
		url: base_url+'app/controllers/Produk.php',
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
				var toastText = ($("#btnSubmit_produk").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				window.location.href = base_url+"index.php?m=produk&p=list";
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

	// status
	if(!jQuery.isEmptyObject(error.statusError)){
		$('.field-status').addClass('has-error');
		$(".field-status span.help-block").text(error.statusError);
	}
	else{
		$('.field-status').removeClass('has-error').addClass('has-success');
		$(".field-status span.help-block").text('');
	}

	// supplier utama
	if(!jQuery.isEmptyObject(error.supplierUtamaError)){
		$('.field-supplier-utama').addClass('has-error');
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

// function set select bahan baku
function setSelect_bahanBaku(){
	$.ajax({
		url: base_url+"app/controllers/Bahan_baku.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_bahanBaku"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#bahan_baku').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
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
		$('.form-produk').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-produk').unblock();
}