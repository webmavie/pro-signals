<?php
    if ($_COOKIE['un']!==getOption('admin_username') AND $_COOKIE['pw']!==getOption('admin_password')) {
        header('Location: '.base_url('byadmin/login'));
        exit;
    }
?>
<!DOCTYPE html>
<html lang="az">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Control panel</title>

    <!-- Custom fonts for this template-->
    <link href="<?=dist_url('admin/')?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>

    <!-- Custom styles for this template-->
    <link href="<?=dist_url('admin/')?>css/sb-admin-2.min.css" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/11.0.1/classic/ckeditor.js"></script> -->
    <script src="https://s3.amazonaws.com/ephox-static-ephox-com/jsfiddle/textboxio/textboxio.js"></script>

    <!-- Custom styles for this page -->
    
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    
    <style type="text/css">
        .card-header > .h5 {
            word-wrap: break-word !important;
        }
    </style>

</head>

<body id="page-top">

<?php
        if (isset($_SESSION['flashback']) == TRUE) {
            $response=json_decode($_SESSION['flashback'], TRUE);
            echo "<script>
            Swal.fire(
                '{$response['title']}',
                '{$response['text']}',
                '{$response['status']}'
            );
            </script>";
            unset($_SESSION['flashback']);
        }
?>

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion d-none d-sm-inline-block" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=this_url()?>">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Control <sup>panel</sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?=$page=='dashboard'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/dashboard')?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Homepage</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                General
            </div>
            <!-- Nav Items -->
            <li class="nav-item <?=$page=='options'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/options')?>">
                    <i class="fas fa-cog"></i>
                    <span>Options</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='sections'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/sections')?>">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Sections</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='newsletter'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/newsletter')?>">
                    <i class="fas fa-fw fa-at"></i>
                    <span>Newsletter users</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='users'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/users')?>">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Users</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='user_says'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/user_says')?>">
                    <i class="fas fa-fw fa-comment"></i>
                    <span>User says</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='slides'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/slides')?>">
                    <i class="fas fa-fw fa-image"></i>
                    <span>Slides</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='results'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/results')?>">
                    <i class="fas fa-fw fa-chart-line"></i>
                    <span>Results</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='we_offer'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/we_offer')?>">
                    <i class="fas fa-fw fa-tasks"></i>
                    <span>We offer</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='packages'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/packages')?>">
                    <i class="fas fa-fw fa-box"></i>
                    <span>Packages</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='skills'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/skills')?>">
                    <i class="fas fa-fw fa-cogs"></i>
                    <span>Skills</span>
                </a>
            </li>
            <li class="nav-item <?=$page=='faq'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/faq')?>">
                    <i class="fas fa-fw fa-question"></i>
                    <span>FAQ</span>
                </a>
            </li>

            <li class="nav-item <?=$page=='logs'?'active':''?>">
                <a class="nav-link" href="<?=base_url('byadmin/logs')?>">
                    <i class="fas fa-fw fa-list"></i>
                    <span>Logs</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item">
                <a class="nav-link" href="<?=action_url(array('act' => 'exit_admin'))?>" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-sign-out-alt fa-fw"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" onfocus="return $('#accordionSidebar').removeClass('d-none');" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=getOption('site_name')?></span>
                                <img class="img-profile rounded-circle" src="<?=dist_url('admin/')?>img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="<?=base_url()?>" target="_blank">
                                    <i class="fas fa-eye fa-sm fa-fw mr-2 text-gray-400"></i>
                                    See website
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?=action_url(array('act' => 'exit_admin'))?>" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2  text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->