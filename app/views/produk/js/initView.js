$(document).ready(function(){

});

// function get view
function getView(id){
	// $.ajax({
	// 	url: base_url+'app/controllers/Supplier.php',
	// 	type: 'post',
	// 	dataType: 'json',
	// 	data: {"id": id, "action": "getView"},
	// 	beforeSend: function(){
	// 		setLoading();
	// 	},
	// 	success: function(data){
	// 		if(data){
	// 			console.log(data);
	// 			setLoading(false);
	// 			// if(data.status==='1'){
	// 			// 	$("#supplier_utama option").prop("disabled", false);
	// 			// 	$('#supplier_utama option[value="'+data.supplier_utama+'"]').prop("disabled", true);
	// 			// }
	// 			// else $("#supplier_utama option").prop("disabled", false);

	// 			// setValue(data);
	// 		}
	// 		else{
	// 			swal("Pesan Error", "Data Yang Anda Minta Tidak Tersedia", "warning");
	// 		}
				
	// 	},
	// 	error: function (jqXHR, textStatus, errorThrown){ // error handling
 //            setLoading;
 //            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
 //            $("#modal_v_supplier").modal('hide');
 //            console.log(jqXHR, textStatus, errorThrown);
 //        }
	// })


	$("#modal_v_supplier").modal();
}
