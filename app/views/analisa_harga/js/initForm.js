$(document).ready(function(){
	var cekEdit = false;

	// cek status form, tambah/edit
	if(!jQuery.isEmptyObject(urlParams.id)){ // jika ada parameter get
		// edit_barang(urlParams.id);
		cekEdit = true;
	}

	$(".select2").select2();
	$('#tgl').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });
	$('#tgl').datepicker('update',getTanggal());

	setSelect_basis();
	setSelect_kir();

	if(cekEdit) getEdit(urlParams.id);

    $("#form_analisa_harga").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// tanggal
    	$("#tgl").change(function(){
    		if(this.value !== ""){
    			$('.field-tgl').removeClass('has-error').addClass('has-success');
				$(".field-tgl span.help-block").text('');
    		}
    	});

    	// select harga basis
    	$("#id_basis").change(function(){
    		if(this.value !== ""){
    			$('.field-id-basis').removeClass('has-error').addClass('has-success');
				$(".field-id-basis span.help-block").text('');

				var harga_basis = $("#id_basis option:selected").text().split(" - ");
				$("#harga_basis").val(parseFloat(harga_basis[1]));
    		}
    	});

    	// harga basis
    	$("#harga_basis").change(function(){
    		if(this.value !== ""){
    			$('.field-harga-basis').removeClass('has-error').addClass('has-success');
				$(".field-harga-basis span.help-block").text('');
				$('.satuan-stok').text(this.value);
    		}
    	});

    	// kode kir
    	$("#kd_kir").change(function(){
    		if(this.value !== ""){
    			$('.field-kd-kir').removeClass('has-error').addClass('has-success');
				$(".field-kd-kir span.help-block").text('');

				// get data kir
				console.log(getData_kir(this.value));
    		}
    	});    	

    	// harga beli
		$("#harga_beli").change(function(){
    		if(this.value !== ""){
    			$('.field-harga-beli').removeClass('has-error').addClass('has-success');
				$(".field-harga-beli span.help-block").text('');
    		}
    	});    	
    // ========================================= //
});

// function get form
function getDataForm(){
	var data = new FormData();

	var dataProduk = {
		id_produk: $("#id_produk").val().trim(),
		kd_produk: $("#kd_produk").val().trim(),
		nama: $("#nama").val().trim(),
		satuan: $("#satuan").val().trim(),
		ket: $("#ket").val().trim(),
		stok: $("#stok").val().trim(),
	};

	data.append('dataProduk', JSON.stringify(dataProduk)); // dataProduk
	data.append('dataKomposisi', JSON.stringify(listKomposisi)); // dataKomposisi
	data.append('foto', $("#foto")[0].files[0]); // foto
	data.append('action', $("#btnSubmit_produk").val().trim()); // stok

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	console.log(data);

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
				if(output.errorDB){ // jika db error
					setLoading();
					swal("Pesan Error", "Koneksi Database Error, Silahkan Coba Lagi", "error");
				}
				else{
					if(!output.cekList){
						$.toast({
							heading: 'Pesan Error',
							text: 'Komposisi Tidak Boleh Kosong',
							position: 'top-right',
				            loaderBg: '#ff6849',
				            icon: 'error',
				            hideAfter: 3000,
				            stack: 6
						});
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
					}
					setValue(output.setValue);
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
	$(".field-foto").css("display", "none");
	$(".field-stok").css("display", "none");

	$.ajax({
		url: base_url+'app/controllers/Produk.php',
		type: 'post',
		dataType: 'json',
		data: {"id": id, "action": "getEdit"},
		beforeSend: function(){
			setLoading();
		},
		success: function(data){
			console.log(data);
			if(data.dataProduk){
				// console.log(data);
				setLoading(false);
				setValue(data.dataProduk);
				// set value di tabel komposisi
				$.each(data.listKomposisi, function(index, item){
					var index = indexKomposisi++;
					// masukkan data dari server ke array listItem
					var dataKomposisi = {
						aksi: "edit", status: "", 
						index: index, id_komposisi: item.id_komposisi,
						id_bahan_baku: item.id_bahan_baku,
						kd_bahan_baku: item.kd_bahan_baku,
						nama_bahan_baku: item.nama_bahan_baku, 
					};
					listKomposisi.push(dataKomposisi);
					$("#tabel_komposisi > tbody:last-child").append(
						"<tr>"+
							"<td></td>"+ // nomor
							"<td>"+item.kd_bahan_baku+"</td>"+ // kode
							"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
							"<td>"+btnAksi(dataKomposisi.index)+"</td>"+ // aksi
						"</tr>"
					);
					numberingList();
				});
			}
			else{
				swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
				window.location.href = base_url+"index.php?m=produk&p=list";
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
	// kd_produk
	if(!jQuery.isEmptyObject(error.kd_produkError)){
		$('.field-kd-produk').removeClass('has-success').addClass('has-error');
		$(".field-kd-produk span.help-block").text(error.kd_produkError);
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

// // function set value
// function setValue(value){
// 	var stok = parseFloat(value.stok) ? parseFloat(value.stok) : value.stok;

// 	$('#kd_produk').val(value.kd_produk).trigger('change'); // kode bahan baku
// 	$('#nama').val(value.nama).trigger('change'); // nama
// 	$('#satuan').val(value.satuan).trigger('change'); // satuan
// 	$('#ket').val(value.ket).trigger('change'); // ket
// 	$('#stok').val(stok).trigger('change'); // stok
// 	$('#id_produk').val(value.id);
// }

// function set select basis
function setSelect_basis(){
	$.ajax({
		url: base_url+"app/controllers/Analisa_harga.php",
		type: "post",
		dataType: "json",
		data: {
			"action": "get_select_basis",
			"tgl": $('#tgl').val().trim(),
		},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#id_basis').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select kir
function setSelect_kir(){
	$.ajax({
		url: base_url+"app/controllers/Analisa_harga.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_kir_analisa_harga"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#kd_kir').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get data kir
function getData_kir(idKir){
	$.ajax({
		url: base_url+"app/controllers/Analisa_harga.php",
		type: "post",
		dataType: "json",
		data: {
			"action": "get_kir_analisa_harga",
			"id": idKir,
		},
		success: function(data){
			console.log(data);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})	
}

// function setData_kir
function setData_kir_kopi(){

}

function setData_kir_lada(){

}

function getTanggal(){
    var d = new Date();
    var month = '' + (d.getMonth() + 1);
    var day = '' + d.getDate();
    var year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

// function loading modal
function setLoading(block=true){
	if(block === true){
		$('.form-analisa-harga').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-analisa-harga').unblock();
}