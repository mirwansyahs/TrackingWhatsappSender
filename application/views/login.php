<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Dewaspray Store | Log in</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="<?= site_url() ?>assets/plugins/fontawesome-free/css/all.min.css">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="<?= site_url() ?>assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?= site_url() ?>assets/css/adminlte.min.css">
    </head>
    <body class="hold-transition login-page">

        <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
        <a href="<?= base_url() ?>Auth" class="h1"><b>Login</b></a>
        </div>
        <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <?php if (@$this->session->flashdata('error') !== null) : ?>
            <div class="alert alert-danger" role="alert"><?= @$this->session->flashdata('error') ?></div>
        <?php endif ?>

        <?php if (@$this->session->flashdata('message') !== null) : ?>
            <div class="alert alert-success" role="alert"><?= @$this->session->flashdata('message') ?></div>
        <?php endif ?>

        <form action="<?= base_url() ?>Auth/secure" method="post">
            <div class="input-group mb-3">
                <input type="text" class="form-control" name="username" placeholder="Username" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <input type="password" class="form-control" name="password" placeholder="Password" required>
                <div class="input-group-append">
                    <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                    </div>
                </div>
            </div>
            <div class="social-auth-links text-center mt-2 mb-3">
                <button type="submit" class="btn btn-block btn-primary"> Login
                </button>
            </div>
            <!-- /.social-auth-links -->
        </form>
    </div>
    <!-- /.card -->
</div>
<!-- /.login-box -->

        <!-- jQuery -->
        <script src="<?= site_url() ?>assets/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="<?= site_url() ?>assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="<?= site_url() ?>assets/js/adminlte.min.js"></script>
    </body>
</html>
