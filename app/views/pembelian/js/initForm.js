var listPembelian = [];
var indexPembelian = 0;

$(document).ready(function(){
	$(".select2").select2();

	$('#tgl').datepicker({
        autoclose: true,
        format: "yyyy-mm-dd",
        todayHighlight: true,
        todayBtn: true,
        todayHighlight: true,
    });
	$('#tgl').datepicker('update',getTanggal());

	setInvoice();
    $("#invoice").prop("readonly", true);

    setSelect_supplier();
    setSelect_jenisPembayaran();
    setSelect_jenisPPH();
    setSelect_status();
    setSelect_bahan_baku();

    // tambah list barang
    $("#btnTambah_barang").click(function(e){
    	add_detail();
    });

    $("#form_pembelian").submit(function(e){
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

    	// invoice
    	$("#invoice").change(function(){
    		if(this.value !== ""){
    			$('.field-invoice').removeClass('has-error').addClass('has-success');
				$(".field-invoice span.help-block").text('');	
    		}
    	});

    	// supplier
    	$("#supplier").change(function(){
    		if(this.value !== ""){
    			$('.field-supplier').removeClass('has-error').addClass('has-success');
				$(".field-supplier span.help-block").text('');

				$("#analisa_harga").find('option').remove().end().trigger('change');
				setSelect_analisa_harga();
    		}
    	});

    	// jenis pembayaran
    	$("#jenis_pembayaran").change(function(){
    		if(this.value !== ""){
    			$('.field-jenis-pembayaran').removeClass('has-error').addClass('has-success');
				$(".field-jenis-pembayaran span.help-block").text('');
    		}
    	});

    	// jenis pph
    	$("#jenis_pph").change(function(){
    		if(this.value !== ""){
    			$('.field-jenis-pph').removeClass('has-error').addClass('has-success');
				$(".field-jenis-pph span.help-block").text('');
    		}
    	});

    	// keterangan
    	$("#ket").change(function(){
    		if(this.value !== ""){
    			$('.field-ket').removeClass('has-error').addClass('has-success');
				$(".field-ket span.help-block").text('');
    		}
    	});

    	// analisa harga
    	$("#analisa_harga").change(function(){
    		if(this.value !== ""){
    			$('.field-analisa-harga').removeClass('has-error').addClass('has-success');
				$(".field-analisa-harga span.help-block").text('');

				var harga = $("#analisa_harga option:selected").text().split(" - ");
				$("#harga").val(parseFloat(harga[1]));

				// get bahan baku
				// get_satuanBahanBaku($("#bahan_baku").val().trim());
    		}
    	});

    	// bahan baku
    	$("#bahan_baku").change(function(){
    		if(this.value !== ""){
    			$('.field-bahan-baku').removeClass('has-error').addClass('has-success');
				$(".field-bahan-baku span.help-block").text('');	
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

    	// harga beli
    	$("#harga_beli").change(function(){
    		if(this.value !== ""){
    			$('.field-harga-beli').removeClass('has-error').addClass('has-success');
				$(".field-harga-beli span.help-block").text('');	
    		}
    	});

    // ==================================

});

// function detail pembelian
	// function add detail
	function add_detail(){
		var index = indexPembelian++;
		var id_pembelian = $('#id_pembelian').val().trim();
		var invoice = $('#invoice').val().trim();
		var id_bahan_baku = $('#bahan_baku').val().trim();
		var nama_bahan_baku = $("#bahan_baku option:selected").text();
		var id_analisa_harga = $('#analisa_harga').val().trim();
		var colly = parseFloat($('#colly').val().trim());
		var jumlah = parseFloat($('#jumlah').val().trim());
		var harga_beli = parseFloat($('#harga').val().trim());
		var split_bahan_baku = $("#bahan_baku option:selected").text().split(" - ");
		var dataDetail = {
			aksi: "tambah", status: "", index: index,
			id: "", id_pembelian: id_pembelian, invoice: invoice,
			id_bahan_baku: id_bahan_baku, nama_bahan_baku: nama_bahan_baku,
			id_analisa_harga: id_analisa_harga, harga_beli: harga_beli,
			colly: colly, jumlah: jumlah, subtotal: "",
		};

		var subtotal = parseFloat((harga_beli*jumlah).toFixed(2));
		dataDetail.subtotal = subtotal;

		listPembelian.push(dataDetail);
		$("#tabel_detail_pembelian > tbody:last-child").append(
			"<tr>"+
				"<td></td>"+ // nomor
				"<td>"+nama_bahan_baku+"</td>"+ // barang
				"<td>"+fieldColly(colly, index)+"</td>"+ // colly
				"<td>"+fieldJumlah(jumlah, index)+"</td>"+ // jumlah
				"<td>"+fieldHargaBeli(harga_beli, index)+"</td>"+ // harga
				"<td>Rp. "+subtotal+"</td>"+ // subtotal
				"<td>"+btnAksi(index)+"</td>"+ // aksi
			"</tr>"
		);
		numberingList();
		clearDetail();
		console.log(listPembelian);
	}

	function numberingList(){
		$('#tabel_detail_pembelian tbody tr').each(function (index) {
	        $(this).children("td:eq(0)").html(index + 1);
	    });
	    $("#tampilPPH").text("PPH "+$("#jenis_pph").val()+" %: Rp. "+hitungPPH());
	    $("#tampilHarga").text("Sub Total: Rp. "+hitungTotal());
	    $("#tampilTotal").text("Total: Rp. "+parseFloat(hitungTotal()-hitungPPH()).toFixed(2));
	}

	function clearDetail(){

	}

	function hitungTotal(){
		var total = 0;

		$.each(listPembelian, function(i, item){
			// selain hapus lakukan perhitungan
			if(item.status !== "hapus") total += item.subtotal;
		});

		return total.toFixed(2);
	}

	function hitungPPH(){
		var total = parseFloat(hitungTotal());
		var pph = parseFloat($('#jenis_pph').val().trim());

		return (total*pph).toFixed(2);
	}

	function fieldColly(colly, index){
		var field = '<input type="number" min="0" onchange="onChange_colly('+index+',this)" class="form-control" value="'+colly+'">';
		return field;
	}

	function fieldJumlah(jumlah, index){
		var field = '<input type="number" min="1" onchange="onChange_jumlah('+index+',this)" class="form-control" value="'+jumlah+'">';
		return field;
	}

	function fieldHargaBeli(harga, index){
		var field = '<input type="number" min="0" onchange="onChange_hargaBeli('+index+',this)" class="form-control" value="'+harga+'">';
		return field;
	}

	function btnAksi(index){
		var btn = '<button type="button" class="btn btn-danger btn-sm bnt-flat" onclick="delList('+index+',this)" title="Hapus dari list">'+
		                    '<i class="fa fa-trash"></button>';
	    return btn;
	}

	function delList(index, val){
		$(val).parent().parent().remove(); // hapus data ditabel
		$.each(listPembelian, function(i, item){
			if(item.index == index) item.status = "hapus";
		});
		numberingList(); // reset ulang nomer
		console.log(listPembelian);
	}

	function onChange_colly(index, val){
		$.each(listPembelian, function(i, item){
			if(item.index == index){
				item.colly = val.value;
			} 
		});
		numberingList();
		console.log(listPembelian);
	}

	function onChange_jumlah(index, val){
		$.each(listPembelian, function(i, item){
			if(item.index == index){
				item.jumlah = val.value;
				// sesuaikan ulang sub total
				item.subtotal = (item.harga_beli*item.jumlah);
				$(val).parent().parent().children("td:eq(5)").html("Rp. "+item.subtotal+",00");	
			} 
			// console.log(item);
		});
		numberingList();
		console.log(listPembelian);
	}

	function onChange_hargaBeli(index, val){
		$.each(listPembelian, function(i, item){
			if(item.index == index){
				item.harga_beli = val.value;
				// sesuaikan ulang sub total
				item.subtotal = (item.harga_beli*item.jumlah);
				$(val).parent().parent().children("td:eq(5)").html("Rp. "+item.subtotal+",00");	
			} 
			// console.log(item);
		});
		numberingList();
		console.log(listPembelian);	
	}
// ====================================== //
	

// function get form
function getDataForm(){
	var data = new FormData();
	
	var dataPembelian = {
		id_pembelian: $("#id_pembelian").val().trim(),
		tgl: $("#tgl").val().trim(),
		invoice: $("#invoice").val().trim(),
		supplier: $("#supplier").val().trim(),
		status: $("#status").val().trim(),
		jenis_pembayaran: $("#jenis_pembayaran").val().trim(),
		jenis_pph: $("#jenis_pph").val().trim(),
		ket: $("#ket").val().trim(),
		pph: parseFloat(hitungPPH()),
		total: parseFloat(hitungTotal()),
		total_pph: parseFloat(hitungTotal()-hitungPPH()),
	};

	data.append('dataPembelian', JSON.stringify(dataPembelian)); // id
	data.append('dataDetail', JSON.stringify(listPembelian)); // tgl
	data.append('action', $("#btnSubmit_pembelian").val().trim()); // action

	return data;
}

// function submit
function submit(){
	var data = getDataForm();

	$.ajax({
		url: base_url+'app/controllers/Pembelian.php',
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
					if(!output.cekList){
						$.toast({
							heading: 'Pesan Error',
							text: 'Detail Pembelian Tidak Boleh Kosong',
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
					setError(output.setError);
				}
			}
			else{
				window.location.href = base_url+"index.php?m=pembelian&p=list";
			}
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
			setLoading(false);
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// // function reset form
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

// function setValue(value){
// 	var harga_basis = parseFloat(value.harga_basis) ? parseFloat(value.harga_basis) : value.harga_basis;

// 	$("#tgl").datepicker('update',value.tgl);
// 	$("#jenis").val(value.jenis).trigger('change');;
// 	$("#harga_basis").val(harga_basis).trigger('change');;
// 	$("#id_harga_basis").val(value.id).trigger('change');;
// }

// function set select supplier
function setSelect_supplier(){
	$.ajax({
		url: base_url+"app/controllers/Pembelian.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_supplier"},
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

// function set select bahan baku
function setSelect_bahan_baku(){
	$.ajax({
		url: base_url+"app/controllers/Pembelian.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_bahanbaku"},
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

function get_satuanBahanBaku(id){
	$.ajax({
		url: base_url+"app/controllers/Bahan_baku.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_satuan_bahanbaku", "id": id},
		success: function(data){
			$('.satuan').text(data);
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select analisa harga
function setSelect_analisa_harga(){
	$.ajax({
		url: base_url+"app/controllers/Pembelian.php",
		type: "post",
		dataType: "json",
		data: {
			"action": "get_select_analisa_harga",
			"id_supplier": $('#supplier').val().trim(),
		},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#analisa_harga').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

function setSelect_jenisPembayaran(){
	var arrJenisPembayaran = [
		{value: "", text: "-- Pilih Jenis Pembayaran --"},
		{value: "C", text: "CASH"},
		{value: "T", text: "TRANSFER"},
	];

	$.each(arrJenisPembayaran, function(index, item){
		var option = new Option(item.text, item.value);
		$("#jenis_pembayaran").append(option);
	});
}

function setSelect_jenisPPH(){
	var arrJenisPPH = [
		{value: "", text: "-- Pilih Jenis PPH --"},
		{value: 0.025, text: "0.025 %"},
		{value: 0.05, text: "0.05 %"},
	];

	$.each(arrJenisPPH, function(index, item){
		var option = new Option(item.text, item.value);
		$("#jenis_pph").append(option);
	});	
}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status --"},
		{value: "S", text: "LUNAS"},
		{value: "O", text: "TITIPAN"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#status").append(option);
	});
}

// function set kode pembelian
function setInvoice(jenis){
	$.ajax({
		url: base_url+"app/controllers/Pembelian.php",
		type: 'post',
		dataType: 'json',
		data: {'action': 'get_invoice_pembelian'},
		success: function(data){
			console.log(data);
			var tanggal = getTanggal().replace(/-/g,"");

			// cek kode pada hari ini ada
			if(!data) $("#invoice").val('PB-'+tanggal+'-1');
			else{
				iterasi = data['invoice'].split("-");
                count = parseInt(iterasi[2]) + 1;
                $("#invoice").val('PB-'+tanggal+'-'+count.toString()).trigger('change');
			}

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

// function loading modal
function setLoading(block=true){
	if(block === true){
		$('.form-pembelian').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.form-pembelian').unblock();
}