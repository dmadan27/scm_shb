$(document).ready(function(){
	var tabel_supplier_pengganti = $("#tabel_supplier_pengganti").DataTable({
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
        "lengthMenu": [ 5, 10, 25, 100 ],
        "pageLength": 5,
        order: [],
        processing: true,
        serverSide: true,
        ajax: {
            url: base_url+"app/controllers/Supplier.php",
            type: 'POST',
            data: {
                "action" : "listPengganti",
                "id" : urlParams.id,
            }
        },
        "columnDefs": [
            {
                "targets":[0],
                "orderable":false,
            }
        ],
    });
});
