var listDetailPengiriman = [];
var indexDetailPengiriman = 0;

$(document).ready(function(){
	$(".select2").select2();

	$('#tgl').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });

	setSelect_kontrak();
	setSelect_kendaraan();
	setSelect_status();

	$("#btnRekomendasi").click(function(){
		if($("#kontrak").val() == ""){
			$('.field-kontrak').removeClass('has-success').addClass('has-error');
			$(".field-kontrak span.help-block").text("No. Kontrak Belum Diisi");

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
	});

	$("#btnTambah_pengiriman").click(function(){
		add_detailPengiriman();
	});

    $("#form_pengiriman").submit(function(e){
    	e.preventDefault();
    	submit();
    	return false;
    });

    // onchange field
		// no kontrak
    	$("#kontrak").change(function(){
    		if(this.value !== ""){
    			$('.field-kontrak').removeClass('has-error').addClass('has-success');
				$(".field-kontrak span.help-block").text('');

				// set info kontrak
				setInfo_kontrak(this.value);	
    		}
    		else resetInfo_kontrak();
    	});    	

    	// tgl
    	$("#tgl").change(function(){
    		if(this.value !== ""){
    			$('.field-tgl').removeClass('has-error').addClass('has-success');
				$(".field-tgl span.help-block").text('');	
    		}
    	});

    	// kendaraan
    	$("#kendaraan").change(function(){
    		if(this.value !== ""){
    			$('.field-kendaraan').removeClass('has-error').addClass('has-success');
				$(".field-kendaraan span.help-block").text('');	
    		}
    	});

    	// colly
    	$("#colly").change(function(){
    		if(this.value !== ""){
    			$('.field-colly').removeClass('has-error').addClass('has-success');
				$(".field-colly span.help-block").text('');	
    		}
    	});

    	// jumlah
    	$("#jumlah").change(function(){
    		if(this.value !== ""){
    			$('.field-jumlah').removeClass('has-error').addClass('has-success');
				$(".field-jumlah span.help-block").text('');	
    		}
    	});
    // ==================================

});

// function add pengiriman
function add_detailPengiriman(){
	var index = indexDetailPengiriman++;
	var id_pemesanan = $("#kontrak").val().trim();
	var tgl = $("#tgl").val().trim();
	var kendaraan = $("#kendaraan").val().trim();
	var nama_kendaraan = $("#kendaraan option:selected").text().split(' - ')[0];
	var colly = parseFloat($("#colly").val().trim());
	var jumlah = parseFloat($("#jumlah").val().trim());
	var status_pengiriman = $("#status").val().trim();
	var dataDetailPengiriman = {
		aksi: "tambah", status: "",
		index: index, id_pengiriman: "",
		id_pemesanan: id_pemesanan, tgl: tgl,
		kendaraan: kendaraan, colly: colly,
		jumlah: jumlah, status_pengiriman: status_pengiriman,
	};

	listDetailPengiriman.push(dataDetailPengiriman);
	$("#tabel_detail_pengiriman > tbody:last-child").append(
		"<tr>"+
			"<td></td>"+ // nomor
			"<td>"+tgl+"</td>"+ // tgl
			"<td>"+nama_kendaraan+"</td>"+ // kendaraan
			"<td>"+fieldColly(colly, index)+"</td>"+ // colly
			"<td>"+fieldJumlah(jumlah, index)+"</td>"+ // jumlah
			"<td>"+fieldStatus(status_pengiriman, index)+"</td>"+ // status
			"<td>"+btnAksi(index)+"</td>"+ // aksi
		"</tr>"
	);
	numberingList();
	console.log(dataDetailPengiriman);
	console.log(listDetailPengiriman);
}

function numberingList(){
	$('#tabel_detail_pengiriman tbody tr').each(function (index) {
        $(this).children("td:eq(0)").html(index + 1);
    });
}

function fieldColly(colly, index){
	var field = '<div class="input-group"><input type="number" min="0" step="any" onchange="onChange_colly('+index+',this)" class="form-control" value="'+colly+'"><span class="input-group-addon">PCS</span></div>';
	return field;
}

function fieldJumlah(jumlah, index){
	var field = '<div class="input-group"><input type="number" min="0" step="any" onchange="onChange_jumlah('+index+',this)" class="form-control" value="'+jumlah+'"><span class="input-group-addon">KG</span></div>';
	return field;
}

function fieldStatus(status, index){
	if(status == "P"){
		selectedP = "selected";
		selectedO = "";
		selectedT = "";
	}
	else if(status == "O"){
		selectedP = "";
		selectedO = "selected";
		selectedT = "";
	}
	else if(status == "T"){
		selectedP = "";
		selectedO = "";
		selectedT = "selected";
	} 

	var field = '<div class="input-group">'+
				'<select onchange="onChange_status('+index+', this)" class="form-control">'+
				'<option '+selectedP+' value="P">PROSES</option>'+
				'<option '+selectedO+' value="O">DALAM PERJALANAN</option>'+
				'<option '+selectedT+' value="T">TERKIRIM</option>'+
				'</select>';
	return field;
}

function btnAksi(index){
	var btn = '<button type="button" class="btn btn-danger btn-sm bnt-flat" onclick="delList('+index+',this)" title="Hapus dari list">'+
              '<i class="fa fa-trash"></button>';
    return btn;
}

// function get form
function getDataForm(){
	var data = new FormData();
	
	data.append('dataPengiriman', JSON.stringify(listDetailPengiriman)); // data pengiriman
	data.append('action', $("#btnSubmit_pengiriman").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Pengiriman.php',
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
					// setError(output.setError);
				}
			}
			else{
				window.location.href = base_url+"index.php?m=pengiriman&p=list";
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
	// no kontrak
	if(!jQuery.isEmptyObject(error.kontrakError)){
		$('.field-kontrak').removeClass('has-success').addClass('has-error');
		$(".field-kontrak span.help-block").text(error.kontrakError);
	}
	else{
		$('.field-kontrak').removeClass('has-error').addClass('has-success');
		$(".field-kontrak span.help-block").text('');	
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
	// kendaraan
	if(!jQuery.isEmptyObject(error.kendaraanError)){
		$('.field-kendaraan').removeClass('has-success').addClass('has-error');
		$(".field-kendaraan span.help-block").text(error.kendaraanError);
	}
	else{
		$('.field-kendaraan').removeClass('has-error').addClass('has-success');
		$(".field-kendaraan span.help-block").text('');	
	}
	// colly
	if(!jQuery.isEmptyObject(error.collyError)){
		$('.field-colly').removeClass('has-success').addClass('has-error');
		$(".field-colly span.help-block").text(error.collyError);
	}
	else{
		$('.field-colly').removeClass('has-error').addClass('has-success');
		$(".field-colly span.help-block").text('');	
	}
	// jumlah
	if(!jQuery.isEmptyObject(error.jumlahError)){
		$('.field-jumlah').removeClass('has-success').addClass('has-error');
		$(".field-jumlah span.help-block").text(error.jumlahError);
	}
	else{
		$('.field-jumlah').removeClass('has-error').addClass('has-success');
		$(".field-jumlah span.help-block").text('');	
	}
}

// function setValue(value){
// 	var harga_basis = parseFloat(value.harga_basis) ? parseFloat(value.harga_basis) : value.harga_basis;

// 	$("#tgl").datepicker('update',value.tgl);
// 	$("#jenis").val(value.jenis).trigger('change');;
// 	$("#harga_basis").val(harga_basis).trigger('change');;
// 	$("#id_harga_basis").val(value.id).trigger('change');;
// }

// function set info kontrak
function setInfo_kontrak(kontrak){
	$.ajax({
		url: base_url+"app/controllers/Pengiriman.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_info_kontrak", "no_kontrak": kontrak},
		success: function(data){
			console.log(data);
			// reset info
			resetInfo_kontrak();
			// set info
			setValue_infoKontrak(data);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function resetInfo_kontrak(){
	$('#info_buyer').text('Info Buyer');
	$('#info_alamat').text('Info Alamat');
	$('#info_produk').text('Info Produk');
	$('#info_jumlah').text('Info Jumlah');
	$('#info_waktu_pengiriman').text('Info Waktu Pengiriman');
}

function setValue_infoKontrak(value){
	$('#info_buyer').text(value.nama_buyer);
	$('#info_alamat').text(value.alamat);
	$('#info_produk').text(value.produk);
	$('#info_jumlah').text(value.jumlah+" "+value.satuan);
	$('#info_waktu_pengiriman').text(value.waktu+" ("+value.jumlah_hari+")");
}

// function set select kontrak
function setSelect_kontrak(){
	$.ajax({
		url: base_url+"app/controllers/Pengiriman.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_kontrak"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#kontrak').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select kendaraan
function setSelect_kendaraan(){
	$.ajax({
		url: base_url+"app/controllers/Pengiriman.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_kendaraan"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#kendaraan').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status --"},
		{value: "P", text: "PROSES"},
		{value: "O", text: "DALAM PERJALANAN"},
		{value: "T", text: "TERKIRIM"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#status").append(option);
	});
}

// function loading modal
function setLoading(block=true){
	if(block === true){
		$('.form-pengiriman').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-pengiriman').unblock();
}