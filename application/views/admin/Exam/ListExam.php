<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
</head>

<body data-url="<?php echo base_url() ?>" data-type="<?php echo $this->uri->segment(2); ?>">
    <?php $this->load->view("admin/_partials/navbar.php") ?>
    <?php $this->load->view("admin/_partials/sidebar.php") ?>
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-car icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Daftar <?php echo $track ?>
                        <div class="page-title-subheading">This is an example dashboard created using
                            build-in elements and components.
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card" style="min-height:60vh">
                    <div class="card-header">Daftar Soal Yang Dibuat
                    </div>
                    <div class="table-responsive">
                        <table class="align-middle mb-0 table table-borderless table-striped table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Judul Ujian</th>
                                    <th class="text-center">Jenis Soal</th>
                                    <th class="text-center">Kelas</th>
                                    <th class="text-center">Tingkatan</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="table_view">
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center card-footer mt-auto">
                        <nav class="d-flex justify-content-center" aria-label="Page navigation" id="pagination_link"></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/exam.js" hidden></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <?php $this->load->view("admin/_partials/footer.php") ?>
</body>

</html>