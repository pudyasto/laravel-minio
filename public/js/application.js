tableMain = '';
var myModalEl = document.getElementById('form-modal')
myModalEl.addEventListener('show.bs.modal', function (event) {
    // do something...
    var button = $(event.relatedTarget);
    var title = button.data('title');
    var action_url = button.data('action-url');
    var post_id = button.data('post-id');
    var width = button.data('width');
    if (width) {
        $(".modal-dialog").css("min-width", width);
    } else {
        $(".modal-dialog").css("min-width", "");
    }
    if (action_url !== undefined) {
        $.ajax({
            type: "GET",
            url: base_url(action_url),
            data: { "id": post_id },
            beforeSend: function () {
                $("#form-modal-content").html('');
            },
            success: function (resp) {
                $("#form-modal-content").html(resp);
            },
            error: function (event, textStatus, errorThrown) {
                console.log(event, errorThrown);
            }
        });
        var modal = $(this);
        modal.find('.modal-title').text(title);
    }
})
myModalEl.addEventListener('show.bs.modal', function (event) {
    $(".modal-dialog").css("min-width", "");
    $("#form-modal-content").html("");
})
// $('#form-modal').on('show.bs.modal', function (event) {

// });

// $('#form-modal').on('hidden.bs.modal', function () {
//     $(".modal-dialog").css("min-width", "");
//     $("#form-modal-content").html("");
// });

function isJson(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

function printElement(element) {
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write(document.getElementById(element).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}