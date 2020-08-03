var url = $('body').attr('data-url');
var role = $('body').attr('data-role');
var SClass = $('table').attr('data-class');

function loadPagination(pagno) {
    if (SClass != '') {
        var link = url + '/profile/murid/' + pagno + '?class=' + SClass
    } else {
        var link = url + '/profile/murid/' + pagno
    }
    $.ajax({
        url: link,
        type: 'get',
        dataType: 'json',
        success: function (response) {

            $("#pagination_link").html(response.message.pagination);

            show_table(response.message.result);
        },
        error: function (t) {
            console.log(t);
        }
    });
}

$(document).ready(function () {

    loadPagination(1);

});

function show_table(response) {
    var datarole = '';
    if (role == 'guru') {
        datarole +=
            '<a type="button" id="btn-statistik" class="btn btn-warning btn-sm ml-1" data-toggle="tooltip" data-placement="top" title="Statistik Siswa">' +
            '<i class="pe-7s-graph1 text-light">' +
            '</i></a>'
    }
    var trHTML = '';
    $.each(response, function (i, item) {

        var status = item.status == "active" ? "badge-success" : "badge-danger"
        var locked = item.status == "active" ? "lock" : "unlock"
        trHTML += '<tr>' +
            '<td class="text-center text-muted" >' + item.numberIdentity + '</td>' +
            '<td class="text-center">' +
            '<div class="widget-content p-0">' +
            '<div class="widget-content-wrapper">' +
            '<div class="widget-content-left flex2">' +
            '<div class="widget-heading">' + item.fullname + '</div>' +
            '<div class="widget-subheading opacity-7">Kelas ' + item.class +
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
            '<button type="button" id="btn-details" class="btn btn-primary btn-sm" data-field="' + item.id + '" data-toggle="modal" data-target=".bd-example-modal-lg" data-toggle="tooltip" data-placement="top" title="Lihat Detail Siswa">' +
            '<i class="pe-7s-info">' +
            '</i></button>'
            + datarole +
            '<a type="button" id="btn-edit" class="btn btn-success btn-sm ml-1" data-field="' + item.id + '" data-toggle="modal" data-target=".bd-edit-modal-lg" data-toggle="tooltip" data-placement="top" title="Edit Siswa">' +
            '<i class="pe-7s-pen text-light">' +
            '</i></a>'+
            '<button type="button" id="btn-remove" class="btn btn-danger btn-sm ml-1" data-id="'+item.id+'" data-status="'+item.status+'" data-toggle="tooltip" data-placement="top" title="Edit Status Siswa">' +
            '<i class="pe-7s-'+ locked +'">' +
            '</i></button>' +
            '</td>' +
            '</tr>';
    });
    $('#table_view').html(trHTML);
    if (role == 'guru') {
        $("[id=btn-remove]").remove();
        $("[id=btn-edit]").remove();
    }
}


$(document).on("click", "#btn-details", function (event) {
    $.ajax({
        url: url + '/profile/murid?id=' + $(this).attr('data-field'),
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
    $('#years-view').text(response.schoolYear)
    $('#bod-view').text(response.bornOfDate)
    $('#gender-view').text(response.gender)
    $('#religion-view').text(response.religion)
    $('#address-view').text(response.address.address)
    $('#city-view').text(response.address.city)
    $('#state-view').text(response.address.state)
    $('#zip-view').text(response.address.zip)
    $('#phone-view').text(response.phone)
    var drEvent = $(".dropify-view").dropify({ defaultFile: photo, messages: {
        'replace': ''
    } });
    drEvent = drEvent.data('dropify');
    drEvent.settings.defaultFile = photo;
    drEvent.destroy();
    drEvent.init();

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
        title:  status +' Pengguna',
        text: "Anda Setuju Untuk "+ status +" Pengguna ?",
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
                status+' Pengguna'
            ).then(
            
                $.ajax({
                    url: link,
                    type: 'post',
                    dataType: 'json',
                    data:{id:id},
                    success: function (response) {
                        setTimeout(location.reload.bind(location),3e3)
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
        url: url + '/profile/murid?id=' + $(this).attr('data-field'),
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

    // update data user profile
    var photo = response.profilePhoto === 'http://localhost/learning/public/' ? 'http://localhost/learning/public/upload/profile/default.jpg' : response.profilePhoto;

    var bod = response.bornOfDate.split(', ')

    $('input[name=username]').val(response.username).prop('readOnly', true);
    $('input[name=email]').val(response.email).prop('readOnly', true);
    $('input[name=id]').val(response.numberIdentity)
    $('input[name=fullname]').val(response.fullname)
    $('input[name=years]').val(response.schoolYear)
    $('input[name=class]').val(response.class)
    $('input[name=place]').val(bod[0])
    $('input[name=date]').val(bod[1])
    $('input[name=gender]').val(response.gender)
    $('input[name=religion]').val(response.religion)
    $('input[name=address]').val(response.address.address)
    $('input[name=city]').val(response.address.city)
    $('input[name=state]').val(response.address.state)
    $('input[name=zip]').val(response.address.zip)
    $('input[name=phone]').val(response.phone)
    $('input[name=file]').attr("data-default-file", photo);

    var drEvent = $(".dropify").dropify({ messages: { error: "Ooops, something wrong happended." }, error: { fileSize: "Ukuran gambar terlalu besar, maksimal ({{ value }}).", fileExtension: "Format gambar tidak diijinkan, untuk format ({{ value }})."} });
    
    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.settings.defaultFile = photo;
    drEvent.destroy();
    drEvent.init();
    
    $("#edit-profile").attr("role-user", response.role);
    $('#pass-change').attr("data-id-user", response.id);
}

function hideNotification() {
    $("#toast-container").fadeOut(), $(".toast").remove();
}

// update data user
$(document).on("submit", "#edit-profile", function (e) {
    const roleEdit = $("#edit-profile").attr("role-user");
    e.preventDefault();
    var formData = new FormData(this)
        formData.append('role', roleEdit)
    $.ajax({
        url: url + "api/profile/update",
        type: "POST",
        data: formData,
        contentType: !1,
        cache: !1,
        processData: !1,
        success: function (t) {
            var a = $(
                '<div class="toast toast-success" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Berhasil</div><div class="toast-message">' +
                    t.message +
                    "</div></div>"
            );
            $('.bd-edit-modal-lg').modal('toggle')
            $('.modal-backdrop').remove();
            $("#toast-container").append(a)
            $("#toast-container").fadeIn(2000);
            setTimeout(function(){
                $('#toast-container').fadeOut(2000, function(){
                    location.reload(true);
                });
            }, 3000);
        },
        error: function (t) {
            console.log(t)
            let a = t.responseJSON;
            if ((console.log(t), 403 != t.status)) {
                var e = $(
                    '<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' +
                        a.message +
                        "</div></div>"
                );
                $("#toast-container").append(e), $("#toast-container").slideDown().fadeIn(), !0;
                setTimeout(function(){
                    $('#toast-container').fadeOut(2500, function(){
                        location.reload(true);
                    });
                }, 3000);
            }
            Object.entries(a.message).forEach(([t, a]) => {
                var e = $(
                    '<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' +
                        `${a}` +
                        "</div></div>"
                );
                $("#toast-container").append(e), $("#toast-container").slideDown().fadeIn(), !0;
                setTimeout(function(){
                    $('#toast-container').fadeOut(2500, function(){
                        location.reload(true);
                    });
                }, 3000);
            });
        },
    });
});

$(document).on("submit", "#pass-change", function (e) { 
    const idUser = $("#pass-change").attr("data-id-user");
    e.preventDefault();
    var formData = new FormData(this)
    formData.append('id', idUser)
    formData.delete('email')
        $.ajax({
            url: url + "api/profile/user",
            type: "POST",
            data: formData,
            contentType: !1,
            cache: !1,
            processData: !1,
            success: function (t) {
                var a = $(
                    '<div class="toast toast-success" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Berhasil</div><div class="toast-message">' +
                        t.message +
                        "</div></div>"
                );
                $('.bd-edit-modal-lg').modal('toggle')
                $('.modal-backdrop').remove();
                $("#toast-container").append(a)
                $("#toast-container").fadeIn(500);
                setTimeout(function(){
                    $('#toast-container').fadeOut(2500, function(){
                        location.reload(true);
                    });
                }, 3000);
            },
            error: function (t) {
                console.log(t)
                let a = t.responseJSON;
                if ((console.log(t), 403 != t.status)) {
                    var e = $(
                        '<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' +
                            a.message +
                            "</div></div>"
                    );
                    $('.bd-edit-modal-lg').modal('toggle')
                    $("#toast-container").append(e), $("#toast-container").slideDown().fadeIn(500);
                    setTimeout(function(){
                        $('#toast-container').fadeOut(2500, function(){
                            location.reload(true);
                        });
                    }, 3000);
                }
                Object.entries(a.message).forEach(([t, a]) => {
                    var e = $(
                        '<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' +
                            `${a}` +
                            "</div></div>"
                    );
                    $('.bd-edit-modal-lg').modal('toggle')
                    $("#toast-container").append(e), $("#toast-container").slideDown().fadeIn(), !0;
                    setTimeout(function(){
                        $('#toast-container').fadeOut(2500, function(){
                            location.reload(true);
                        });
                    }, 3000);
                });
            },
        });
});
