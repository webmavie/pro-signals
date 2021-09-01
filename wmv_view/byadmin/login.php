<?php
    if ($_COOKIE['un']==getOption('admin_username') AND $_COOKIE['pw']==getOption('admin_password')) {
        header('Location: '.base_url('byadmin/dashboard'));
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
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="<?=dist_url('admin/')?>css/sb-admin-2.min.css" rel="stylesheet">

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gradient-primary">

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

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Hello sir</h1>
                                    </div>
                                    <form class="user" method="POST" action="<?=action_url()?>">
                                        <div class="form-group">
                                            <input type="text" name="username" class="form-control  form-control-user" placeholder="Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="password" name="password" class="form-control  form-control-user" placeholder="Password">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label"  for="customCheck">Remember me</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="form" value="login_admin">
                                        <button class="btn btn-primary btn-user btn-block">
                                            Sign in
                                        </button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?=dist_url('admin/')?>vendor/jquery/jquery.min.js"></script>
    <script src="<?=dist_url('admin/')?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?=dist_url('admin/')?>vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?=dist_url('admin/')?>js/sb-admin-2.min.js"></script>

</body>

</html>