var listJumlahBahanBaku = [];
var listSafetyStock = [];
var indexJumlahBahanBaku = 0;
var indexSafetyStock = 0;
var cekParameter = false;

$(document).ready(function(){
	// Switchery
    var edit_parameter_ss = document.querySelector('.js-switch');
	var switchery = new Switchery(edit_parameter_ss);

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

    $('#tgl').datepicker('update',getTanggal());    

    $("#btnHitung_peramalan").click(function(){
    	hitung_peramalan();
    });

    $("#btnHitung_safetyStock").click(function(){
    	hitung_safetyStock();
    })

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

				listJumlahBahanBaku = [];
				listSafetyStock = [];
				indexJumlahBahanBaku = 0;
				indexSafetyStock = 0;

				$('#tabel_jumlah_bahanBaku tbody tr').each(function (index) {
				    $(this).remove(); // hapus data ditabel
				});

				$('#tabel_safety_stock_bahanBaku tbody tr').each(function (index) {
				    $(this).remove(); // hapus data ditabel
				});

				$('#hasil_perencanaan').val('');
				$('#safety_stock_produk').val('');

				get_bahanBaku(this.value);	
    		}
    	});

    	// hasil perencanaan
    	$("#hasil_perencanaan").change(function(){
    		if(this.value !== ""){
    			$('.field-hasil-perencanaan').removeClass('has-error').addClass('has-success');
				$(".field-hasil-perencanaan span.help-block").text('');

    			var temp_nilai_d = parseFloat(this.value) / 24;
    			$('#nilai_d').val(temp_nilai_d.toFixed(2));
    			hitung_jumlah_bahanBaku();
    		}
    		else{
    			$('#nilai_d').val("");	
    		}
    	});

    	edit_parameter_ss.onchange = function() {
		 	// console.log(this.checked);
		 	if(this.checked){
		 		$('#nilai_z').prop('disabled', false);
		 		$('#nilai_l').prop('disabled', false);

		 		cekParameter = true;
		 	}
		 	else{
		 		$('#nilai_z').prop('disabled', true);
		 		$('#nilai_l').prop('disabled', true);

		 		// kembalikan ke nilai default
		 		$("#nilai_z").val(1.75).trigger('change');
		 		$("#nilai_l").val(1);

		 		$('.field-nilai-z').removeClass('has-error');
				$(".field-nilai-z span.help-block").text('');
				$('.field-nilai-l').removeClass('has-error');
				$(".field-nilai-l span.help-block").text('');

		 		cekParameter = false;
		 	}
		 	console.log(cekParameter);
		};

    	// nilai z
    	$("#nilai_z").change(function(){
    		if(this.value !== "") {
    			$("#label_nilai_z").val(this.value);
    			$('.field-nilai-z').removeClass('has-error');
				$(".field-nilai-z span.help-block").text('');
    		}
    		else $("#label_nilai_z").val("");
    	});

    	// nilai l
    	$("#nilai_l").change(function(){
    		if(this.value !== "") {
    			$('.field-nilai-l').removeClass('has-error');
				$(".field-nilai-l span.help-block").text('');
    		}
    	});

    	// safety stock produk
    	$("#safety_stock_produk").change(function(){
    		if(this.value !== ""){
    			$('.field-safety-stock-produk').removeClass('has-error').addClass('has-success');
				$(".field-safety-stock-produk span.help-block").text('');

    			hitung_safetyStock_bahanBaku();
    		}
    	});
    // ==================================

});

// function - function peramalan dan hasil perencanaan //
	// hitung peramalan
	function hitung_peramalan(){
		$.ajax({
			url: base_url+'app/controllers/Perencanaan_bahan_baku.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'action': $("#btnHitung_peramalan").val().trim(),
				'periode': $("#periode").val().trim(),
				'produk': $("#produk").val().trim(),
			},
			beforeSend: function(){
				setLoading();
			},
			success: function(output){
				console.log(output);
				setLoading(false);
				// setValue_peramalan(output.setValue);
				if(!output.status){
					$.toast({
						heading: 'Pesan Error',
						text: 'Harap Cek Kembali Field Periode dan Produk!',
						position: 'top-right',
			            loaderBg: '#ff6849',
			            icon: 'error',
			            hideAfter: 3000,
			            stack: 6
					});
					setError_peramalan(output.setError);
				}
				else{
					listJumlahBahanBaku = [];
					indexJumlahBahanBaku = 0;

					var index = indexJumlahBahanBaku++;

					$('#tabel_jumlah_bahanBaku tbody tr').each(function (index) {
					    $(this).remove(); // hapus data ditabel
					});

					$.each(output.jumlah_bahanBaku, function(index, item){
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
						listJumlahBahanBaku.push(dataKomposisi);
					});

					$('#hasil_perencanaan').val(parseFloat(output.hasilPeramalan));
					$('.field-hasil-perencanaan').removeClass('has-error').addClass('has-success');
					$(".field-hasil-perencanaan span.help-block").text('');
					var temp_nilai_d = parseFloat(output.hasilPeramalan) / 24;
    				$('#nilai_d').val(temp_nilai_d.toFixed(2));

					// tabel jumlah bahan baku
					$.each(listJumlahBahanBaku, function(index, item){
						$("#tabel_jumlah_bahanBaku > tbody:last-child").append(
							"<tr>"+
								"<td></td>"+ // nomor
								"<td>"+item.kd_bahan_baku+"</td>"+ // kode
								"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
								"<td>"+item.jumlah_bahanBaku+" "+item.satuan_bahan_baku+"</td>"+ // jumlah
								// "<td>"+field_jumlah_bahanBaku(item.jumlah_bahanBaku.toFixed(2), item.satuan_bahan_baku, item.index)+"</td>"+ // jumlah
							"</tr>"
						);
						numberingList_jumlah_bahanBaku();
					});

					console.log(listJumlahBahanBaku);
				}	
			},
			error: function (jqXHR, textStatus, errorThrown){ // error handling
	            setLoading(false);
	            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
	            console.log(jqXHR, textStatus, errorThrown);
	        }
		})
	}

	// function hitung jumlah bahan baku
	function hitung_jumlah_bahanBaku(){
		$.ajax({
			url: base_url+'app/controllers/Perencanaan_bahan_baku.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'action': 'hitung_jumlah_bahanbaku',
				'nilai_perencanaan': parseFloat($("#hasil_perencanaan").val().trim()),
				'produk': $("#produk").val().trim(),
			},
			beforeSend: function(){
				setLoading();
			},
			success: function(output){
				console.log(output);
				setLoading(false);

				listJumlahBahanBaku = [];
				indexJumlahBahanBaku = 0;

				var index = indexJumlahBahanBaku++;
				$('#tabel_jumlah_bahanBaku tbody tr').each(function (index) {
				    $(this).remove(); // hapus data ditabel
				});

				$.each(output, function(index, item){
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
					listJumlahBahanBaku.push(dataKomposisi);
				});

				$.each(listJumlahBahanBaku, function(index, item){
					$("#tabel_jumlah_bahanBaku > tbody:last-child").append(
						"<tr>"+
							"<td></td>"+ // nomor
							"<td>"+item.kd_bahan_baku+"</td>"+ // kode
							"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
							"<td>"+item.jumlah_bahanBaku+" "+item.satuan_bahan_baku+"</td>"+ // jumlah
						"</tr>"
					);
					numberingList_jumlah_bahanBaku();
				});
			},
			error: function (jqXHR, textStatus, errorThrown){ // error handling
	            setLoading(false);
	            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
	            console.log(jqXHR, textStatus, errorThrown);
	        }
		})
	}

	// numbering list tabel jumlah bahan baku
	function numberingList_jumlah_bahanBaku(){
		$('#tabel_jumlah_bahanBaku tbody tr').each(function (index) {
	        $(this).children("td:eq(0)").html(index + 1);
	    });
	}

	// function setError peramalan
	function setError_peramalan(error){
		// periode
		if(!jQuery.isEmptyObject(error.periodeError)){
			$('.field-periode').removeClass('has-success').addClass('has-error');
			$(".field-periode span.help-block").text(error.periodeError);
		}
		else{
			$('.field-periode').removeClass('has-error').addClass('has-success');
			$(".field-periode span.help-block").text('');	
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
	}

	// function setValue peramalan
	// function setValue_peramalan(value){
	// 	$("#periode").datepicker('update',value.periode);
	// 	$("#produk").val(value.produk);
	// }
// =========================================== //

// function - function safety stock //
	// function hitung safety stock produk
	function hitung_safetyStock(){
		$.ajax({
			url: base_url+'app/controllers/Perencanaan_bahan_baku.php',
			type: 'POST',
			dataType: 'json',
			data: {
				'action': 'hitung_safety_stock',
				'cekParameter': cekParameter,
				'produk': $("#produk").val().trim(),
				'hasil_perencanaan': parseFloat($("#hasil_perencanaan").val().trim()),
				'nilai_z': parseFloat($("#nilai_z").val().trim()),
				'nilai_l': parseInt($("#nilai_l").val().trim()),
			},
			beforeSend: function(){
				setLoading();
			},
			success: function(output){
				setLoading(false);
				console.log(output);

				// setValue_safetyStock(output.setValue);
				if(!output.status){
					var pesan = (output.cekParameter == true) ? "Harap Cek Kembali Field Produk dan Hasil Perencanaan!" 
																: "Harap Cek Kembali Field Produk, Hasil Perencanaan, dan Parameter Safety Stock!";
					$.toast({
						heading: 'Pesan Error',
						text: pesan,
						position: 'top-right',
			            loaderBg: '#ff6849',
			            icon: 'error',
			            hideAfter: 3000,
			            stack: 6
					});
					setError_safetyStock(output.setError);
				}
				else{
					listSafetyStock = [];
					indexSafetyStock = 0;

					var index = indexSafetyStock++;

					$('#tabel_safety_stock_bahanBaku tbody tr').each(function (index) {
					    $(this).remove(); // hapus data ditabel
					});

					$.each(output.safety_stock_bahanBaku, function(index, item){
						var dataSafetyStock = {
							index: index,
							id_komposisi: item.id_komposisi,
							id_bahan_baku: item.id_bahan_baku,
							kd_bahan_baku: item.kd_bahan_baku,
							nama_bahan_baku: item.nama_bahan_baku,
							satuan_bahan_baku: item.satuan_bahan_baku,
							penyusutan: item.penyusutan,
							safety_stock: parseFloat(item.safety_stock),
						};
						listSafetyStock.push(dataSafetyStock);
					});

					$('#safety_stock_produk').val(output.safety_stock_produk);
					$('.field-safety-stock-produk').removeClass('has-error').addClass('has-success');
					$(".field-safety-stock-produk span.help-block").text('');

					// tabel safety stock bahan baku
					$.each(listSafetyStock, function(index, item){
						$("#tabel_safety_stock_bahanBaku > tbody:last-child").append(
							"<tr>"+
								"<td></td>"+ // nomor
								"<td>"+item.kd_bahan_baku+"</td>"+ // kode
								"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
								"<td>"+item.safety_stock+" "+item.satuan_bahan_baku+"</td>"+ // safety stock
							"</tr>"
						);

						numberingList_safety_stock();
					});
				}
			},
			error: function (jqXHR, textStatus, errorThrown){ // error handling
	            setLoading(false);
	            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
	            console.log(jqXHR, textStatus, errorThrown);
	        }
		})
	}

	// function hitung safety stock bahan baku
	function hitung_safetyStock_bahanBaku(){
		
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

	// function numbering list tabel safety stock
	function numberingList_safety_stock(){
		$('#tabel_safety_stock_bahanBaku tbody tr').each(function (index) {
	        $(this).children("td:eq(0)").html(index + 1);
	    });
	}

	// function setError safety stock
	function setError_safetyStock(error){
		// produk
		if(!jQuery.isEmptyObject(error.produkError)){
			$('.field-produk').removeClass('has-success').addClass('has-error');
			$(".field-produk span.help-block").text(error.produkError);
		}
		else{
			$('.field-produk').removeClass('has-error').addClass('has-success');
			$(".field-produk span.help-block").text('');	
		}

		// hasil perencanaan
		if(!jQuery.isEmptyObject(error.hasilPerencanaanError)){
			$('.field-hasil-perencanaan').removeClass('has-success').addClass('has-error');
			$(".field-hasil-perencanaan span.help-block").text(error.hasilPerencanaanError);
		}
		else{
			$('.field-hasil-perencanaan').removeClass('has-error').addClass('has-success');
			$(".field-hasil-perencanaan span.help-block").text('');	
		}

		// nilai z
		if(!jQuery.isEmptyObject(error.nilai_zError)){
			$('.field-nilai-z').addClass('has-error');
			$(".field-nilai-z span.help-block").text(error.nilai_zError);
		}
		else{
			$('.field-nilai-z').removeClass('has-error');
			$(".field-nilai-z span.help-block").text('');	
		}

		// nilai l
		if(!jQuery.isEmptyObject(error.nilai_lError)){
			$('.field-nilai-l').addClass('has-error');
			$(".field-nilai-l span.help-block").text(error.nilai_lError);
		}
		else{
			$('.field-nilai-l').removeClass('has-error');
			$(".field-nilai-l span.help-block").text('');	
		}
	}

	// function setValue safety stock
	// function setValue_safetyStock(value){

	// }
// =========================================== //
	
// function get form
function getDataForm(){
	var data = new FormData();
	
	var dataPerencanaan = {
		id_perencanaan: $("#id_perencanaan").val().trim(),
		tgl: $("#tgl").val().trim(),
		periode: $("#periode").val().trim(),
		produk: $("#produk").val().trim(),
		hasil_perencanaan: parseFloat($("#hasil_perencanaan").val().trim()),
		safety_stock_produk: parseFloat($("#safety_stock_produk").val().trim()),
	};

	data.append('dataPerencanaan', JSON.stringify(dataPerencanaan)); // Data Perencanaan
	data.append('listJumlahBahanBaku', JSON.stringify(listJumlahBahanBaku)); // jumlah bahan baku
	data.append('safety_stock_bahanBaku', JSON.stringify(listSafetyStock)); // safety stock bahan baku
	data.append('action', $("#btnSubmit_perencanaan").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Perencanaan_bahan_baku.php',
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
					// setLoading();
					swal("Pesan Error", "Koneksi Database Error, Silahkan Coba Lagi", "error");
				}
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
			else window.location.href = base_url+"index.php?m=perencanaan_bahan_baku&p=list";
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
			setLoading(false);
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
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
	// tgl
	if(!jQuery.isEmptyObject(error.tglError)){
		$('.field-tgl').removeClass('has-success').addClass('has-error');
		$(".field-tgl span.help-block").text(error.tglError);
	}
	else{
		$('.field-tgl').removeClass('has-error').addClass('has-success');
		$(".field-tgl span.help-block").text('');	
	}

	// periode
	if(!jQuery.isEmptyObject(error.periodeError)){
		$('.field-periode').removeClass('has-success').addClass('has-error');
		$(".field-periode span.help-block").text(error.periodeError);
	}
	else{
		$('.field-periode').removeClass('has-error').addClass('has-success');
		$(".field-periode span.help-block").text('');	
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

	// hasil perencanaan
	if(!jQuery.isEmptyObject(error.hasil_perencanaanError)){
		$('.field-hasil-perencanaan').removeClass('has-success').addClass('has-error');
		$(".field-hasil-perencanaan span.help-block").text(error.hasil_perencanaanError);
	}
	else{
		$('.field-hasil-perencanaan').removeClass('has-error').addClass('has-success');
		$(".field-hasil-perencanaan span.help-block").text('');	
	}

	// safety stock produk
	if(!jQuery.isEmptyObject(error.safety_stock_produkError)){
		$('.field-safety-stock-produk').removeClass('has-success').addClass('has-error');
		$(".field-safety-stock-produk span.help-block").text(error.safety_stock_produkError);
	}
	else{
		$('.field-safety-stock-produk').removeClass('has-error').addClass('has-success');
		$(".field-safety-stock-produk span.help-block").text('');	
	}
}

// function setValue(value){
// 	var harga_basis = parseFloat(value.harga_basis) ? parseFloat(value.harga_basis) : value.harga_basis;

// 	$("#tgl").datepicker('update',value.tgl);
// 	$("#jenis").val(value.jenis).trigger('change');;
// 	$("#harga_basis").val(harga_basis).trigger('change');;
// 	$("#id_harga_basis").val(value.id).trigger('change');;
// }

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
	var index = indexJumlahBahanBaku++;
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
				listJumlahBahanBaku.push(dataKomposisi);
				listSafetyStock.push(dataSafetyStock);
			});

			$.each(listJumlahBahanBaku, function(index, item){
				$("#tabel_jumlah_bahanBaku > tbody:last-child").append(
					"<tr>"+
						"<td></td>"+ // nomor
						"<td>"+item.kd_bahan_baku+"</td>"+ // kode
						"<td>"+item.nama_bahan_baku+"</td>"+ // bahan baku
						"<td>"+item.jumlah_bahanBaku+" "+item.satuan_bahan_baku+"</td>"+ // jumlah
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
						"<td>"+item.safety_stock+" "+item.satuan_bahan_baku+"</td>"+ // safety stock
					"</tr>"
				);

				numberingList_safety_stock();
			});

			// console.log(listJumlahBahanBaku);
			// console.log(listSafetyStock);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
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

// function loading
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