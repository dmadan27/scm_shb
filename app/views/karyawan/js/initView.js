$(document).ready(function(){
	$('.dropify').dropify({
		"defaultFile": base_url+"assets/images/default.jpg",
	});

	// button edit data
	$('#btnEdit_data').click(function(){
		window.location.href = base_url+"index.php?m=karyawan&p=form&id="+urlParams.id;
	});

	// button edit foto
	$('#btnEdit_foto').click(function(){
		$("#modal_editFoto").modal();
	});

	// button kembali
	$('#btnKembali').click(function(){
		window.location.href = base_url+"index.php?m=karyawan&p=list";
	});
});