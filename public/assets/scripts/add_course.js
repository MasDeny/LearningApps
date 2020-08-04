var url = $('body').attr('data-url');


$(document).ready(function () {
    
    
    loadCategories();

    $('#smartwizard').smartWizard({
        selected: 0,
        theme: 'progress',
        autoAdjustHeight: true,
        transition: {
            animation: 'slide-swing', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
            speed: '800', // Transion animation speed
        },
        showStepURLhash: true,
        justified: true,
        keyboardSettings: {
            keyNavigation: false
        }

    });

    $("#smartwizard").on("showStep", function (e, anchorObject, stepNumber, stepDirection) {
        stepNumber==0?$('.sw-btn-prev').hide():$('.sw-btn-prev').show();
        if ($('button.sw-btn-next').hasClass('disabled')) {
            $('.sw-btn-next').hide();
            $('.sw-btn-save').show(); // show the button extra only in the last page
        } else {
            $('.sw-btn-next').show();
            $('.sw-btn-save').hide();				
        }

    });

    var drEvent = $(".dropify").dropify({
        messages: { default : 'klik untuk tambah dokumen', error: "Ooops, something wrong happended." }, error: { fileSize: "Ukuran file terlalu besar, maksimal ({{ value }}).", fileExtension: "Format file tidak diijinkan, untuk format ({{ value }})." }, wrap: '<div class="dropify-wrapper"></div>',
        loader: '<div class="dropify-loader"></div>',
    });

    drEvent = drEvent.data('dropify');
    drEvent.resetPreview();
    drEvent.clearElement();
    drEvent.data.height(300);
    drEvent.destroy();
    drEvent.init();
});

function loadCategories() 
{
    $.ajax({
        url: url+'/menu/categories/show',
        type: 'get',
        dataType: 'json',
        success: function (response) {
            var trHTML = '';
            $.each(response.message, function (i, item) {
                trHTML += '<option class="caps" value="'+ item.idCategory +'">'+ item.categoryname +'</option>'
            });
            $('select[name="kategori"]').html(trHTML);
        },
        error: function (t) {
            console.log(t);
        }
    });
}

$(document).on("submit", "#submit-course", function (e) {
    e.preventDefault();
    var formData = new FormData(this)
    $.ajax({
        url: url + "api/course/add",
        type: "POST",
        data: formData,
        contentType: !1,
        cache: !1,
        processData: !1,
        success: function (t) {
            Swal.fire({
                title:  'Berhasil Ditambahkan',
                text: t.message,
                type: 'success',
                showCancelButton: true,
                confirmButtonColor: '#30c7ec',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Tambahkan Lagi Materi',
                cancelButtonText: 'Selesai'
            }).then((result) => {
                if (result.value) {
                    setTimeout(window.location = url+'/dashboard/add_course',100)
                } else {
                    setTimeout(window.location = url+'/dashboard/list_course',100)
                }
            })
        },
        error: function (t) {
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

function hideNotification() {
    $("#toast-container").fadeOut(), $(".toast").remove();
}