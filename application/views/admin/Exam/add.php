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

<body data-url="<?php echo base_url() ?>" data-role="<?php echo $this->session->userdata("user_data")["role"] ?>">
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
                                <strong>Step 1</strong> <br>Pilih kategori soal yang akan dibuat :
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-2">
                                <strong>Step 2</strong> <br>Masukkan soal yang akan dibuat :
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#step-3">
                                <strong>Step 3</strong> <br>Masukkan jawaban serta kunci jawaban soal :
                            </a>
                        </li>
                    </ul>
                    <form id="submit" url="<?php echo base_url() ?>" enctype="multipart/form-data">
                        <div class="tab-content" style="min-height: 500px;">
                            <div id="step-1" class="tab-pane pt-5" role="tabpanel" aria-labelledby="step-1">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Jenis soal yang dibuat : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control" name="type">
                                                <option disabled>-- Pilih Jenis --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center" id="content-category">
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <h5><strong>Kategori materi : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control caps" name="kategori">
                                                <option disabled>-- Pilih Kategori Materi --</option>
                                                <option>Large Select</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="position-relative form-group">
                                            <h5><strong>Sub kategori materi : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control caps" name="subkategori">
                                                <option disabled>-- Pilih Kategori Materi --</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Tingkat Kesulitan Soal : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control" name="level">
                                                <option disabled>-- Pilih Level Soal --</option>
                                                <option value="1">Level Mudah</option>
                                                <option value="2">Large Sedang</option>
                                                <option value="3">Large Susah</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group" name="kelas">
                                            <h5><strong>Tingkat Evaluasi Soal : </strong></h5>
                                            <select class="mb-2 mt-2 form-control-lg form-control">
                                                <option disabled>-- Pilih Kelas --</option>
                                                <option value="1">Kelas 1</option>
                                                <option value="2">Kelas 2</option>
                                                <option value="3">Kelas 3</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-2" class="tab-pane pt-3" role="tabpanel" aria-labelledby="step-2">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Tulis pertanyaan yang ingin dibuat :</strong></h5>
                                            <textarea type="text" class="form-control" name="note" style="min-height: 20vh;"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <div id="accordion" class="accordion-wrapper mb-1">
                                                <div id="headingTwo" class="b-radius-0 card-header">
                                                    <button type="button" data-toggle="collapse" data-target="#collapseOne2" aria-expanded="false" aria-controls="collapseTwo" class="text-left m-0 p-0 btn btn-link btn-block">
                                                        <h6 class="m-0 p-0 text-dark">
                                                            <strong> Tambahkan gambar (jika soal tersedia gambar) :</strong>
                                                        </h6>
                                                    </button>
                                                </div>
                                                <div data-parent="#accordion" id="collapseOne2" class="collapse">
                                                    <div class="position-relative form-group">
                                                        <input name="images" id="images" type="file" class="form-control dropify" accept="image/*" data-max-file-size="1M" data-height="150" data-allowed-file-extensions="jpg jpeg png bmp" data-errors-position="outside">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="step-3" class="tab-pane pt-5" role="tabpanel" aria-labelledby="step-3">
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Pilihan ganda dari soal yang diberikan : </strong></h5>
                                            <div class="row pb-1">
                                                <div class="col-md-6">
                                                    <input name="nilai" type="text" class="mt-2 form-control-lg form-control caps" id="target" placeholder="A">
                                                </div>
                                                <div class="col-md-6">
                                                    <input name="nilai" type="text" class="mt-2 form-control-lg form-control caps" id="target" placeholder="B">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input name="nilai" type="text" class="mt-2 form-control-lg form-control caps" id="target" placeholder="C">
                                                </div>
                                                <div class="col-md-6">
                                                    <input name="nilai" type="text" class="mt-2 form-control-lg form-control caps" id="target" placeholder="D">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center pt-3">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group">
                                            <h5><strong>Kunci jawaban dari pertanyaan tersebut adalah : </strong></h5>
                                            <div class="card-header shadow-none pt-2">
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label pr-1" for="inlineRadio1">A. </label>
                                                    <input class="form-check-input" type="radio" name="answer" id="inlineRadio1" value="A">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label pr-1" for="inlineRadio2">B. </label>
                                                    <input class="form-check-input" type="radio" name="answer" id="inlineRadio2" value="B">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label pr-1" for="inlineRadio1">C. </label>
                                                    <input class="form-check-input" type="radio" name="answer" id="inlineRadio3" value="C">
                                                </div>
                                                <div class="form-check form-check-inline">
                                                    <label class="form-check-label pr-1" for="inlineRadio2">D. </label>
                                                    <input class="form-check-input" type="radio" name="answer" id="inlineRadio4" value="D">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-center">
                                    <div class="col-md-8">
                                        <div class="position-relative form-group pt-3">
                                            <h5><strong>Nilai soal : </strong></h5>
                                            <input name="nilai" type="number" class="mt-3 form-control-lg form-control caps">
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
                </div>
            </div>
        </div>
        <script type="text/x-mathjax-config">
            MathJax.Hub.Config({
                tex2jax: {inlineMath: [['$','$'], ['\\(','\\)']]}
            });
        </script>
        <script type="text/javascript" async src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-MML-AM_CHTML">
        </script>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/add_exam.js"></script>
        <?php $this->load->view("admin/_partials/footer.php") ?>
</body>

</html>