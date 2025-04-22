<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BOM Apps - Rencana Material</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="<?= base_url('template') ?>/plugins/fontawesome-free/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="<?= base_url('template') ?>/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('template') ?>/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="<?= base_url('template') ?>/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url('template') ?>/dist/css/adminlte.min.css">
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('Home/Logout') ?>">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="<?= base_url('template') ?>/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Rencana Material</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="<?= base_url('template') ?>/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?= session()->get('nama_user') ?></a>
                    </div>
                </div>

                <?php $level = session()->get('level'); ?>

                <!-- Untuk Super Admin (Level 1) -->
                <?php if ($level == 1): ?>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="<?= base_url('Admin') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link <?= $menu == 'supplier' || $page == 'admin/v_material' || $menu == 'produk' || $menu == 'process_step' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-recycle"></i>
                                    <p>
                                        Master Data
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('Material') ?>" class="nav-link <?= $page == 'admin/v_material' ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Bahan Baku (Materials)
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Supplier') ?>" class="nav-link <?= $menu == 'supplier' ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Supplier
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Produk') ?>" class="nav-link <?= $menu == 'produk' ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Produk Jadi</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('ProcessStep') ?>" class="nav-link <?= $menu == 'process_step' ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Proses Produksi</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link <?= $menu == 'pembelian' || $page == 'admin/v_hasil_tahap1' || $page == 'admin/v_hasil_tahap2' || $page == 'admin/v_hasil_tahap3' || $page == 'admin/v_hasil_tahap4' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-shopping-basket"></i>
                                    <p>
                                        Manajemen Stok
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('Pembelian') ?>" class="nav-link <?= $menu == 'pembelian' ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Pembelian (Inventori)
                                            </p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="#" class="nav-link <?= $page == 'admin/v_hasil_tahap1' || $page == 'admin/v_hasil_tahap2' || $page == 'admin/v_hasil_tahap3' || $page == 'admin/v_hasil_tahap4' ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>
                                                Hasil Proses Produksi
                                                <i class="fas fa-angle-left right"></i>
                                            </p>
                                        </a>
                                        <ul class="nav nav-treeview">
                                            <li class="nav-item">
                                                <a href="<?= base_url('Material/index/tahap1') ?>" class="nav-link <?= $page == 'admin/v_hasil_tahap1' ? 'active' : '' ?>">
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Pembahanan (Tahap 1)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Material/index/tahap2') ?>" class="nav-link <?= $page == 'admin/v_hasil_tahap2' ? 'active' : '' ?>">
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Bentuk Dasar (Tahap 2)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Material/index/tahap3') ?>" class="nav-link <?= $page == 'admin/v_hasil_tahap3' ? 'active' : '' ?>">
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Rakit 1 (Tahap 3)</p>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="<?= base_url('Material/index/tahap4') ?>" class="nav-link <?= $page == 'admin/v_hasil_tahap4' ? 'active' : '' ?>">
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Finishing (Tahap 4)</p>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link <?= $menu == 'bom' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-bookmark"></i>
                                    <p>
                                        BOM
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/1') ?>" class="nav-link <?= $page == 1 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pembahanan (Tahap 1)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/2') ?>" class="nav-link <?= $page == 2 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Bentuk Dasar (Tahap 2)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/3') ?>" class="nav-link <?= $page == 3 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Rakit 1 (Tahap 3)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/4') ?>" class="nav-link <?= $page == 4 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Finishing (Tahap 4)</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Produksi') ?>" class="nav-link <?= $menu == 'produksi' ? 'active' : '' ?>">
                                    <i class="fas fa-pallet nav-icon"></i>
                                    <p>
                                        Perencanaan Produksi (MRP)
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Order') ?>" class="nav-link <?= $menu == 'order' ? 'active' : '' ?>">
                                    <i class="fas fa-tasks nav-icon"></i>
                                    <p>
                                        Order Produksi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Eksekusi') ?>" class="nav-link <?= $menu == 'eksekusi' ? 'active' : '' ?>">
                                    <i class="fas fa-shipping-fast nav-icon"></i>
                                    <p>
                                        Eksekusi Produksi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Approval') ?>" class="nav-link <?= $menu == 'approval' ? 'active' : '' ?>">
                                    <i class="fas fa-check nav-icon"></i>
                                    <p>
                                        Approval Produksi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Laporan') ?>" class="nav-link <?= $menu == 'laporan' ? 'active' : '' ?>">
                                    <i class="far fa-folder nav-icon"></i>
                                    <p>
                                        Laporan Stok
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Laporan/laporanRealisasi') ?>" class="nav-link <?= $menu == 'laporanRealisasi' ? 'active' : '' ?>">
                                    <i class="far fa-folder nav-icon"></i>
                                    <p>
                                        Laporan Realisasi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('User') ?>" class="nav-link <?= $menu == 'user' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-id-card"></i>
                                    <p>
                                        User
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                <?php endif; ?>

                <!-- Untuk Manajer Produksi (Level 2) -->
                <?php if ($level == 2): ?>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="<?= base_url('Admin') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Laporan') ?>" class="nav-link <?= $menu == 'laporan' ? 'active' : '' ?>">
                                    <i class="far fa-folder nav-icon"></i>
                                    <p>
                                        Laporan
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

                <!-- Untuk CS (Level 3) -->
                <?php if ($level == 3): ?>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="<?= base_url('Admin') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Produksi') ?>" class="nav-link <?= $menu == 'produksi' ? 'active' : '' ?>">
                                    <i class="fas fa-pallet nav-icon"></i>
                                    <p>
                                        Perencanaan Produksi (MRP)
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Order') ?>" class="nav-link <?= $menu == 'order' ? 'active' : '' ?>">
                                    <i class="fas fa-tasks nav-icon"></i>
                                    <p>
                                        Order Produksi
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

                <!-- Untuk Manajer Gudang (Level 4) -->
                <?php if ($level == 4): ?>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="<?= base_url('Admin') ?>" class="nav-link <?= $menu == 'dashboarad' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Laporan') ?>" class="nav-link <?= $menu == 'laporan' ? 'active' : '' ?>">
                                    <i class="far fa-folder nav-icon"></i>
                                    <p>
                                        Laporan
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>

                <!-- Untuk PPC (Level 5) -->
                <?php if ($level == 5): ?>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="<?= base_url('Admin') ?>" class="nav-link <?= $menu == 'dashboarad' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link <?= $menu == 'bom' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-bookmark"></i>
                                    <p>
                                        BOM
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/1') ?>" class="nav-link <?= $page == 1 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Pembahanan (Tahap 1)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/2') ?>" class="nav-link <?= $page == 2 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Bentuk Dasar (Tahap 2)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/3') ?>" class="nav-link <?= $page == 3 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Rakit 1 (Tahap 3)</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="<?= base_url('Bom/index/4') ?>" class="nav-link <?= $page == 4 ? 'active' : '' ?>">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Finishing (Tahap 4)</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <li class="nav-item">
                            <a href="<?= base_url('Order') ?>" class="nav-link <?= $menu == 'order' ? 'active' : '' ?>">
                                <i class="fas fa-tasks nav-icon"></i>
                                <p>
                                    Order Produksi
                                </p>
                            </a>
                        </li>
                    </nav>
                <?php endif; ?>
                
                <!-- Untuk SPV (Level 6) -->
                <?php if ($level == 6): ?>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="<?= base_url('Admin') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Order') ?>" class="nav-link <?= $menu == 'order' ? 'active' : '' ?>">
                                    <i class="fas fa-tasks nav-icon"></i>
                                    <p>
                                        Order Produksi
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Eksekusi') ?>" class="nav-link <?= $menu == 'eksekusi' ? 'active' : '' ?>">
                                    <i class="fas fa-shipping-fast nav-icon"></i>
                                    <p>
                                        Eksekusi Produksi
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
                
                <!-- Untuk QC (Level 7) -->
                <?php if ($level == 7): ?>
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                            <li class="nav-item">
                                <a href="<?= base_url('Admin') ?>" class="nav-link <?= $menu == 'dashboard' ? 'active' : '' ?>">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>
                                        Dashboard
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="<?= base_url('Approval') ?>" class="nav-link <?= $menu == 'approval' ? 'active' : '' ?>">
                                    <i class="fas fa-check nav-icon"></i>
                                    <p>
                                        Approval Produksi
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                <?php endif; ?>
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0"><?= $judul ?></h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#"><?= $judul ?></a></li>
                                <li class="breadcrumb-item active"><?= $subjudul ?></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- isi konten -->
                        <?php
                        if ($page) {
                            echo view($page);
                        }
                        ?>
                        <!-- /.isi konten -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2025 <a href="https://adminlte.io">BOM</a>.</strong> All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('template') ?>/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('template') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= base_url('template') ?>/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/jszip/jszip.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= base_url('template') ?>/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('template') ?>/dist/js/adminlte.min.js"></script>
    <script>
        $(function() {
            $('.datatable').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });
    </script>
</body>

</html>