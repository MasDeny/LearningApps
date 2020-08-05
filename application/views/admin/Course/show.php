<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
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
                    <div>Materi Pelajaran
                        <div class="page-title-subheading">Berikut adalah halaman dari materi yang sudah ditambahkan oleh guru
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-2 card shadow-lg">
            <div class="card-header justify-content-center border-info">
                <div class="row">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="kelas-1" data-toggle="tab" href="#tab-content-0">
                                <span>Materi Kelas 1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="kelas-2" data-toggle="tab" href="#tab-content-1">
                                <span>Materi Kelas 2</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="kelas-3" data-toggle="tab" href="#tab-content-2">
                                <span>Materi Kelas 3</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mb-1 card">
            <div class="card-header bg-arielle-smile"></div>
            <div class="card-header justify-content-center">
                Daftar Materi Pelajaran Yang Telah Ditambahkan
            </div>
            <div class="card-body">
                <div class="tab-content" style="min-height: 30vh;">
                    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                        <div class="row" id="course-content-1"></div>
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                        <div class="row" id="course-content-2">
                        </div>
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                        <div class="row" id="course-content-3">
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-block text-center card-footer mb-2">
                <nav class="d-flex justify-content-center" aria-label="Page navigation" id="pagination_link"></nav>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/course.js" hidden></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <?php $this->load->view("admin/_partials/footer.php") ?>
</body>

</html>