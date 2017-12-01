$(document).ready(function(){
	$(".select2").select2();

	setSelect_status();
	setSelect_jenis();
	setSelect_hak_akses();

	$("#tambah_user").click(function(){
    	// bersihkan modal dan tampilkan modal
    	setLoading(false);
    	resetForm();
    	$("#labelModalUser").text("Form Tambah Data User");
    	$("#btnSubmit_user").prop("value", "tambah");
    	$("#btnSubmit_user").text("Tambah");
    	$("#modal_user").modal();
    });

    // onchange field
    	$("#jenis").change(function(){
    		if(this.value !== ""){
    			$('.field-jenis').removeClass('has-error').addClass('has-success');
				$(".field-jenis span.help-block").text('');

				setSelect_pengguna();
    		}
    		else{
    			$("#pengguna").find('option')
				        .remove()
				        .end()
				        .append($('<option>',{
				            value: "", 
				            text: "-- Pilih Pengguna --"
				        })).trigger('change');
    		}   		
    	});

    	$("#hak_akses").change(function(){
    		if(this.value !== ""){
    			$('.field-hak-akses').removeClass('has-error').addClass('has-success');
				$(".field-hak-akses span.help-block").text('');
    		}
    	});
    // ===================================== //
});

function resetForm(){

}

// function set select status
function setSelect_status(){
	var arrStatus = [
		{value: "", text: "-- Pilih Status User --"},
		{value: "1", text: "AKTIF"},
		{value: "0", text: "NON-AKTIF"},
	];

	$.each(arrStatus, function(index, item){
		var option = new Option(item.text, item.value);
		$("#status").append(option);
	});

	$("#status").prop('disabled', true);
	$('#status option[value=1]').attr('selected','selected');
}

// function set select jenis
function setSelect_jenis(){
	var arrJenis = [
		{value: "", text: "-- Pilih Jenis User --"},
		{value: "K", text: "KARYAWAN"},
		{value: "B", text: "BUYER"},
	];

	$.each(arrJenis, function(index, item){
		var option = new Option(item.text, item.value);
		$("#jenis").append(option);
	});
}

// function set select pengguna
function setSelect_pengguna(){
	var url = action = "";

	if($("#jenis").val() == "K"){
		url = base_url+"app/controllers/Karyawan.php";
		action = "get_select_karyawan";
	}
	else if($("#jenis").val() == "B"){
		url = base_url+"app/controllers/Buyer.php";
		action = "get_select_buyer";
	}

	$("#pengguna").find('option').remove().end();

	$.ajax({
		url: url,
		type: "post",
		dataType: "json",
		data: {"action": action},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#pengguna').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        }
	})
}

// function set select hak akses
function setSelect_hak_akses(){
	$.ajax({
		url: base_url+"app/controllers/User.php",
		type: "post",
		dataType: "json",
		data: {"action": "get_select_hak_akses"},
		success: function(data){
			console.log(data);
			$.each(data, function(index, item){
				var option = new Option(item.text, item.value);
				$('#hak_akses').append(option).trigger('change');
			});
		},
		error: function (jqXHR, textStatus, errorThrown){ // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            console.log(jqXHR, textStatus, errorThrown);
        } 
	})
}

// function loading modal
function setLoading(block=true){
	if(block === true){
		$('.modal-content').block({
    		message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
            css: {
                border: '1px solid #fff'
            }
    	});
	}
	else $('.modal-content').unblock();
}