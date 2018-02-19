$(document).ready(function(){
	// setting datatable
    var tabel_kendaraan = $("#tabel_kendaraan").DataTable({
        "language" : {
            "lengthMenu": "Tampilkan _MENU_ data/page",
            "zeroRecords": "Data Tidak Ada",
            "info": "Menampilkan _START_ s.d _END_ dari _TOTAL_ data",
            "infoEmpty": "Menampilkan 0 s.d 0 dari 0 data",
            "search": "Pencarian:",
            "loadingRecords": "Loading...",
            "processing": "Processing...",
            "paginate": {
                "first": "Pertama",
                "last": "Terakhir",
                "next": "Selanjutnya",
                "previous": "Sebelumnya"
            }
        },
        "lengthMenu": [ 25, 50, 75, 100 ],
        "pageLength": 25,
        order: [],
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+"app/controllers/Kendaraan.php",
            type: 'POST',
            data: {
                "action" : "list",
            }
        },
        "columnDefs": [
            {
                "targets":[0, 8], // disable order di kolom 1 dan 3
                "orderable":false,
            }
        ],
    });
});

function getView(id){
    window.location.href = base_url+"index.php?m=kendaraan&p=view&id="+id;
}

function getHapus(id){
    swal({
        title: "Pesan Konfirmasi",
        text: "Apakah Anda Yakin Akan Menghapus Data Ini!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal",
        closeOnConfirm: false,
    }, function(){
        $.ajax({
            url: base_url+"app/controllers/Kendaraan.php",
            type: "post",
            dataType: "json",
            data: {
                "id": id,
                "action": "gethapus",
            },
            success: function(output){
                console.log(output);
                if(output){
                    swal("Pesan Berhasil", "Data Berhasil Dihapus", "success");
                    $("#tabel_kendaraan").DataTable().ajax.reload();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { // error handling
                swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
                console.log(jqXHR, textStatus, errorThrown);
            }
        })   
    });
}