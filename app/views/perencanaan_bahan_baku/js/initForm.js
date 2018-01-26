var listKomposisi = [];
var listSafetyStock = [];
var indexKomposisi = 0;
var indexSafetyStock = 0;

$(document).ready(function(){

	$("#produk").select2();
	
	setSelect_produk();
	setSelect_nilaiZ();

	$("#nilai_l").val(1);

	$('#tgl').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });

    $('#periode').datepicker({
        autoclose: true,
        format: "yyyy-mm",
	    startView: "months", 
	    minViewMode: "months",
        todayHighlight: true,
    });

    $("#btnHitung_peramalan").click(function(){
    	hitung_peramalan();
    });

    $("#form_perencanaan").submit(function(e){
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

    	// periode
    	$("#periode").change(function(){
    		if(this.value !== ""){
    			$('.field-periode').removeClass('has-error').addClass('has-success');
				$(".field-periode span.help-block").text('');	
    		}
    	});

    	// produk
    	$("#produk").change(function(){
    		if(this.value !== ""){
    			$('.field-produk').removeClass('has-error').addClass('has-success');
				$(".field-produk span.help-block").text('');

				// get satuan produk
				get_satuanProduk(this.value);

				// get bahan baku
				listKomposisi = [];
				listSafetyStock = [];
				indexKomposisi = 0;
				indexSafetyStock = 0;

				$('#tabel_jumlah_bahanBaku tbody tr').each(function (index) {
				    $(this).remove(); // hapus data ditabel
				});

				$('#tabel_safety_stock_bahanBaku tbody tr').each(function (index) {
				    $(this).remove(); // hapus data ditabel
				});

				$('#hasil_perencanaan').val('');
				get_bahanBaku(this.value);	
    		}
    	});

    	// hasil perencanaan
    	$("#hasil_perencanaan").change(function(){
    		if(this.value !== ""){
    			var temp_nilai_d = parseFloat(this.value) / 24;
    			$('#nilai_d').val(temp_nilai_d);
    		}
    		else{
    			$('#nilai_d').val("");	
    		}
    	});

    	// nilai z
    	$("#nilai_z").change(function(){
    		if(this.value !== "") $("#label_nilai_z").val(this.value);
    		else $("#label_nilai_z").val("");
    	});

    	// safety stock produk
    	$("#safety_stock_produk").change(function(){

    	});
    // ==================================

});

// function get form
function getDataForm(){
	var data = new FormData();
	
	data.append('id_perencanaan', $("#id_perencanaan").val().trim()); // id
	data.append('tgl', $("#tgl").val().trim()); // tgl
	data.append('periode', $("#jenis").val().trim()); // periode
	data.append('produk', $("#produk").val().trim()); // harga basis
	data.append('action', $("#btnSubmit_perencanaan").val().trim()); // action

	return data;
}

// hitung peramalan
function hitung_peramalan(){
	$.ajax({
		url: base_url+'app/controllers/Perencanaan_bahan_baku.php',
		type: 'POST',
		dataType: 'json',
		data: {
			'action': 'hitung_peramalan',
			'periode': $("#periode").val().trim(),
			'produk': $("#produk").val().trim(),
		},
		beforeSend: function(){
			setLoading();
		},
		success: function(output){
			setLoading(false);
			console.log(output);
			
			listKomposisi = [];
			listSafetyStock = [];
			indexKomposisi = 0;
			indexSafetyStock = 0;

			var index = indexKomposisi++;
			var index_ = indexSafetyStock++;

			$('#tabel_jumlah_bahanBaku tbody tr').each(function (index) {
			    $(this).remove(); // hapus data ditabel
			});

			$('#tabel_safety_stock_bahanBaku tbody tr').each(function (index) {
			    $(this).remove(); // hapus data ditabel
			});

			$.each(output.jumlah_bahan_baku, function(index, item){
				var dataKomposisi = {
					index: index,
					id_komposisi: item.id_komposisi,
					id_bahan_baku: item.id_bahan_baku,
					kd_bahan_baku: item.kd_bahan_baku,
					nama_bahan_baku: item.nama_bahan_baku,
					satuan_bahan_baku: item.satuan_bahan_baku,
					penyusutan: item.penyusutan,
					jumlah_bahanBaku: item.jumlah_bahanBaku,
				};
				var dataSafetyStock = {
					index: index_,
					id_komposisi: item.id_komposisi,
					id_bahan_baku: item.id_bahan_baku,
					kd_bahan_baku: item.kd_bahan_baku,
					nama_bahan_baku: item.nama_bahan_baku,
					satuan_bahan_baku: item.satuan_bahan_baku,
					penyusutan: item.penyusutan,
					safety_stock: 0,
				}
				listKomposisi.push(dataKomposisi);
				listSafetyStock.push(dataSafetyStock);
			});

			$('#hasil_perencanaan').val(output.hasil_peramalan.toFixed(2)).trigger('change');

			// tabel jumlah bahan baku
			$.each(listKomposisi, function(index, item){
				$("#tabel_jumlah_bahanBaku > tbody:last-child").append(
					"<tr>"+
						"<td></td>"+ // nomor
						"<td>"+item.kd_bahan_baku+"</td>"+ // kode
						"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
						"<td>"+field_jumlah_bahanBaku(item.jumlah_bahanBaku.toFixed(2), item.satuan_bahan_baku, item.index)+"</td>"+ // jumlah
					"</tr>"
				);
				numberingList_jumlah_bahanBaku();
			});

			$("#safety_stock_produk").val(hitung_safetyStock_produk(output.hasil_peramalan.toFixed(2))).trigger('change');

			$.each(listSafetyStock, function(index, item){
				$("#tabel_safety_stock_bahanBaku > tbody:last-child").append(
					"<tr>"+
						"<td></td>"+ // nomor
						"<td>"+item.kd_bahan_baku+"</td>"+ // kode
						"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
						"<td>"+field_jumlah_safety_stock(item.safety_stock, item.satuan_bahan_baku, item.index)+"</td>"+ // jumlah
					"</tr>"
				);

				numberingList_safety_stock();
			});

			console.log(listKomposisi);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            setLoading(false);
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function hitung_safetyStock_produk(nilai_perencanaan){
	var l = 1;
	var Sl2 = Math.pow((l/10), 2);

	var d = nilai_perencanaan / 24;
	var d2 = Math.pow(d, 2);
	var Sd2 = Math.pow((d/10), 2);

	var sdl = Math.sqrt(d2*Sl2+l*Sd2);
	var ss = parseFloat($('#nilai_z').val()) * sdl;

	console.log(ss.toFixed(2));
	return ss.toFixed(2);
}

function numberingList_jumlah_bahanBaku(){
	$('#tabel_jumlah_bahanBaku tbody tr').each(function (index) {
        $(this).children("td:eq(0)").html(index + 1);
    });
}

function numberingList_safety_stock(){
	$('#tabel_safety_stock_bahanBaku tbody tr').each(function (index) {
        $(this).children("td:eq(0)").html(index + 1);
    });
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Harga_basis.php',
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
					$("#modal_hargaBasis").modal('hide');
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
				$("#modal_hargaBasis").modal('hide');
				var toastText = ($("#btnSubmit_hargaBasis").val().toLowerCase()=="tambah") ? 'Data Berhasil di Simpan' : 'Data Berhasil di Edit';
				$.toast({
					heading: 'Pesan Berhasil',
					text: toastText,
					position: 'top-right',
		            loaderBg: '#ff6849',
		            icon: 'success',
		            hideAfter: 3000,
		            stack: 6
				});
				$("#tabel_harga_basis").DataTable().ajax.reload();
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

// function reset form
function resetForm(){
	$('#form_hargaBasis').trigger('reset');
	$('#form_hargaBasis').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
	$('#form_hargaBasis').find("span.pesan").text(""); // hapus semua span help-block
	$('#id_harga_basis').val("");
}

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
	if(!jQuery.isEmptyObject(error.tglError)){
		$('.field-tgl').removeClass('has-success').addClass('has-error');
		$(".field-tgl span.help-block").text(error.tglError);
	}
	else{
		$('.field-tgl').removeClass('has-error').addClass('has-success');
		$(".field-tgl span.help-block").text('');	
	}

	if(!jQuery.isEmptyObject(error.jenisError)){
		$('.field-jenis').removeClass('has-success').addClass('has-error');
		$(".field-jenis span.help-block").text(error.jenisError);
	}
	else{
		$('.field-jenis').removeClass('has-error').addClass('has-success');
		$(".field-jenis span.help-block").text('');	
	}

	if(!jQuery.isEmptyObject(error.harga_basisError)){
		$('.field-harga-basis').removeClass('has-success').addClass('has-error');
		$(".field-harga-basis span.help-block").text(error.harga_basisError);
	}
	else{
		$('.field-harga-basis').removeClass('has-error').addClass('has-success');
		$(".field-harga-basis span.help-block").text('');	
	}
}

function setValue(value){
	var harga_basis = parseFloat(value.harga_basis) ? parseFloat(value.harga_basis) : value.harga_basis;

	$("#tgl").datepicker('update',value.tgl);
	$("#jenis").val(value.jenis).trigger('change');;
	$("#harga_basis").val(harga_basis).trigger('change');;
	$("#id_harga_basis").val(value.id).trigger('change');;
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

// function get satuan produk
function get_satuanProduk(id){
	$.ajax({
		url: base_url+"app/controllers/Produk.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_satuan_produk", "id": id},
		success: function(data){
			$('.satuan-produk').text(data);
			$('.satuan-ss-produk').text(data);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function get bahan baku
function get_bahanBaku(id_produk){
	var index = indexKomposisi++;
	var index_ = indexSafetyStock++;

	$.ajax({
		url: base_url+"app/controllers/Produk.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_komposisi_produk", "id": id_produk},
		success: function(data){
			console.log(data);

			// masukkan data ke var baru
			$.each(data, function(index, item){
				var dataKomposisi = {
					index: index,
					id_komposisi: item.id_komposisi,
					id_bahan_baku: item.id_bahan_baku,
					kd_bahan_baku: item.kd_bahan_baku,
					nama_bahan_baku: item.nama_bahan_baku,
					satuan_bahan_baku: item.satuan_bahan_baku,
					penyusutan: item.penyusutan,
					jumlah_bahanBaku: 0,
				};
				var dataSafetyStock = {
					index: index_,
					id_komposisi: item.id_komposisi,
					id_bahan_baku: item.id_bahan_baku,
					kd_bahan_baku: item.kd_bahan_baku,
					nama_bahan_baku: item.nama_bahan_baku,
					satuan_bahan_baku: item.satuan_bahan_baku,
					penyusutan: item.penyusutan,
					safety_stock: 0,
				}
				listKomposisi.push(dataKomposisi);
				listSafetyStock.push(dataSafetyStock);
			});

			$.each(listKomposisi, function(index, item){
				$("#tabel_jumlah_bahanBaku > tbody:last-child").append(
					"<tr>"+
						"<td></td>"+ // nomor
						"<td>"+item.kd_bahan_baku+"</td>"+ // kode
						"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
						"<td>"+field_jumlah_bahanBaku(item.jumlah_bahanBaku, item.satuan_bahan_baku, item.index)+"</td>"+ // jumlah
					"</tr>"
				);

				numberingList_jumlah_bahanBaku();
			});

			$.each(listSafetyStock, function(index, item){
				$("#tabel_safety_stock_bahanBaku > tbody:last-child").append(
					"<tr>"+
						"<td></td>"+ // nomor
						"<td>"+item.kd_bahan_baku+"</td>"+ // kode
						"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
						"<td>"+field_jumlah_safety_stock(item.safety_stock, item.satuan_bahan_baku, item.index)+"</td>"+ // jumlah
					"</tr>"
				);

				numberingList_safety_stock();
			});

			console.log(listKomposisi);
			console.log(listSafetyStock);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// field jumlah bahan baku
function field_jumlah_bahanBaku(jumlah, satuan, index){
	var field = '<div class="input-group"><input type="number" min="0" step="1" onchange="onChange_jumlah_bahanBaku('+index+',this)" class="form-control" value="'+jumlah+'"><span class="input-group-addon">'+satuan+'</span></div>';
	return field;
}

// onchange jumlah bahan baku
function onChange_jumlah_bahanBaku(index, val){
	// ubah nilai qty di array
	$.each(listKomposisi, function(i, item){
		if(item.index == index){
			item.jumlah_bahanBaku = val.value;
		} 
	});
	numberingList_jumlah_bahanBaku();

	console.log(listKomposisi);
}

// field safety stock bahan baku
function field_jumlah_safety_stock(safety_stock, satuan, index){
	var field = '<div class="input-group"><input type="number" min="0" step="1" onchange="onChange_safety_stock_bahanBaku('+index+',this)" class="form-control" value="'+safety_stock+'"><span class="input-group-addon">'+satuan+'</span></div>';
	return field;
}

// onchange safety stock bahan baku
function onChange_safety_stock_bahanBaku(index, val){
	// ubah nilai qty di array
	$.each(listSafetyStock, function(i, item){
		if(item.index == index){
			item.safety_stock = val.value;
		} 
	});
	numberingList_safety_stock();

	console.log(listSafetyStock);
}

// function set service level
function setSelect_nilaiZ(){
	var arrNilaiZ = [
		{value: "", text: "-- Pilih Service Level --"},
		{value: 2.33, text: "99 %"},
		{value: 2.05, text: "98 %"},
		{value: 1.88, text: "97 %"},
		{value: 1.75, text: "96 %"},
		{value: 1.64, text: "95 %"},
		{value: 1.55, text: "94 %"},
		{value: 1.48, text: "93 %"},
		{value: 1.41, text: "92 %"},
		{value: 1.34, text: "91 %"},
		{value: 1.28, text: "90 %"},
		{value: 1.04, text: "85 %"},
		{value: 0.84, text: "80 %"},
		{value: 0.38, text: "65 %"},
		{value: 0.06, text: "52 %"},
	];

	$.each(arrNilaiZ, function(index, item){
		var option = new Option(item.text, item.value);
		$("#nilai_z").append(option);
	});

	$("#nilai_z").val(1.75);
	$("#label_nilai_z").val(1.75);
}

// function loading modal
function setLoading(block=true){
	if(block === true){
		$('.form-perencanaan').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-perencanaan').unblock();
}