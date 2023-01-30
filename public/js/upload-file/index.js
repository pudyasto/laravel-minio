
$(function () {
    $(".btn-refresh").click(function () {
        tableMain.ajax.reload();
    });

    tableMain = $('#tableMain').DataTable({
        bProcessing: true,
        bServerSide: true,
        columns: [
            { "data": "name", },
            { "data": "description", },
            { "data": "mime", },
            {
                "data": "size",
                render: function (data, type, row) {
                    return numeral(data).format('0b');
                }
            },
            { "data": "btn", "orderable": false }
        ],
        order: [
            [1, "asc"],
        ],
        pagingType: 'numbers',
        ajax: {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
                if (tableMain.hasOwnProperty('settings')) {
                    tableMain.settings()[0].jqXHR.abort();
                }
            },
            url: base_url('upload-file/tableMain'),
            method: 'POST'
        },
        sDom: "<'row'<'col-sm-5 mb-0' l ><'col-sm-7 mb-0 text-end' f> r> t <'row'<'col-sm-6 mb-0' i><'col-sm-6 mb-0 text-end' p>> ",
        oLanguage: {
            "sSearch": "",
            "sLengthMenu": "_MENU_",
            "sZeroRecords": "Tidak ada data",
            "sProcessing": "Silahkan Tunggu",
            "sInfo": "_START_ - _END_ / _TOTAL_",
            "sInfoFiltered": "",
            "sInfoEmpty": "0 - 0 / 0",
            "infoFiltered": "(_MAX_)",
        }
    });
});


function deleteData(id) {
    Swal.fire({
        title: "Konfirmasi Hapus",
        text: "Data yang dihapus, tidak dapat dikembalikan!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#c9302c",
        confirmButtonText: "Ya, Lanjutkan",
        cancelButtonText: "Tidak, Batalkan"
    }).then((result) => {
        if (result.value) {
            $.ajax({
                type: "DELETE",
                url: base_url('upload-file/destroy'),
                data: {
                    "id": id
                    , "stat": "delete"
                    , '_token': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (obj) {

                    if (obj.metadata.code === 200) {
                        tableMain.ajax.reload();
                        Swal.fire(obj.metadata.message, 'Berhasil', 'success');
                    } else {
                        Swal.fire(obj.metadata.message, 'Kesalahan', 'error');
                    }
                },
                error: function (event, textStatus, errorThrown) {
                    console.log(event, errorThrown);
                }
            });
        }
    });
}