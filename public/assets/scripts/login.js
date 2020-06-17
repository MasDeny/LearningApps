$(document).ready(function () {

    $("#loginBtn").click(function () {

        var email = $("#email").val();
        var password = $("#password").val();

        if (email.length == "") {

            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: 'Email Wajib Diisi !'
            });

        } else if (password.length == "") {

            Swal.fire({
                type: 'warning',
                title: 'Oops...',
                text: 'Password Wajib Diisi !'
            });

        } else {

            $.ajax({

                url: "cek_login",
                type: "POST",
                dataType: 'json',
                data: {
                    "email": email,
                    "password": password
                },

                success: function (response) {

                    if (response.status) {

                        Swal.fire({
                            type: 'success',
                            title: 'Login Berhasil!',
                            text: 'Anda akan di arahkan dalam 3 Detik',
                            timer: 3000,
                            showCancelButton: false,
                            showConfirmButton: false
                        })
                            .then(function () {
                                window.location.href = "dashboard/";
                            });

                    } else {

                        Swal.fire({
                            type: 'error',
                            title: 'Login Gagal!',
                            text: 'silahkan coba lagi!'
                        });


                    }
                    console.log(response);

                },

                error: function (response) {

                    Swal.fire({
                        type: 'error',
                        title: 'Opps!',
                        text: 'server error!'
                    });

                    console.log(response);

                }

            });

        }

    });

});