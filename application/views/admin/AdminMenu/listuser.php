<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view("admin/_partials/head.php") ?>
    <link rel="stylesheet" href="<?php echo base_url() ?>assets/css/dropify.min.css" />
</head>

<body data-url="<?php echo base_url() ?>" data-role="<?php echo $this->session->userdata("user_data")["role"] ?>">
    <?php $this->load->view("admin/_partials/navbar.php") ?>
    <?php $this->load->view("admin/_partials/sidebar.php") ?>
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <?php if ($this->uri->segment(3) == 'murid') { ?>
                            <i class="pe-7s-users icon-gradient bg-mean-fruit">
                            </i>
                        <?php } else { ?>
                            <i class="pe-7s-study icon-gradient bg-mean-fruit">
                            </i>
                        <?php } ?>
                    </div>
                    <div><?php echo $title ?>
                        <?php if ($this->uri->segment(3) == 'murid') { ?>
                            <div class="page-title-subheading">Berikut adalah murid yang terdaftar pada aplikasi
                            </div>
                        <?php } else { ?>
                            <div class="page-title-subheading">Berikut adalah Staff yang terdaftar pada aplikasi
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="main-card mb-3 card">
                    <div class="card-header">
                        <?php if ($this->uri->segment(3) == 'murid') { ?>
                            Murid yang terdaftar pada aplikasi
                        <?php } else { ?>
                            Staff Pengajar yang terdaftar pada aplikasi
                        <?php } ?>
                        <?php if ($this->session->userdata("user_data")["role"] != 'guru') { ?>
                            <div class="btn-actions-pane-right">
                                <div role="group" class="btn-group-sm btn-group">
                                    <?php if ($this->uri->segment(3) == 'murid') { ?>
                                        <a href="<?php echo base_url() ?>dashboard/add_user" class="active btn bg-info text-light">
                                            Tambah Murid
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo base_url() ?>dashboard/add_user" class="active btn bg-info text-light">
                                            Tambah Staff
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="table-responsive p-2">
                        <table class="align-middle table table-borderless table-striped table-hover" id="table-data" data-class="<?php if (!empty($class)) echo $class ?>">
                            <thead class="bg-arielle-smile text-light" style="line-height: 6vh;">
                                <tr>
                                    <th class="text-center">NIS</th>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Gender</th>
                                    <th class="text-center">TTL</th>
                                    <th class="text-center">phone</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center"></th>
                                </tr>
                            </thead>
                            <tbody id="table_view">
                            </tbody>
                        </table>
                    </div>
                    <div class="d-block text-center card-footer">
                        <nav class="d-flex justify-content-center" aria-label="Page navigation" id="pagination_link"></nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($this->uri->segment(3) == 'murid') { ?>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/students.js" hidden></script>
    <?php } else { ?>
        <?php if ($this->session->userdata('user_data')['role'] == 'guru') { redirect('dashboard/list_user/murid'); }?>
        <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/teachers.js" hidden></script>
    <?php } ?>
    <?php $this->load->view("admin/_partials/footer.php") ?>
    <?php $this->load->view("admin/_partials/modals-update.php") ?>
    <?php $this->load->view("admin/_partials/modals-view.php") ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/dropify.min.js"></script>
</body>

</html>