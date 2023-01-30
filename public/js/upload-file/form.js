$(function () {
    $(".btn-submit").click(function () {
        submit();
    });
});

function submit() {
    $("#form_default").ajaxForm({
        type: $("#form_default").attr('method'),
        url: $("#form_default").attr('action'),
        data: {
            "request": true
        },
        beforeSend: function (result) {

        },
        success: function (obj) {

            if (obj.metadata.code === 200) {
                Swal.fire(obj.metadata.message, 'Berhasil', 'success').then((result) => {
                    var myModalEl = document.getElementById('form-modal')
                    var modal = bootstrap.Modal.getInstance(myModalEl)
                    modal.hide();
                    $(".btn-refresh").click();
                });
            } else {
                Swal.fire(obj.metadata.message, 'Kesalahan', 'error');
            }

        },
        error: function (event, textStatus, errorThrown) {
            console.log(event, textStatus);
        }
    });
}