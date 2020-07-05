function hideNotification() {
    $("#toast-container").fadeOut();
    $(".toast").remove();
}

$(document).ready(function () {

    $('.dropify').dropify({
        messages: {
            'remove': 'Hapus',
            'error': 'Ooops, something wrong happended.'
        },
        error: {
            'fileSize': 'Ukuran gambar terlalu besar, maksimal ({{ value }}).',
            'fileExtension': 'Format gambar tidak diijinkan, untuk format ({{ value }}).'
        },
        tpl: {
            clearButton: '<button type="button" class="dropify-clear btn btn-danger">{{ remove }}</button>'
        }
    });

    $('#submit').submit(function (e) {

        var url = $(this).attr("url");

        e.preventDefault();
        $.ajax({
            url: url + 'api/auth/register',
            type: "POST",
            data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (e) {
                var mySecondDiv = $('<div class="toast toast-success" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Berhasil</div><div class="toast-message">' + e.message + '</div></div>');
                $('#toast-container').append(mySecondDiv);
                $("#toast-container").slideDown().fadeIn();
                setTimeout(location.reload.bind(location), 3000);
            },
            error: function (e) {
                let dataOutput = e.responseJSON;
                console.log(e);

                if (e.status == 403) {
                    Object.entries(dataOutput.message).forEach(([key, value]) => {
                        var mySecondDiv = $('<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' + `${value}` + '</div></div>');
                        $('#toast-container').append(mySecondDiv);
                        $("#toast-container").slideDown().fadeIn();
                        return true;
                    });
                } else {
                    var mySecondDiv = $('<div class="toast toast-warning" aria-live="assertive"><button type="button" class="toast-close-button" role="button" onclick="hideNotification()">×</button><div class="toast-title">Peringatan</div><div class="toast-message">' + dataOutput.message + '</div></div>');
                    $('#toast-container').append(mySecondDiv);
                    $("#toast-container").slideDown().fadeIn();
                    return true;
                }
            },
        });
    });

    $('.toast-close-button').click(function () {
        $("#toast-container").hide();
    });

    $("#class").hide();
    $("#toast-container").hide();

    $('#role').change(function () {
        if ($(this).val() == 'murid') {
            $("#class").show();
            $("#position").hide();
            $('.id').text('Nomor Induk Siswa');
        } else {
            $("#class").hide();
            $("#position").show();
            $('.id').text('Nomor Induk Pegawai');
        }
    });

    $('[data-toggle="datepicker"]').datepicker({
        format: 'dd-mm-yyyy',
        daysMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
        months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
    });

    $('#checkDefault').click(function () {
        // Get the checkbox
        var checkBox = document.getElementById("checkDefault");

        // If the checkbox is checked, display the output text
        if (checkBox.checked == true) {
            $(".data-profile").hide();
        } else {
            $(".data-profile").toggle();
        }
    });

});