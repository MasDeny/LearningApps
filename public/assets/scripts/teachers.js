var url = $('body').attr('data-url');

function loadPagination(pagno) {
    $.ajax({
        url: url + '/profile/guru/' + pagno,
        type: 'get',
        dataType: 'json',
        success: function (response) {
            $("#pagination_link").html(response.message.pagination);

            show_table(response.message.result);
        },
        error: function (t) {
            console.log(t.responseText);
        }
    });
}

$(document).ready(function () {

    loadPagination(1);

});

function show_table(response) {
    var trHTML = '';
    $.each(response, function (i, item) {

        var status = item.status == "active" ? "badge-success" : "badge-danger"
        trHTML += '<tr>' +
            '<td class="text-center text-muted">' + item.numberIdentity + '</td>' +
            '<td class="text-center">' +
            '<div class="widget-content p-0">' +
            '<div class="widget-content-wrapper">' +
            '<div class="widget-content-left flex2">' +
            '<div class="widget-heading">' + item.fullname + '</div>' +
            '<div class="widget-subheading opacity-7">' + item.position +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</td>' +
            '<td class="text-center">' + item.gender + '</td>' +
            '<td class="text-center">' + item.bornOfDate + '</td>' +
            '<td class="text-center">' + item.phone + '</td>' +
            '<td class="text-center">' +
            '<div class="badge ' + status + '">' + item.status + '</div>' +
            '</td>' +
            '<td class="text-center">' +
            '<button type="button" id="btn-details" class="btn btn-primary btn-sm" data-field="' + item.id + '" data-toggle="modal" data-target=".bd-example-modal-lg">' +
            '<i class="pe-7s-info">' +
            '</i></button>' +
            '<a type="button" id="btn-edit" class="btn btn-success btn-sm ml-1" data-field="' + item.id + '" data-toggle="modal" data-target=".bd-edit-modal-lg" data-toggle="tooltip" data-placement="top" title="Edit Siswa">' +
            '<i class="pe-7s-pen text-light">' +
            '</i></a>' +
            '<button type="button" id="btn-remove" class="btn btn-danger btn-sm ml-1" data-id="' + item.id + '" data-status="' + item.status + '">' +
            '<i class="pe-7s-trash">' +
            '</i></button>' +
            '</td>' +
            '</tr>';
    });
    $('#table_view').html(trHTML);
}


$(document).on("click", "#btn-details", function (event) {
    $.ajax({
        url: url + '/profile/guru/?id=' + $(this).attr('data-field'),
        type: 'get',
        dataType: 'json',
        success: function (response) {
            modal_detail(response.message)
        },
        error: function (t) {
            console.log(t);
        }
    });
});

function modal_detail(response) {
    var photo = response.profilePhoto === 'http://localhost/learning/public/' ? 'http://localhost/learning/public/upload/profile/default.jpg' : response.profilePhoto;

    $('#username-view').text(response.username)
    $('#email-view').text(response.email)
    $('#identity-view').text(response.numberIdentity)
    $('#fullname-view').text(response.fullname)
    $('#position-view').text(response.position)
    $('#bod-view').text(response.bornOfDate)
    $('#gender-view').text(response.gender)
    $('#religion-view').text(response.religion)
    $('#address-view').text(response.address.address)
    $('#city-view').text(response.address.city)
    $('#state-view').text(response.address.state)
    $('#zip-view').text(response.address.zip)
    $('#phone-view').text(response.phone)
    $("#photo-view").attr("src", photo);
}

$(document).on("click", ".pagination li a", function (event) {
    event.preventDefault();
    var page = $(this).data("ci-pagination-page");
    loadPagination(page);
});

$(document).on("click", "#btn-remove", function (event) {
    var id = $(this).attr('data-id');
    var status = $(this).attr('data-status') == "active" ? "Menonaktifkan" : "Mengaktifkan";
    if ($(this).attr('data-status') == "active") {
        var link = url + 'api/profile/user?ban=true'
    } else {
        var link = url + 'api/profile/user?ban=false'
    }

    Swal.fire({
        title: status + ' Pengguna',
        text: "Anda Setuju Untuk " + status + " Pengguna ?",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Setuju',
        cancelButtonText: 'Tidak'
    }).then((result) => {
        if (result.value) {
            Swal.fire(
                'Sukses',
                status + ' Pengguna'
            ).then(

                $.ajax({
                    url: link,
                    type: 'post',
                    dataType: 'json',
                    data: { id: id },
                    success: function (response) {

                        console.log(response);
                        setTimeout(location.reload.bind(location), 3e3)
                    },
                    error: function (t) {
                        console.log(t);
                    }
                })

            )
        }
    })
});

$(document).on("click", "#btn-edit", function (event) {
    $.ajax({
        url: url + '/profile/guru?id=' + $(this).attr('data-field'),
        type: 'get',
        dataType: 'json',
        success: function (response) {
            modal_update(response.message)
        },
        error: function (t) {
            console.log(t);
        }
    });
});

function modal_update(response) {
    

    var photo = response.profilePhoto === 'http://localhost/learning/public/' ? 'http://localhost/learning/public/upload/profile/default.jpg' : response.profilePhoto;

    

    $('#username').val(response.username)
    $('#email').val(response.email)
    $('#identity').val(response.numberIdentity)
    $('#fullname').val(response.fullname)
    $('#years').val(response.schoolYear)
    $('#bod').val(response.bornOfDate)
    $('#gender').val(response.gender)
    $('#religion').val(response.religion)
    $('#address').val(response.address.address)
    $('#city').val(response.address.city)
    $('#state').val(response.address.state)
    $('#zip').val(response.address.zip)
    $('#phone').val(response.phone)
    html = `<input name="file" id="file" type="file" class="form-control dropify" accept="image/*" data-max-file-size="1M" data-height="300" data-allowed-file-extensions="jpg jpeg png" data-errors-position="outside" data-default-file="`+ photo +`" multiple>`

    $('#photo').html(html)

    $(".dropify").dropify({ messages: { remove: "Hapus", error: "Ooops, something wrong happended." }, error: { fileSize: "Ukuran gambar terlalu besar, maksimal ({{ value }}).", fileExtension: "Format gambar tidak diijinkan, untuk format ({{ value }})." }, tpl: { clearButton: '<button type="button" class="dropify-clear btn btn-danger">{{ remove }}</button>' } });
}