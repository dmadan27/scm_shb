$(document).ready(function(){
	var cekEdit = false;

	// cek status form, tambah/edit
	if(!jQuery.isEmptyObject(urlParams.id)){ // jika ada parameter get
		// edit_barang(urlParams.id);
		cekEdit = true;
	}

	$("#kd_kir").prop("readonly", true);
	$("#supplier").select2();

	setSelect_supplier();
	setSelect_jenis();
	setSelect_status();

	$('#tgl').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });
	$('#tgl').datepicker('update',getTanggal());

	if(cekEdit) getEdit(urlParams.id);

    $("#form_kir").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
    	// jenis bahan baku
    	$("#jenis").change(function(){
    		if(this.value !== ""){
    			$('.field-jenis').removeClass('has-error').addClass('has-success');
				$(".field-jenis span.help-block").text('');
				var jenis_kd = (this.value == "K") ? "KP" : "LD";

				setKd_kir(jenis_kd);
				setField_kir(this.value);
    		}
    		else{
    			$("#kd_kir").val("");
    		}
    	});

    	// kode kir
    	$("#kd_kir").change(function(){
    		if(this.value !== ""){
    			$('.field-kd-kir').removeClass('has-error').addClass('has-success');
				$(".field-kd-kir span.help-block").text('');
    		}
    	});

    	// tgl
    	$("#tgl").change(function(){
    		if(this.value !== ""){
    			$('.field-tgl').removeClass('has-error').addClass('has-success');
				$(".field-tgl span.help-block").text('');
    		}
    	});

    	// supplier
    	$("#supplier").change(function(){
    		if(this.value !== ""){
    			$('.field-supplier').removeClass('has-error').addClass('has-success');
				$(".field-supplier span.help-block").text('');
    		}
    	});

    	// status
    	$("#status").change(function(){
    		if(this.value !== ""){
    			$('.field-status').removeClass('has-error').addClass('has-success');
				$(".field-status span.help-block").text('');
    		}
    	});
    // ========================================= //

    // onchange kir-kopi
    	// trase
    	$("#trase").change(function(){
    		if(this.value !== ""){
    			$('.field-trase').removeClass('has-error').addClass('has-success');
				$(".field-trase span.help-block").text('');
    		}
    	});

    	// gelondong
    	$("#gelondong").change(function(){
    		if(this.value !== ""){
    			$('.field-gelondong').removeClass('has-error').addClass('has-success');
				$(".field-gelondong span.help-block").text('');
    		}
    	});

    	// air kopi
    	$("#air_kopi").change(function(){
    		if(this.value !== ""){
    			$('.field-air-kopi').removeClass('has-error').addClass('has-success');
				$(".field-air-kopi span.help-block").text('');
    		}
    	});

    	// ayakan
    	$("#ayakan").change(function(){
    		if(this.value !== ""){
    			$('.field-ayakan').removeClass('has-error').addClass('has-success');
				$(".field-ayakan span.help-block").text('');
    		}
    	});

    	// kulit
    	$("#kulit").change(function(){
    		if(this.value !== ""){
    			$('.field-kulit').removeClass('has-error').addClass('has-success');
				$(".field-kulit span.help-block").text('');
    		}
    	});

    	// rendemen
    	$("#rendemen").change(function(){
    		if(this.value !== ""){
    			$('.field-rendemen').removeClass('has-error').addClass('has-success');
				$(".field-rendemen span.help-block").text('');

				if(parseFloat(this.value) >= 80) $("#status").val("1").trigger('change');
				else $("#status").val("0").trigger('change');
    		}
    	});
    // ========================================= //

    // onchange kir-lada
    	// air lada
    	$("#air_lada").change(function(){
    		if(this.value !== ""){
    			$('.field-air-lada').removeClass('has-error').addClass('has-success');
				$(".field-air-lada span.help-block").text('');
    		}
    	});

    	// berat
    	$("#berat").change(function(){
    		if(this.value !== ""){
    			$('.field-berat').removeClass('has-error').addClass('has-success');
				$(".field-berat span.help-block").text('');
    		}
    	});

    	// abu
    	$("#abu").change(function(){
    		if(this.value !== ""){
    			$('.field-abu').removeClass('has-error').addClass('has-success');
				$(".field-abu span.help-block").text('');
    		}
    	});
    // ========================================= //
});


// function get form
function getDataForm(){
	var data = new FormData();

	var dataKir = {
		id_kir: $('#id_kir').val().trim(),
		kd_kir: $('#kd_kir').val().trim(),
		tgl: $('#tgl').val().trim(),
		id_supplier: $('#supplier').val().trim(),
		jenis_bahan_baku: $("#jenis").val().trim(),
		status: $("#status").val().trim(),
	};

	var dataKir_kopi = {
		kd_kir: $('#kd_kir').val().trim(),
		trase: parseFloat($("#trase").val().trim()),
		gelondong: parseFloat($("#gelondong").val().trim()),
		air: parseFloat($("#air_kopi").val().trim()),
		ayakan: parseFloat($("#ayakan").val().trim()),
		kulit: parseFloat($("#kulit").val().trim()),
		rendemen: parseFloat($("#rendemen").val().trim()),
	};

	var dataKir_lada = {
		kd_kir: $('#kd_kir').val().trim(),
		air: parseFloat($("#air_lada").val().trim()),
		berat: parseFloat($("#berat").val().trim()),
		abu: parseFloat($("#abu").val().trim()),
	};

	data.append('dataKir', JSON.stringify(dataKir)); // data kir
	data.append('dataKir_kopi', JSON.stringify(dataKir_kopi)); // data kir lada
	data.append('dataKir_lada', JSON.stringify(dataKir_lada)); // data kir kopi
	data.append('action', $("#btnSubmit_kir").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Kir.php',
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
				}
				setError_kir(output.setError);

				if(output.setError_kir_kopi !== "") setError_kir_kopi(output.setError_kir_kopi);
				if(output.setError_kir_lada !== "") setError_kir_lada(output.setError_kir_lada);
			}
			else window.location.href = base_url+"index.php?m=kir&p=list";
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
			setLoading(false);
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

// function set error kir
function setError_kir(error){
	// jenis bahan baku
	if(!jQuery.isEmptyObject(error.jenisError)){
		$('.field-jenis').removeClass('has-success').addClass('has-error');
		$(".field-jenis span.help-block").text(error.jenisError);
	}
	else{
		$('.field-jenis').removeClass('has-error').addClass('has-success');
		$(".field-jenis span.help-block").text('');
	}

	// kode kir
	if(!jQuery.isEmptyObject(error.kd_kirError)){
		$('.field-kd-kir').removeClass('has-success').addClass('has-error');
		$(".field-kd-kir span.help-block").text(error.kd_kirError);
	}
	else{
		$('.field-kd-kir').removeClass('has-error').addClass('has-success');
		$(".field-kd-kir span.help-block").text('');
	}

	// tgl
	if(!jQuery.isEmptyObject(error.tglError)){
		$('.field-tgl').removeClass('has-success').addClass('has-error');
		$(".field-tgl span.help-block").text(error.tglError);
	}
	else{
		$('.field-tgl').removeClass('has-error').addClass('has-success');
		$(".field-tgl span.help-block").text('');
	}

	// supplier
	if(!jQuery.isEmptyObject(error.supplierError)){
		$('.field-supplier').removeClass('has-success').addClass('has-error');
		$(".field-supplier span.help-block").text(error.supplierError);
	}
	else{
		$('.field-supplier').removeClass('has-error').addClass('has-success');
		$(".field-supplier span.help-block").text('');
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

// function set error kir kopi
function setError_kir_kopi(error){
	// trase
	if(!jQuery.isEmptyObject(error.traseError)){
		$('.field-trase').removeClass('has-success').addClass('has-error');
		$(".field-trase span.help-block").text(error.traseError);
	}
	else{
		$('.field-trase').removeClass('has-error').addClass('has-success');
		$(".field-trase span.help-block").text('');
	}

	// gelondong
	if(!jQuery.isEmptyObject(error.gelondongError)){
		$('.field-gelondong').removeClass('has-success').addClass('has-error');
		$(".field-gelondong span.help-block").text(error.gelondongError);
	}
	else{
		$('.field-gelondong').removeClass('has-error').addClass('has-success');
		$(".field-gelondong span.help-block").text('');
	}

	// air kopi
	if(!jQuery.isEmptyObject(error.air_kopiError)){
		$('.field-air-kopi').removeClass('has-success').addClass('has-error');
		$(".field-air-kopi span.help-block").text(error.air_kopiError);
	}
	else{
		$('.field-air-kopi').removeClass('has-error').addClass('has-success');
		$(".field-air-kopi span.help-block").text('');
	}

	// ayakan
	if(!jQuery.isEmptyObject(error.ayakanError)){
		$('.field-ayakan').removeClass('has-success').addClass('has-error');
		$(".field-ayakan span.help-block").text(error.ayakanError);
	}
	else{
		$('.field-ayakan').removeClass('has-error').addClass('has-success');
		$(".field-ayakan span.help-block").text('');
	}

	// kulit
	if(!jQuery.isEmptyObject(error.kulitError)){
		$('.field-kulit').removeClass('has-success').addClass('has-error');
		$(".field-kulit span.help-block").text(error.kulitError);
	}
	else{
		$('.field-kulit').removeClass('has-error').addClass('has-success');
		$(".field-kulit span.help-block").text('');
	}

	// rendemen
	if(!jQuery.isEmptyObject(error.rendemenError)){
		$('.field-rendemen').removeClass('has-success').addClass('has-error');
		$(".field-rendemen span.help-block").text(error.rendemenError);
	}
	else{
		$('.field-rendemen').removeClass('has-error').addClass('has-success');
		$(".field-rendemen span.help-block").text('');
	}
}

// function set error kir lada
function setError_kir_lada(error){
	// air lada
	if(!jQuery.isEmptyObject(error.air_ladaError)){
		$('.field-air-lada').removeClass('has-success').addClass('has-error');
		$(".field-air-lada span.help-block").text(error.air_ladaError);
	}
	else{
		$('.field-air-lada').removeClass('has-error').addClass('has-success');
		$(".field-air-lada span.help-block").text('');
	}

	// berat
	if(!jQuery.isEmptyObject(error.beratError)){
		$('.field-berat').removeClass('has-success').addClass('has-error');
		$(".field-berat span.help-block").text(error.beratError);
	}
	else{
		$('.field-berat').removeClass('has-error').addClass('has-success');
		$(".field-berat span.help-block").text('');
	}

	// abu
	if(!jQuery.isEmptyObject(error.abuError)){
		$('.field-abu').removeClass('has-success').addClass('has-error');
		$(".field-abu span.help-block").text(error.abuError);
	}
	else{
		$('.field-abu').removeClass('has-error').addClass('has-success');
		$(".field-abu span.help-block").text('');
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

// function set select supplier
function setSelect_supplier(){
	$.ajax({
		url: base_url+"app/controllers/Supplier.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_supplierUtama"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#supplier').append(option).trigger('change');
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
	var arrJenis = [
		{value: "", text: "-- Pilih Jenis Bahan Baku --"},
		{value: "K", text: "KOPI ASALAN"},
		{value: "L", text: "LADA HITAM ASALAN"},
	];

	$.each(arrJenis, function(index, item){
		var option = new Option(item.text, item.value);
		$("#jenis").append(option);
	});
}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status Kir --"},
		{value: "1", text: "SESUAI STANDAR"},
		{value: "0", text: "DIBAWAH STANDAR"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#status").append(option);
	});
}

// function set kode kir
function setKd_kir(jenis){
	$.ajax({
		url: base_url+"app/controllers/Kir.php",
		type: 'post',
		dataType: 'json',
		data: {
			'action': 'get_kd_kir',
			'jenis': $('#jenis').val().trim(),
		},
		success: function(data){
			console.log(data);
			var tanggal = getTanggal().replace(/-/g,"");

			// cek kode pada hari ini ada
			if(!data) $("#kd_kir").val('KIR-'+jenis+'-'+tanggal+'-1');
			else{
				iterasi = data['kd_kir'].split("-");
                count = parseInt(iterasi[3]) + 1;
                $("#kd_kir").val('KIR-'+jenis+'-'+tanggal+'-'+count.toString()).trigger('change');
			}

		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set field hitung kir sesuai jenis
function setField_kir(jenis){
	if(jenis == "K"){
		$('.kir-kopi').slideDown();
		$('.kir-lada').slideUp();

		// bersihkan form
		$('.kir-kopi input').val("");
		$('.kir-kopi').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
		$('.kir-kopi').find("span.pesan").text(""); // hapus semua span help-block
	}
	else{
		$('.kir-lada').slideDown();
		$('.kir-kopi').slideUp();

		// bersihkan form
		$('.kir-lada input').val("");
		$('.kir-lada').find("div.form-group").removeClass('has-error').removeClass('has-success'); // hapus class has-error/success
		$('.kir-lada').find("span.pesan").text(""); // hapus semua span help-block
	}

	$('#status').val("");
	$('.field-status').removeClass('has-error').removeClass('has-success');
	$(".field-status span.help-block").text('');
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
		$('.form-kir').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-kir').unblock();
}