<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dewaspray Store | <?= @$sub_title ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/') ?>plugins/select2/css/select2.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= base_url('assets/') ?>css/adminlte.min.css">
</head>
<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="<?= base_url() ?>" class="navbar-brand">
                    <!-- <img src="<?= base_url('assets/') ?>img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> -->
                    <span class="brand-text font-weight-light">Dewaspray Store</span>
                </a>

                <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">
                    <!-- Left navbar links -->
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a href="<?= base_url('home') ?>" class="nav-link">Cek Ongkir</a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= base_url() ?>auth" class="nav-link">Login</a>
                        </li>
                    
                    </ul>
                
                </div>

                
            </div>
        </nav>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container">
        <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0"><?=@$sub_title ?></h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('home') ?>">Cek Ongkir</a></li>
            </ol>
        </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container">
        <!-- general form elements -->
        <div class="card card">
            <div class="card-header">
                <h3 class="card-title"></h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form method="POST" action="<?= base_url('admin/ongkir') ?>">
                <div class="card-body">
                    <?php if (@$this->session->flashdata('error') !== null) : ?>
                        <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error') ?></div>
                    <?php endif ?>

                    <?php if (@$this->session->flashdata('message') !== null) : ?>
                        <div class="alert alert-success" role="alert"><?= $this->session->flashdata('message') ?></div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Provinsi Tujuan</label>
                                        <select id="province_destination" name="province_destination" class="form-control select2"  style="width: 100%;">
                                            <option selected disabled>Pilih...</option>
                                            <?php foreach ($Provinsi as $key => $value) { ?>
                                                <option value="<?= $value->province_id ?>"><?= $value->province ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kota Tujuan</label>
                                        <select id="city_destination" name="city_destination" class="form-control select2"  style="width: 100%;">
                                            <option selected disabled>Pilih...</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Kecamatan Tujuan</label>
                                        <select id="subdis_destination" name="subdis_destination" class="form-control select2"  style="width: 100%;">
                                            <option selected disabled>Pilih...</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Produk</label>
                                        <select id="kode_barang" name="kode_barang" class="form-control select2"  style="width: 100%;">
                                            <option selected disabled>Pilih...</option>
                                            <?php foreach ($Produk as $key => $value) { ?>
                                                <option data-berat="<?= $value->berat ?>" value="<?= $value->kode_barang ?>"><?= $value->nama_barang ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="weight" class="form-label">Quantity</label>
                                        <input type="number" id="quantity" name="quantity" class="form-control" min="1">
                                    </div>
                                    <div class="mb-3">
                                        <label for="weight" class="form-label">Berat (g)</label>
                                        <input type="number" id="weight" name="weight" class="form-control" min="1">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kurir</label>
                                        <select id="courier" name="courier" class="form-control">
                                            <option selected disabled>Pilih...</option>
                                            <?php foreach (cek_expedisi() as $key => $value) { ?>
                                            <option value="<?= $key ?>"><?= $value ?></option>
                                        <?php } ?>
                                        </select>
                                    </div>
                                    <button type="button" id="btn_cek" class="btn btn-primary btn-block mb-3">Cek</button>
                                </div>
                            </div>
                        </div>

                        
                        <div class="col-md-4">
                            <div id="result_text"></div>
                        </div>
                    </div>

                    <div id="result" class="mt-3">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Layanan</th>
                                    <th>Estimasi</th>
                                    <th>Biaya</th>
                                    <th>Deskripsi</th>
                                </tr>
                            </thead>
                            <tbody id="result_cost">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </form>
        </div>
        <!-- /.card -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
            Anything you want
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2023 All rights reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <script src="<?= base_url('assets/') ?>plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url('assets/') ?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="<?= base_url('assets/') ?>plugins/select2/js/select2.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url('assets/') ?>js/adminlte.min.js"></script>
<script>
function copyToClipboard(params) {
    let textarea = $(params);
    textarea.select();
    document.execCommand('copy');
    alert("Text berhasil dicopy!");
}

$(document).ready(function () {
    $('.select2').select2()

    $('select[name="kode_barang"]').on('change', function () {
        const barang = $('#kode_barang');
        $('#weight').val(barang.find(':selected').data('berat'));
        $("#quantity").val(1)
    });

    $('#quantity').on('change', function () {
        const oldQty = $(this).val()
        const weight = $("#weight").val()
        $("#weight").val(oldQty * weight)
    });

    $('select[name="province_origin"]').on('change', function () {
        let provinceId = $(this).val();

        if (provinceId) {
            $.ajax({
                url: '<?= base_url() ?>home/city/' + provinceId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    alert(data);
                    $('select[name="city_origin"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="city_origin"]').append('<option value="'+ value.city_id +'">'+ value.type + ' ' + value.city_name +'</option>');
                    });
                }
            });
        } else {
            $('select[name="city_origin"]').empty();
        }
    });

    $('select[name="province_destination"]').on('change', function () {
        let provinceId = $(this).val();

        if (provinceId) {
            $.ajax({
                url: '<?= base_url() ?>home/city/' + provinceId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('select[name="city_destination"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="city_destination"]').append('<option value="'+ value.city_id +'"> '+ value.type + ' ' + value.city_name +'</option>');
                    });
                }
            });
        } else {
            $('select[name="city_destination"]').empty();
        }
    });


    $('select[name="city_origin"]').on('change', function () {
        let cityId = $(this).val();

        if (cityId) {
            $.ajax({
                url: '<?= base_url() ?>home/subdis/' + cityId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('select[name="subdis_origin"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="subdis_origin"]').append('<option value="'+ value.subdistrict_id +'">'+ value.subdistrict_name +'</option>');
                    });
                }
            });
        } else {
            $('select[name=subdis_origin"]').empty();
        }
    });

    $('select[name="city_destination"]').on('change', function () {
        let cityId = $(this).val();

        if (cityId) {
            $.ajax({
                url: '<?= base_url() ?>home/subdis/' + cityId,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    $('select[name="subdis_destination"]').empty();
                    $.each(data, function (key, value) {
                        $('select[name="subdis_destination"]').append('<option value="'+ value.subdistrict_id +'"> '+ value.subdistrict_name +'</option>');
                    });
                }
            });
        } else {
            $('select[name="subdis_destination"]').empty();
        }
    });


    $('#btn_cek').on('click', function () {
        let originId = "2964";
        let desId = $('#subdis_destination').val();
        let weight = $('#weight').val();
        let kode_barang = $('#kode_barang').val();
        let courier = $('#courier').val();
        let quantity = $('#quantity').val();

        if (originId && desId && weight && courier) {
            $.ajax({
                url: '<?= base_url() ?>home/cek/' + originId + "/" + desId + "/"+ weight + "/" + courier + "/" + quantity + "/" + kode_barang,
                type: 'GET',
                dataType: 'json',
                success: function (data) {
                    if(data == ""){
                        $('#result_cost').html("Kurir tidak mendukung!")
                    } else {
                        $('#result_cost').html(data.result)
                        $.each(data, function(i, item) {
                            $('#result_text').html(data.copy_text)
                        });
                    }
                }
            });
        } else {
            alert("Semua data harus diisi.")
        }
    });   
});
</script>
</body>
</html>
