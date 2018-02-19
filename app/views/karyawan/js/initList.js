$(document).ready(function(){
    if(notif == "gagal") {
        $.toast({
            heading: 'Pesan Error',
            text: 'Data Tidak Ditemukan',
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'error',
            hideAfter: 3000,
            stack: 6
        });
    }
    else if(notif != false) {
        $.toast({
            heading: 'Pesan Berhasil',
            text: notif,
            position: 'top-right',
            loaderBg: '#ff6849',
            icon: 'success',
            hideAfter: 3000,
            stack: 6
        });
    };

	// setting datatable
    var tabel_karyawan = $("#tabel_karyawan").DataTable({
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
            url: base_url+"app/controllers/Karyawan.php",
            type: 'POST',
            data: {
                "action" : "list",
            }
        },
        "columnDefs": [
            {
                "targets":[0, 6], // disable order di kolom 1 dan 3
                "orderable":false,
            }
        ],
    });

    $("#tambah_karyawan").click(function(){
        window.location.href = base_url+"index.php?m=karyawan&p=form";
    });

    $("#form_ubah_status").submit(function(e){
        e.preventDefault();
        updateStatus();
        return false;
    });    

    setSelect_status();

    $("#exportPdf").click(function(){
        createPDF();
    });
});

function getEdit(id){
    window.location.href = base_url+"index.php?m=karyawan&p=form&id="+id;
}

function getView(id){
    window.location.href = base_url+"index.php?m=karyawan&p=view&id="+id;
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
            url: base_url+"app/controllers/Karyawan.php",
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
                    $("#tabel_karyawan").DataTable().ajax.reload();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) { // error handling
                swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
                console.log(jqXHR, textStatus, errorThrown);
            }
        })   
    });
}

function getStatus(id){
    // tampilkan modal
    $("#modal_ubah_status").modal();
    $("#id_karyawan").val(id);
    // get status
    $.ajax({
        url: base_url+"app/controllers/Karyawan.php",
        type: "post",
        dataType: "json",
        data: {
            "id": id,
            "action": "get_status",
        },
        success: function(output){
            console.log(output);
            $("#status").val(output).trigger('change');
        },
        error: function (jqXHR, textStatus, errorThrown) { // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_ubah_status").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
    })
}

function updateStatus(){
     $.ajax({
        url: base_url+"app/controllers/Karyawan.php",
        type: "post",
        dataType: "json",
        data: {
            "status": $("#status").val(),
            "id": $("#id_karyawan").val(),
            "action": "update_status",
        },
        success: function(output){
            console.log(output);
            if(output.status){
                $("#tabel_karyawan").DataTable().ajax.reload();
                $("#modal_ubah_status").modal('hide');
                $.toast({
                    heading: 'Pesan Berhasil',
                    text: output.pesan,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'success',
                    hideAfter: 3000,
                    stack: 6
                });
            }
            else{
                $.toast({
                    heading: 'Pesan Error',
                    text: output.pesan,
                    position: 'top-right',
                    loaderBg: '#ff6849',
                    icon: 'error',
                    hideAfter: 3000,
                    stack: 6
                });
            }
        },
        error: function (jqXHR, textStatus, errorThrown) { // error handling
            swal("Pesan Error", "Operasi Gagal, Silahkan Coba Lagi", "error");
            $("#modal_ubah_status").modal('hide');
            console.log(jqXHR, textStatus, errorThrown);
        }
    })
}

function setSelect_status(){
    var arrStatus = [
        {value: "1", text: "AKTIF"},
        {value: "0", text: "NON-AKTIF"},
    ];

    $.each(arrStatus, function(index, item){
        var option = new Option(item.text, item.value);
        $("#status").append(option);
    });
}

// function export pdf
    function createPDF(){
        getDataPDF(function(data){
            var doc = new jsPDF('l');
            var totalPagesExp = "{total_pages_count_string}";

            var pageContent = function(data_){
                // header
                doc.setFontSize(14);
                doc.setTextColor(40);
                doc.setFontStyle('normal');
                doc.text("Data Karyawan", data_.settings.margin.left, 22);

                // footer
                var str = "Page " + data_.pageCount;
                if (typeof doc.putTotalPages === 'function') {
                    str = str + " of " + totalPagesExp;
                }
                doc.setFontSize(10);
                doc.text(str, data_.settings.margin.left, doc.internal.pageSize.height - 10);
            };

            doc.autoTable(data.columns, data.rows, {
                addPageContent: pageContent,
                margin: {top: 30, horizontal: 10},
                styles: {overflow: 'linebreak', columnWidth: 'wrap'},
                columnStyles: {text: {columnWidth: 'auto'}}
            });

            if (typeof doc.putTotalPages === 'function') {
                doc.putTotalPages(totalPagesExp);
            }

            doc.save('data_karyawan.pdf');
        });
    }

    function getDataPDF(handleData){
        // pecah var data menjadi kolom dan basris
        $.ajax({
            url: base_url+"app/controllers/Karyawan.php",
            type: "post",
            dataType: "json",
            data: {
                "action": "getPdf",
            },
            beforeSend: function(){
                $.blockUI({
                    message: '<h4><img src="'+base_url+'assets/plugins/images/busy.gif" /> Mohon Menunggu...</h4>',
                    css: {
                        border: '1px solid #fff'
                    }
                });
            },
            success: function(data){
                $.unblockUI();
                handleData(data);
            },
            error: function (jqXHR, textStatus, errorThrown){
                console.log(jqXHR, textStatus, errorThrown);
            }
        })
    }
// ====================================
    

