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
        <div class="mb-3 card shadow-lg">
            <div class="card-header justify-content-center border-info">
                <div class="row">
                    <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
                        <li class="nav-item">
                            <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
                                <span>Materi Kelas 1</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tab-1" data-toggle="tab" href="#tab-content-1">
                                <span>Materi Kelas 2</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a role="tab" class="nav-link" id="tab-2" data-toggle="tab" href="#tab-content-2">
                                <span>Materi Kelas 3</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="mb-3 card">
            <div class="card-header bg-arielle-smile"></div>
            <div class="card-header justify-content-center">
                Daftar Materi Pelajaran Yang Telah Ditambahkan
            </div>
            <div class="card-body">
                <div class="tab-content" style="min-height: 40vh;">
                    <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
                        <div class="row">
                        <div class="col-lg-6 col-xl-4 pb-2">
                                <div class="card-body widget-content shadow border-dark">
                                    <div class="text-right">
                                        <a href="#" class="btn bg-white text-dark text-right"><i class="fa fa-fw" aria-hidden="true" title="lihat pdf"></i></a>
                                    </div>
                                    <div class="text-center">
                                        <img class="card-img-top" src="<?php echo base_url() ?>assets/images/pdf.png" style="width:128px;height:128px;">
                                    </div>
                                    <div class="card-body text-left">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total Orders</div>
                                                <div class="widget-subheading">Last year expenses</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-info">
                                                    <h5><strong>Level Menengah</strong></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body widget-content shadow bg-secondary text-light">
                                    <div class="text-right">
                                        <a href="" class="btn bg-white text-dark">
                                            <i class="fa fa-fw" aria-hidden="true" title="Edit Materi"></i>
                                        </a>
                                        <a href="" class="btn btn-danger">
                                            <i class="fa fa-fw" aria-hidden="true" title="Hapus Materi"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-4 pb-2">
                                <div class="card-body widget-content shadow border-dark">
                                    <div class="text-right">
                                        <a href="#" class="btn bg-white text-dark text-right"><i class="fa fa-fw" aria-hidden="true" title="lihat pdf"></i></a>
                                    </div>
                                    <div class="text-center">
                                        <img class="card-img-top" src="<?php echo base_url() ?>assets/images/pdf.png" style="width:128px;height:128px;">
                                    </div>
                                    <div class="card-body text-left">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total Orders</div>
                                                <div class="widget-subheading">Last year expenses</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-info">
                                                    <h5><strong>Level Menengah</strong></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body widget-content shadow bg-secondary text-light">
                                    <div class="text-right">
                                        <a href="" class="btn bg-white text-dark">
                                            <i class="fa fa-fw" aria-hidden="true" title="Edit Materi"></i>
                                        </a>
                                        <a href="" class="btn btn-danger">
                                            <i class="fa fa-fw" aria-hidden="true" title="Hapus Materi"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-4 pb-2">
                                <div class="card-body widget-content shadow border-dark">
                                    <div class="text-right">
                                        <a href="#" class="btn bg-white text-dark text-right"><i class="fa fa-fw" aria-hidden="true" title="lihat pdf"></i></a>
                                    </div>
                                    <div class="text-center">
                                        <img class="card-img-top" src="<?php echo base_url() ?>assets/images/pdf.png" style="width:128px;height:128px;">
                                    </div>
                                    <div class="card-body text-left">
                                        <div class="widget-content-wrapper">
                                            <div class="widget-content-left">
                                                <div class="widget-heading">Total Orders</div>
                                                <div class="widget-subheading">Last year expenses</div>
                                            </div>
                                            <div class="widget-content-right">
                                                <div class="widget-numbers text-info">
                                                    <h5><strong>Level Menengah</strong></h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body widget-content shadow bg-secondary text-light">
                                    <div class="text-right">
                                        <a href="" class="btn bg-info text-light">
                                            <i class="fa fa-fw" aria-hidden="true" title="Edit Materi"></i>
                                        </a>
                                        <a href="" class="btn btn-danger">
                                            <i class="fa fa-fw" aria-hidden="true" title="Hapus Materi"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-4 p-2">
                                <div class="card-body widget-content shadow bg-white">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total Orders</div>
                                            <div class="widget-subheading">Last year expenses</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"><span>1896</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer shadow bg-secondary text-light">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total Orders</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-4 p-2">
                                <div class="card-body widget-content shadow bg-white">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total Orders</div>
                                            <div class="widget-subheading">Last year expenses</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"><span>1896</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer shadow bg-secondary text-light">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total Orders</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 col-xl-4 p-2">
                                <div class="card-body widget-content shadow bg-white">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total Orders</div>
                                            <div class="widget-subheading">Last year expenses</div>
                                        </div>
                                        <div class="widget-content-right">
                                            <div class="widget-numbers text-success"><span>1896</span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer shadow bg-secondary text-light">
                                    <div class="widget-content-wrapper">
                                        <div class="widget-content-left">
                                            <div class="widget-heading">Total Orders</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-1" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 card">
                                    <div class="card-body">
                                        <ul class="tabs-animated-shadow tabs-animated nav">
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link active" id="tab-c-0" data-toggle="tab" href="#tab-animated-0">
                                                    <span>Tab 1</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-c-1" data-toggle="tab" href="#tab-animated-1">
                                                    <span>Tab 2</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a role="tab" class="nav-link" id="tab-c-2" data-toggle="tab" href="#tab-animated-2">
                                                    <span>Tab 3</span>
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-animated-0" role="tabpanel">
                                                <p class="mb-0">Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen
                                                    book.
                                                    It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                            <div class="tab-pane" id="tab-animated-1" role="tabpanel">
                                                <p class="mb-0">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an
                                                    unknown
                                                    printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                            <div class="tab-pane" id="tab-animated-2" role="tabpanel">
                                                <p class="mb-0">It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                                                    PageMaker including versions of Lorem Ipsum.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 card">
                                    <div class="card-header card-header-tab-animation">
                                        <ul class="nav nav-justified">
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-0" class="active nav-link">Tab 1</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-1" class="nav-link">Tab 2</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg115-2" class="nav-link">Tab 3</a></li>
                                        </ul>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-eg115-0" role="tabpanel">
                                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                                    software like Aldus PageMaker
                                                    including versions of Lorem Ipsum.</p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg115-1" role="tabpanel">
                                                <p>Like Aldus PageMaker including versions of Lorem. It has survived not only five centuries, but also the leap into electronic typesetting, remaining
                                                    essentially unchanged. </p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg115-2" role="tabpanel">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
                                                    type specimen book. It has
                                                    survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane tabs-animation fade" id="tab-content-2" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Basic</h5>
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-0" class="active nav-link">Tab 1</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-1" class="nav-link">Tab 2</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg10-2" class="nav-link">Tab 3</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-eg10-0" role="tabpanel">
                                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                                    software like Aldus PageMaker
                                                    including versions of Lorem Ipsum.</p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg10-1" role="tabpanel">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                    when an unknown printer took a
                                                    galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg10-2" role="tabpanel">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
                                                    type specimen book. It has
                                                    survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Justified Alignment</h5>
                                        <ul class="nav nav-tabs nav-justified">
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-0" class="active nav-link">Tab 1</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-1" class="nav-link">Tab 2</a></li>
                                            <li class="nav-item"><a data-toggle="tab" href="#tab-eg11-2" class="nav-link">Tab 3</a></li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-eg11-0" role="tabpanel">
                                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                                    software like Aldus PageMaker
                                                    including versions of Lorem Ipsum.</p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg11-1" role="tabpanel">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                    when an unknown printer took a
                                                    galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg11-2" role="tabpanel">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
                                                    type specimen book. It has
                                                    survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="main-card mb-3 card">
                                    <div class="card-body">
                                        <h5 class="card-title">Tabs Variations</h5>
                                        <div class="mb-3">
                                            <div role="group" class="btn-group-sm nav btn-group">
                                                <a data-toggle="tab" href="#tab-eg12-0" class="btn-pill pl-3 active btn btn-warning">Tab 1</a>
                                                <a data-toggle="tab" href="#tab-eg12-1" class="btn btn-warning">Tab 2</a>
                                                <a data-toggle="tab" href="#tab-eg12-2" class="btn-pill pr-3  btn btn-warning">Tab 3</a>
                                            </div>
                                        </div>
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="tab-eg12-0" role="tabpanel">
                                                <p>It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing
                                                    software like Aldus PageMaker
                                                    including versions of Lorem Ipsum.</p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg12-1" role="tabpanel">
                                                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                                                    when an unknown printer took a
                                                    galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                            <div class="tab-pane" id="tab-eg12-2" role="tabpanel">
                                                <p>Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a
                                                    type specimen book. It has
                                                    survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view("admin/_partials/footer.php") ?>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/course.js" hidden></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/8.11.8/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url() ?>assets/scripts/dropify.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>

</html>