<div class="app-main">
    <div class="app-sidebar sidebar-shadow bg-light sidebar-text-dark">
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
        <div class="scrollbar-sidebar">
            <div class="app-sidebar__inner">
                <ul class="vertical-nav-menu">
                    <?php if ($this->session->userdata('user_data')['role'] == 'guru') { ?>
                        <li class="app-sidebar__heading">Menu Utama</li>
                        <li>
                            <a href="<?php echo base_url() ?>dashboard" class="<?php echo $title == "Dashboard" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-home icon-gradient bg-premium-dark"></i>
                                Dashboard Statistik
                            </a>
                        </li>
                        <li class="app-sidebar__heading">Master Soal</li>
                        <li>
                            <a href="javascript:void(0);" class="<?php echo $title == "List Exam" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-display2 icon-gradient bg-premium-dark"></i>
                                List Daftar Soal
                            </a>
                        </li>
                        <ul class="mm-collapse mm-show">
                            <li class="<?php echo $subtitle == "pretest" ? "mm-active" : ""; ?>">
                                <a href="<?php echo base_url() ?>dashboard/pretestexam">
                                    <i class="metismenu-icon">
                                    </i>Soal Pre-Test
                                </a>
                            </li>
                            <li class="<?php echo $subtitle == "daily" ? "mm-active" : ""; ?>">
                                <a href="<?php echo base_url() ?>dashboard/dailyexam">
                                    <i class="metismenu-icon">
                                    </i>Soal Harian
                                </a>
                            </li>
                            <li class="<?php echo $subtitle == "final" ? "mm-active" : ""; ?>">
                                <a href="<?php echo base_url() ?>dashboard/finalexam">
                                    <i class="metismenu-icon">
                                    </i>Soal Ujian Akhir
                                </a>
                            </li>
                        </ul>
                        <li>
                            <a href="#" class="<?php echo $title == "AddExam" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-note2 icon-gradient bg-premium-dark"></i>
                                Tambah Soal
                                <i class="metismenu-state-icon pe-7s-plus caret-left"></i>
                            </a>
                        </li>
                        <li class="app-sidebar__heading">Master Materi</li>
                        <li>
                            <a href="<?php echo base_url() ?>dashboard/list_course" class="<?php echo $title == "ListCourse" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-display1 icon-gradient bg-premium-dark"></i>
                                List Daftar Materi
                            </a>
                        </li>
                        <li>
                            <a href="tables-regular.html" class="<?php echo $title == "AddCourse" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-notebook icon-gradient bg-premium-dark"></i>
                                Tambah Materi
                                <i class="metismenu-state-icon pe-7s-plus caret-left"></i>
                            </a>
                        </li>
                        <li class="app-sidebar__heading">Master Siswa</li>
                        <li>
                            <a href="<?php echo base_url() ?>dashboard/list_user/murid" class="<?php echo empty($class) && $title == 'Daftar Murid' ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-users icon-gradient bg-premium-dark">
                                </i>List Data Siswa
                                <i class="metismenu-state-icon pe-7s-angle-up caret-left"></i>
                            </a>
                        </li>
                        <ul class="mm-collapse mm-show">
                            <li>
                                <a href="<?php echo base_url() ?>dashboard/list_user/murid?class=1" class="<?php if (!empty($class)) echo $class == "1" ? "mm-active" : ""; ?>">
                                    <i class="metismenu-icon">
                                    </i>Siswa Kelas 1
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() ?>dashboard/list_user/murid?class=2" class="<?php if (!empty($class)) echo $class == "2" && !empty($class) ? "mm-active" : ""; ?>">
                                    <i class="metismenu-icon">
                                    </i>Siswa Kelas 2
                                </a>
                            </li>
                            <li>
                                <a href="<?php echo base_url() ?>dashboard/list_user/murid?class=3" class="<?php if (!empty($class)) echo $class == "3" && !empty($class) ? "mm-active" : ""; ?>">
                                    <i class="metismenu-icon">
                                    </i>Siswa Kelas 3
                                </a>
                            </li>
                        </ul>
                    <?php } ?>
                    <?php if ($this->session->userdata('user_data')['role'] == 'administrator') { ?>
                        <li class="app-sidebar__heading">Menu Admin</li>
                        <li class="pt-1">
                            <a href="<?php echo base_url() ?>dashboard/admin_dash" class="<?php echo $title == "Dashboard Admin" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-home icon-gradient bg-premium-dark"></i>
                                Dashboard Admin
                            </a>
                        </li>
                        <li class="pt-2">
                            <a href="<?php echo base_url() ?>dashboard/list_user/guru" class="<?php echo $title == "ShowTeachers" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-study icon-gradient bg-premium-dark"></i>
                                List Daftar Guru
                            </a>
                        </li>
                        <li class="pt-2">
                            <a href="<?php echo base_url() ?>dashboard/list_user/murid" class="<?php echo $title == "ShowStudents" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-users icon-gradient bg-premium-dark"></i>
                                List Daftar Murid
                            </a>
                        </li>
                        <li class="pt-2">
                            <a href="<?php echo base_url() ?>dashboard/add_user" class="<?php echo $title == "Tambah Pengguna" ? "mm-active" : ""; ?>">
                                <i class="metismenu-icon pe-7s-add-user icon-gradient bg-premium-dark"></i>
                                Tambah Pengguna
                            </a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </div>
    <div class="app-main__outer">