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
    			$('.field-kd-produk').removeClass('has-error').addClass('has-success');
				$(".field-kd-produk span.help-block").text('');
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

// funcgsi untuk list komposisi
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
		var penyusutan = parseFloat($("#penyusutan").val().trim());
		var dataKomposisi = {
			aksi: "tambah", status: "", 
			index: index, id_komposisi: "",
			id_bahan_baku: bahan_baku_value,
			kd_bahan_baku: kode_bahan_baku,
			nama_bahan_baku: bahan_baku_text,
			penyusutan: penyusutan, 
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
			if(bahan_baku_value === ""){
				$.toast({
		            heading: 'Pesan Error',
		            text: 'Bahan Baku Tidak Boleh Kosong !',
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
						"<td>"+fieldPenyusutan(penyusutan, index)+"</td>"+ // penyusutan
						"<td>"+btnAksi(index)+"</td>"+ // aksi
					"</tr>"
				);
				numberingList();
				$('#bahan_baku').select2().val('').trigger('change');
			}
		}

		console.log(dataKomposisi);
		console.log(listKomposisi);
	}

	function numberingList(){
		$('#tabel_komposisi tbody tr').each(function (index) {
	        $(this).children("td:eq(0)").html(index + 1);
	    });
	}

	function fieldPenyusutan(penyusutan, index){
		var field = '<div class="input-group"><input type="number" min="0" step="0.01" onchange="onChange_penyusutan('+index+',this)" class="form-control" value="'+penyusutan+'"><span class="input-group-addon">%</span></div>';
		return field;
	}

	function onChange_penyusutan(index, val){
		// ubah nilai qty di array
		$.each(listKomposisi, function(i, item){
			if(item.index == index){
				item.penyusutan = val.value;
			} 
		});
		numberingList();

		console.log(listKomposisi);
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
// ====================================== //

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
						penyusutan: item.penyusutan, 
					};
					listKomposisi.push(dataKomposisi);
					$("#tabel_komposisi > tbody:last-child").append(
						"<tr>"+
							"<td></td>"+ // nomor
							"<td>"+item.kd_bahan_baku+"</td>"+ // kode
							"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
							"<td>"+fieldPenyusutan(parseFloat(item.penyusutan), dataKomposisi.index)+"</td>"+ // penyusutan
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

// function set value
function setValue(value){
	var stok = parseFloat(value.stok) ? parseFloat(value.stok) : value.stok;

	$('#kd_produk').val(value.kd_produk).trigger('change'); // kode bahan baku
	$('#nama').val(value.nama).trigger('change'); // nama
	$('#satuan').val(value.satuan).trigger('change'); // satuan
	$('#ket').val(value.ket).trigger('change'); // ket
	$('#stok').val(stok).trigger('change'); // stok
	$('#id_produk').val(value.id);
}

// function reset form
function resetForm(){
	$('#form_produk').trigger('reset');
	$('#form_produk').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_produk').find("span.pesan").text(""); // hapus semua span help-block
	$('#id_produk').val("");
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