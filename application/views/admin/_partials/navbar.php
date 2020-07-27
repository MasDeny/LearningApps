<div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header">
    <div class="app-header header-shadow bg-arielle-smile header-text-light">
        <div class="app-header__logo">
            <div class="logo-src"></div>
            <div class="header__pane ml-auto">
                <div>
                    <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
        <div class="app-header__mobile-menu">
            <div>
                <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                    <span class="hamburger-box">
                        <span class="hamburger-inner"></span>
                    </span>
                </button>
            </div>
        </div>
        <div class="app-header__menu">
            <span>
                <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                    <span class="btn-icon-wrapper">
                        <i class="fa fa-ellipsis-v fa-w-6"></i>
                    </span>
                </button>
            </span>
        </div>
        <div class="app-header__content">
            <div class="app-header-left">
                <?php if ($subtitle == 'list') { ?>
                    <div class="search-wrapper">
                        <div class="input-holder">
                            <input type="text" class="search-input text-dark" placeholder="Cari <?php echo $this->uri->segment(3); ?> berdasarkan nama">
                            <button class="search-icon"><span></span></button>
                        </div>
                        <button class="close"></button>
                    </div>
                <?php } ?>
            </div>
            <div class="app-header-right">
                <div class="header-btn-lg pr-0">
                    <div class="widget-content p-0">
                        <div class="widget-content-wrapper">
                            <div class="widget-content-left">
                                <div class="btn-group">
                                    <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                        <?php if ($this->session->userdata('user_data')['profilePhoto'] == base_url()) { ?>
                                            <img width="35" class="rounded-circle img-fluid" src="<?php echo base_url() ?>upload/profile/default.jpg" alt="Profile Picture">
                                        <?php }else{ ?>
                                            <img width="35" class="rounded-circle img-fluid" src="<?php echo $this->session->userdata('user_data')['profilePhoto'] ?>" alt="Profile Picture">
                                        <?php } ?>
                                        <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                    </a>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right">
                                        <h6 tabindex="-1" class="dropdown-header">Pengaturan Pengguna</h6>
                                        <button type="button" tabindex="0" class="dropdown-item">Tampilkan Profil</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Perbaharui Profil</button>
                                        <button type="button" tabindex="0" class="dropdown-item">Ganti Password</button>
                                        <div tabindex="-1" class="dropdown-divider"></div>
                                        <a type="button" tabindex="0" href="<?php echo base_url() ?>admin/logout" class="dropdown-item text-danger">Keluar Aplikasi</a>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content-left  ml-3 header-user-info mr-sm-2  /">
                                <div class="widget-heading">
                                    <?php echo $this->session->userdata('user_data')['fullname'] ?>
                                </div>
                                <div class="widget-subheading">
                                    <?php echo $this->session->userdata('user_data')['position'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>