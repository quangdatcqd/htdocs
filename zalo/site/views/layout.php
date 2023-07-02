<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Ample lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Ample admin lite dashboard  dashboard template">
    <meta name="description" content="Ample Admin Lite is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    <title>ĐẠT C</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css">
    <!-- Favicon icon -->

    <!-- Custom CSS -->
    <link href="./../site/views/css/style.min.css" rel="stylesheet">
</head>

<body class="">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full" data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <header class="topbar zindex-13" data-navbarbg="skin5">
            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                <div class="navbar-header  " data-logobg="skin6">
                    <!-- ============================================================== -->
                    <!-- Logo -->
                    <!-- ============================================================== -->
                    <a class="navbar-brand" href="/zalo/xac-minh-ban-be/">
                        <!-- Logo icon -->
                        <b class="logo-icon">
                            <!-- Dark Logo icon -->
                            <img src="./../site/views/plugins/images/logo-icon.png" alt="homepage" />
                        </b>
                        <!--End Logo icon -->
                        <!-- Logo text -->
                        <span class="logo-text">
                            <!-- dark Logo text -->
                            <img src="./../site/views/plugins/images/logo-text.png" alt="homepage" />
                        </span>
                    </a>
                    <!-- ============================================================== -->
                    <!-- End Logo -->
                    <!-- ============================================================== -->
                    <!-- ============================================================== -->
                    <!-- toggle and nav items -->
                    <!-- ============================================================== -->
                    <a class="nav-toggler waves-effect waves-light text-dark d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
                </div>

                <div class=" w-100">
                    <h4 class="box-title text-center  py-1 fw-bolder text-light"><?php
                                                                                    if (!isset($pagename)) echo "TRANG CHỦ";
                                                                                    else echo $pagename;
                                                                                    ?></h4>
                </div>

            </nav>
        </header>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <aside class="left-sidebar" data-sidebarbg="skin6">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <!-- User Profile-->
                        <li class="sidebar-item pt-2">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/zalo/xac-minh-ban-be/" aria-expanded="false">
                                <i class="bi bi-people-fill"></i>
                                <span class="hide-menu">Xác Minh Bạn Bè</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/zalo/check-voucher/" aria-expanded="false">
                                <i class="bi bi-pip-fill"></i>
                                <span class="hide-menu">Check VouCher</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/zalo/lay-so-dien-thoai/" aria-expanded="false">
                                <i class="bi bi-table" aria-hidden="true"></i>
                                <span class="hide-menu">Lấy Số</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/zalo/bigc-check/" aria-expanded="false">
                                <i class="bi bi-pip-fill"></i>
                                <span class="hide-menu">Bigc check</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/zalo/mapbank/" aria-expanded="false">
                                <i class="bi bi-pip-fill"></i>
                                <span class="hide-menu">Liên kết ngân hàng</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="/zalo/map-bank-octo/" aria-expanded="false">
                                <i class="bi bi-pip-fill"></i>
                                <span class="hide-menu">Liên kết ngân hàng octo</span>
                            </a>
                        </li>

                    </ul>

                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>
        <button onclick="topFunction()" id="myBtn" title="Go to top"><i class="bi bi-arrow-up-square"></i></button>

        <div class="page-wrapper  ">

            <div class="container-fluid p-0">
                <?php
                if (is_file($pathfile)) require_once $pathfile;
                else  require_once  "./../site/views/404.php";
                ?>


            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer text-center"> 2021 © QĐ</a>
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <!-- <script src="./../site/views/plugins/bower_components/jquery/dist/jquery.min.js"></script> -->
    <!-- Bootstrap tether Core JavaScript -->
    <!-- <script src="./../site/views/bootstrap/dist/js/bootstrap.bundle.min.js"></script> -->
    <!-- <script src="./../site/views/js/app-style-switcher.js"></script> -->
    <!-- <script src="./../site/views/plugins/bower_components/jquery-sparkline/jquery.sparkline.min.js"></script> -->
    <!--Wave Effects -->
    <!-- <script src="./../site/views/js/waves.js"></script> -->
    <!--Menu sidebar -->
    <!-- <script src="./../site/views/js/sidebarmenu.js"></script> -->
    <!--Custom JavaScript -->
    <script src="./../site/views/js/custom.js"></script>
    <!--This page JavaScript -->


</body>

</html>