<div id="wrapper">

    <!-- ========== Left Sidebar Start ========== -->
    <div class="left side-menu">

        <div class="slimscroll-menu" id="remove-scroll">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="<?= base_url() ?>" class="logo">
                    <span>
                        <img src="<?= base_url('templates/img/sc_logo.svg') ?>" alt="" height="30">
                    </span>
                    <i>
                        <img src="<?= base_url('templates/img/sc_logo.png') ?>" alt="" height="28">
                    </i>
                </a>
            </div>

            <!-- User box -->
            <div class="user-box">
                <div class="user-img">
                    <img src="<?= base_url('templates/img/sc_logo.png') ?>" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                </div>
                <h5><a href="#"><?= $this->session->myname ?></a> </h5>
            </div>

            <!--- Sidemenu -->
            <div id="sidebar-menu">

                <ul class="metismenu" id="side-menu">
                    <li>
                        <a href="<?= base_url('dashboard.html') ?>">
                            <i class="fa fa-dashboard"></i> <span> Dashboard </span>
                        </a>
                    </li>

                    <?php if($this->session->mylevel == 1): ?>
                    
                    <li>
                        <a href="<?= base_url('users.html') ?>">
                            <i class="fa fa-users"></i> <span> Users List </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('video-thumb.html') ?>">
                            <i class="fa fa-user"></i> <span> Video & Thumbnail </span>
                        </a>
                    </li>
                    
                    <?php endif; ?>

                    <li>
                        <a href="<?= base_url('contact.html') ?>">
                            <i class="fa fa-book"></i> <span> Contact List </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('send-email.html') ?>">
                            <i class="fa fa-envelope"></i> <span> Send Email </span>
                        </a>
                    </li>

                    <li>
                        <a href="<?= base_url('logout.html') ?>">
                            <i class="fa fa-power-off"></i> <span> Logout </span>
                        </a>
                    </li>

                </ul>

            </div>
            <!-- Sidebar -->

            <div class="clearfix"></div>

        </div>
        <!-- Sidebar -left -->

    </div>
    <!-- Left Sidebar End -->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->

    <div class="content-page">

        <!-- Top Bar Start -->
        <div class="topbar">

            <nav class="navbar-custom">

                <ul class="list-unstyled topbar-right-menu float-right mb-0">

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="<?= base_url('templates/img/sc_logo.png') ?>" alt="user" class="rounded-circle"> <span class="ml-1"><?= $this->session->myname ?><i class="mdi mdi-chevron-down"></i> </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h6 class="text-overflow m-0"></h6>
                            </div>

                            <!-- item-->
                            <a href="<?= base_url('profile.html') ?>" class="dropdown-item notify-item">
                                <i class="fi-head"></i> <span>Profile</span>
                            </a>

                            <!-- item-->
                            <button type="button" id="btn-logout" class="dropdown-item notify-item">
                                <i class="fi-power"></i> <span>Logout</span>
                            </button>
                            <!-- <a href="#" id="href-logout" class="dropdown-item notify-item">
                                <i class="fi-power"></i> <span>Logout</span>
                            </a> -->

                        </div>
                    </li>

                </ul>

                <ul class="list-inline menu-left mb-0">
                    <li class="float-left">
                        <button class="button-menu-mobile open-left">
                            <i class="dripicons-menu"></i>
                        </button>
                    </li>
                    <li>
                        <div class="page-title-box">
                            <h4 class="page-title"><?= $title ?></h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item active">Selamat datang <?= $this->session->myname ?></li>
                            </ol>
                        </div>
                    </li>

                </ul>

            </nav>

        </div>
        <!-- Top Bar End -->

        <!-- Start Page content -->
        <div class="content">
            <div class="container-fluid">
                <?= $this->load->view($content); ?>
            </div> <!-- container -->

        </div> <!-- content -->

        <footer class="footer">
            2021 © kadetech.co.id
        </footer>

    </div>
    <!-- ============================================================== -->
    <!-- End Right content here -->
    <!-- ============================================================== -->
</div>