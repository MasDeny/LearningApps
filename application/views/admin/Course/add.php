<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
    <link href="<?php echo base_url() ?>assets/css/smartwizard/smart_wizard.css" type="text/css" />
    <link href="<?php echo base_url() ?>assets/css/smartwizard/smart_wizard_progress.css" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/jquery.smartWizard.js"></script>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dropify.min.css" />
    <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/dropify.min.js"></script>
</head>

<body data-url="<?php echo base_url() ?>">
    <?php $this->load->view("admin/_partials/navbar.php") ?>
    <?php $this->load->view("admin/_partials/sidebar.php") ?>
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-drawer icon-gradient bg-happy-itmeo">
                        </i>
                    </div>
                    <div>Tambah Materi
                        <div class="page-title-subheading">Pada Halaman ini guru dapat menambahkan materi yang nantinya akan dipelajari oleh siswa, format materi yang dibuat harus berupa file berbentuk pdf
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-card mb-3 card">
            <div class="card-header bg-arielle-smile"></div>
            <div class="card-body">
                <div id="smartwizard">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#step-1">
                                <strong>Step 1</strong> <br>Pilih kategori soal yang akan dibuat
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-2">
                                <strong>Step 2</strong> <br>Masukkan judul dari materi dan upload file materi dengan format pdf
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-3">
                                <strong>Step 3</strong> <br>Masukkan nilai yang harus dicapai untuk mempelajari materi ini
                            </a>
                        </li>
                    </ul>
                    <form id="submit-course" url="<?php echo base_url() ?>" enctype="multipart/form-data">
                        <div class="tab-content" style="min-height: 500px;">
                            <div id="step-1" class="tab-pane pt-5" role="tabpanel" aria-labelledby="step-1">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Kategori materi ( Bab materi pada LKS ) : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control caps" name="kategori">
                                                <option disabled>-- Pilih Kategori Materi --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Tingkat Kesulitan : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control" name="level">
                                                <option disabled>-- Pilih Level Materi --</option>
                                                <option value="1">Level Mudah</option>
                                                <option value="2">Level Menengah</option>
                                                <option value="3">Level Sulit</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Tingkat Pengajaran Materi : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control" name="kelas">
                                                <option disabled>-- Pilih Kelas --</option>
                                                <option value="1">Kelas 1</option>
                                                <option value="2">Kelas 2</option>
                                                <option value="3">Kelas 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-2" class="tab-pane pt-4" role="tabpanel" aria-labelledby="step-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Judul Materi</strong></h5>
                                            <input name="judul" type="text" class="mb-2 form-control-lg form-control caps">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Upload File Materi</strong></h5>
                                            <input name="materi" id="materi" type="file" class="form-control dropify" accept="pdf/*" data-max-file-size="12M" data-height="300" data-allowed-file-extensions="pdf" data-errors-position="outside">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3" class="tab-pane pt-5" role="tabpanel" aria-labelledby="step-3">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Nilai yang harus dicapai : </strong></h5>
                                            <input name="nilai" type="number" class="mt-2 form-control-lg form-control caps">
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <div id="accordion" class="accordion-wrapper mb-3">
                                                <div id="headingTwo" class="b-radius-0 card-header">
                                                    <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block">
                                                        <h6 class="m-0 p-0 text-dark">
                                                            <strong> Tambahkan catatan untuk siswa</strong>
                                                        </h6>
                                                    </button>
                                                </div>
                                                <div data-parent="#accordion" id="collapseOne2" class="collapse">
                                                    <div class="card-body">
                                                        <div class="form-group">
                                                            <label for="example4">Tulis catatan untuk siswa</label>
                                                            <textarea type="text" class="form-control" name="note" style="min-height: 25vh;"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="toolbar toolbar-bottom" role="toolbar" style="text-align: right;">
                            <button class="btn sw-btn-prev disabled" type="button">Previous</button>
                            <button class="btn sw-btn-next" type="button">Next</button>
                            <button class="btn sw-btn-save" type="submit">Simpan</button>
                        </div>
                    </form>
                    <div id="toast-container" class="toast-top-right" style="margin-top:8vh">
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/add_course.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
        <?php $this->load->view("admin/_partials/footer.php") ?>
</body>

</html>