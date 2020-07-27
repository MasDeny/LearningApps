<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Panel</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/login.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
</head>

<body>
    <div class="login-block">
        <div class="container">
            <div class="row">
                <div class="col-md-8 banner-sec pt-5">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <img class="d-block img-fluid" src="<?php echo base_url() ?>/assets/images/logo-kemendikbud.jpg" alt="First slide">
                                <div class="carousel-caption d-none d-md-block">
                                    <div class="banner-text">
                                        <h2>Tut Wuri Handayani</h2>
                                        <p>Di depan seorang pendidik harus bisa menjadi teladan, di tengah murid pendidik harus bisa memberikan ide, dan di belakang seorang pendidik harus bisa memberikan dorongan.</p>
                                        <p class="text-right" style="padding-right: 1vh;"> ◽ Ki Hajar Dewantara</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-4 login-sec">
                    <h2 class="text-center up">Masuk Aplikasi</h2>
                    <h2 class="text-center down">E-Learning</h2>
                    <form class="login-form" url="<?php echo base_url() ?>">
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="text-uppercase">Email</label>
                            <input type="email" class="form-control" placeholder="" id="email">

                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1" class="text-uppercase">Password</label>
                            <input type="password" class="form-control" placeholder="" id="password">
                        </div>
                        <div class="form-check">
                            <label class="form-check-label">
                                <input type="checkbox" class="form-check-input" checked>
                                <small>Ingat Saya</small>
                            </label>
                        </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-login btn-lg btn-block" id="loginBtn">Masuk</button>
                    </div>
                    </form>
                    <!-- <div class="copy-text">Created with <i class="fa fa-heart"></i> by Grafreez</div> -->
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/login.js" hidden></script>
</body>

</html>