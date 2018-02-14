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

	$("#btnHitung_harga").click(function(e){
		getData_kir($("#kd_kir").val(), true);
	});

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
				reset_kir();
				getData_kir(this.value);
    		}
    		else reset_kir();
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

	data.append('id_analisa_harga', $('#id_analisa_harga').val().trim()); // dataProduk
	data.append('tgl', $('#tgl').val().trim()); // dataKomposisi
	data.append('id_basis', $('#id_basis').val().trim()); // dataKomposisi
	data.append('harga_basis', parseFloat($('#harga_basis').val().trim())); // dataKomposisi
	data.append('kd_kir', $('#kd_kir').val().trim()); // dataKomposisi
	data.append('harga_beli', parseFloat($('#harga_beli').val().trim())); // dataKomposisi
	data.append('action', $("#btnSubmit_analisa_harga").val().trim()); // stok

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	console.log(data);

	$.ajax({
		url: base_url+'app/controllers/Analisa_harga.php',
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
					// setValue(output.setValue);
					setError(output.setError);
				}
			}
			else window.location.href = base_url+"index.php?m=analisa_harga&p=list";
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

// function set error
function setError(error){
	// tanggal
	if(!jQuery.isEmptyObject(error.tglError)){
		$('.field-tgl').removeClass('has-success').addClass('has-error');
		$(".field-tgl span.help-block").text(error.tglkError);
	}
	else{
		$('.field-tgl').removeClass('has-error').addClass('has-success');
		$(".field-tgl span.help-block").text('');
	}

	// id basis
	if(!jQuery.isEmptyObject(error.id_basisError)){
		$('.field-id-basis').removeClass('has-success').addClass('has-error');
		$(".field-id-basis span.help-block").text(error.id_basisError);
	}
	else{
		$('.field-id-basis').removeClass('has-error').addClass('has-success');
		$(".field-id-basis span.help-block").text('');
	}

	// harga basis
	if(!jQuery.isEmptyObject(error.harga_basisError)){
		$('.field-harga-basis').removeClass('has-success').addClass('has-error');
		$(".field-harga-basis span.help-block").text(error.harga_basisError);
	}
	else{
		$('.field-harga-basis').removeClass('has-error').addClass('has-success');
		$(".field-harga-basis span.help-block").text('');
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

	// harga beli
	if(!jQuery.isEmptyObject(error.harga_beliError)){
		$('.field-harga-beli').removeClass('has-success').addClass('has-error');
		$(".field-harga-beli span.help-block").text(error.harga_beliError);
	}
	else{
		$('.field-harga-beli').removeClass('has-error').addClass('has-success');
		$(".field-harga-beli span.help-block").text('');
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

// Function Hitung Analisa Harga //
	// function get data kir
	function getData_kir(idKir, hitung=false){
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
				if(!hitung){
					// tampilkan supplier
					var info_supplier = data.supplier.npwp+' - '+data.supplier.nama_supplier;

					if(!data.supplier.npwp){ // jika nik kosong
						// jika npwp ada
						info_supplier = (data.supplier.nik) ? data.supplier.nik+' (NIK) - '+data.supplier.nama_supplier : data.supplier.nama_supplier;
					}

					$('.kir-supplier').slideDown();
					$('#info_supplier').text(info_supplier);

					// cek jenis
					if(data.jenis == "K"){
						// tampilkan data kir kopi
						setData_kir_kopi(data.dataKir);
					}
					else{
						// tampilkan data kir lada
						setData_kir_lada(data.dataKir);
					}
				}
				else{
					hitung_analisa_harga(data.jenis, data.dataKir);
				}	
			},
			error: function (jqXHR, textStatus, errorThrown){ // error handling
	            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
	            console.log(jqXHR, textStatus, errorThrown);
	        }
		})	
	}

	// function setData_kir
	function setData_kir_kopi(dataKir){
		$('.kir-kopi').slideDown();

		// info kir
		$('#info_trase').text(parseFloat(dataKir.trase)+" Gr");
		$('#info_gelondong').text(parseFloat(dataKir.gelondong)+" Gr");
		$('#info_air_kopi').text(parseFloat(dataKir.air)+ " %");
		$('#info_ayakan').text(parseFloat(dataKir.ayakan)+ " Gr");
		$('#info_kulit').text(parseFloat(dataKir.kulit)+ " Gr");
		$('#info_rendemen').text(parseFloat(dataKir.rendemen)+" %");

		// analisa harga
		$('.analisa-kopi').slideDown();
	}

	function setData_kir_lada(dataKir){
		$('.kir-lada').slideDown();

		// info kir
		$('#info_air_lada').text(dataKir.air);
		$('#info_berat').text(dataKir.berat);
		$('#info_abu').text(dataKir.abu);

		// analisa harga
		$('.analisa-lada').slideDown();
	}

	function reset_kir(){
		// reset supplier
		$('.kir-supplier').slideUp();
		$('#info_supplier').text("");

		// reset kir kopi
		$('.kir-kopi').slideUp();
		$('#info_trase').text("");
		$('#info_gelondong').text("");
		$('#info_air_kopi').text("");
		$('#info_ayakan').text("");
		$('#info_kulit').text("");
		$('#info_rendemen').text("");

		// reset analisa kopi
		$('.analisa-kopi').slideUp();
		$('#kalkulasi_rendemen').text("");

		// reset kir lada
		$('.kir-lada').slideUp();
		$('#info_air_lada').text("");
		$('#info_berat').text("");
		$('#info_abu').text("");

		// reset analisa lada
		$('.analisa-lada').slideUp();
		$('#kalkulasi_air_abu').text("");
		$('#kalkulasi_berat').text("");

		$('#harga_beli').val("");
	}

	function hitung_analisa_harga(jenisKir, dataKir){
		var harga = 0;

		if(jenisKir == "K"){ // kopi
			harga = parseFloat($("#harga_basis").val())*parseFloat(dataKir.rendemen)/100;
			$("#kalkulasi_rendemen").text($("#harga_basis").val()+" x "+parseFloat(dataKir.rendemen)+"%");
			$("#harga_beli").val(parseFloat(harga).toFixed(2));
		}
		else{ // lada
			// hitung kalkulasi air-abu
			var kalkulasi_air_abu = hitung_air_abu(parseFloat(dataKir.air), parseFloat(dataKir.abu));
			console.log("Kalkulasi Air Abu: "+kalkulasi_air_abu);

			// hitung kalkulasi berat
			var kalkulasi_berat = hitung_berat(parseFloat(dataKir.berat));
			console.log("Kalkulasi Berat: "+kalkulasi_berat);
			console.log("Harga Beli Lada: "+hitung_harga_lada(parseFloat($("#harga_basis").val()), kalkulasi_air_abu, kalkulasi_berat));
			// hitung harga
			harga = hitung_harga_lada(parseFloat($("#harga_basis").val()), kalkulasi_air_abu, kalkulasi_berat);
			
			$('#kalkulasi_air_abu').text(kalkulasi_air_abu);
			$('#kalkulasi_berat').text(kalkulasi_berat);
			$("#harga_beli").val(parseFloat(harga).toFixed(2));
		}
		// console.log(dataKir);
	}

	function hitung_air_abu(air, abu){
		return ((23)-(air+abu)).toFixed(2);
	}

	function hitung_berat(berat){
		var temp;
		var temp_2;
		var temp_berat;

		//jika berat diatas > 1600
		if (berat>1600){
			//cek range
			if((berat>1600) && (berat<=1650)){
				temp=berat-1600;
				temp_2=10;
				temp_berat=temp*temp_2;
			}
			else if((berat>1650) && (berat<=1700)){
				temp=berat-1650;
				temp_2=5;
				temp_berat=temp*temp_2;
				temp_berat+=500;
			}
			else if((berat>1700) && (berat<=1750)){
				temp=berat-1700;
				temp_2=5;
				temp_berat=temp*temp_2;
				temp_berat+=750;
			}
		}
		//jika berat dibawah < 1600
		else if(berat<1600){
			//cek range
			if((berat<1600) && (berat>=1500))
			{
				temp=1600-berat;
				temp_2=-5;
				temp_berat=temp*temp_2;
			}
			else if((berat<1500) && (berat>=1400)){
				temp=1500-berat;
				temp_2=-10;
				temp_berat=temp*temp_2;
				temp_berat+=-500;
			}
			else if((berat<1400) && (berat>=1200)){
				temp=1400-berat;
				temp_2=-12.5;
				temp_berat=temp*temp_2;
				temp_berat+=-1500;
			}
		}
		else //1600 pas, berarti tidak ada penambahan
			temp_berat=0;

		return temp_berat;
	}

	function hitung_harga_lada(basis, kalkulasi_air_abu, kalkulasi_berat){
		//jika air+ berat+
		if((kalkulasi_air_abu>=0) && (kalkulasi_berat>=0)){
			return ((parseFloat(basis)+(parseFloat(basis)*kalkulasi_air_abu/100))+kalkulasi_berat).toFixed(2);
		}
		//jika air+ berat-
		else if((kalkulasi_air_abu>=0) && (kalkulasi_berat<0)){
			return ((parseFloat(basis)+kalkulasi_berat)+((parseFloat(basis)+kalkulasi_berat)*kalkulasi_air_abu/100)).toFixed(2);	
		}
		//jika air- berat+
		else if((kalkulasi_air_abu<0) && (kalkulasi_berat>=0)){
			return ((parseFloat(basis)+(parseFloat(basis)*kalkulasi_air_abu/100))+kalkulasi_berat).toFixed(2);
		}
		//jika air- berat-
		else if((kalkulasi_air_abu<0) && (kalkulasi_berat<0)){
			return ((parseFloat(basis)+(parseFloat(basis)*kalkulasi_air_abu/100))+kalkulasi_berat).toFixed(2);
		}
	}
// ============================================== //

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