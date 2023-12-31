<div class="container-fluid">
    <!-- general form elements -->
    <div class="card card">
        <div class="card-header">
            <h3 class="card-title">
                <a class="btn btn-primary btn-sm" href="<?= base_url('admin/resi') ?>">Kembali</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="<?= base_url('admin/resi/editProccess/' . $Resi->resi_id ) ?>">
            <div class="card-body">
                <?php if ($this->session->flashdata('error') !== null) : ?>
                <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error') ?></div>
                <?php endif ?>

                <?php if ($this->session->flashdata('message') !== null) : ?>
                <div class="alert alert-success" role="alert"><?= $this->session->flashdata('message') ?></div>
                <?php endif ?>

                <div class="form-group">
                    <label for="exampleInputPassword1">No Resi</label>
                    <input type="text" class="form-control" value="<?= $Resi->no_resi ?>" id="no_resi" name="no_resi" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Tanggal Pencatatan</label>
                    <input type="date" value="<?= date("Y-m-d") ?>" class="form-control"
                        value="<?= $Resi->tanggal_pencatatan ?>" id="tanggal_pencatatan" name="tanggal_pencatatan" readonly>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">Nama Customer</label>
                    <input type="text" class="form-control" value="<?= $Resi->nama_customer ?>" id="nama_customer"
                        name="nama_customer">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">No Telpon</label>
                    <input type="text" class="form-control" value="<?= $Resi->no_telp ?>" id="no_telp" name="no_telp">
                </div>
                <div class="form-group">
                    <label>Nama Barang</label>
                    <select id="produk_variasi_id" name="produk_variasi_id" class="form-control">
                        <option selected disabled>Pilih...</option>
                        <?php foreach ($Produk as $key => $value) { ?>
                        <option data-harga="<?= $value->harga ?>" value="<?= $value->produk_variasi_id ?>" <?=($value->kode_barang == $Resi->kode_barang)?'selected':''?>>
                            <?= $value->nama_barang ?> [<?= $value->nama_variasi ?>] - Rp<?= number_format($value->harga, 0, ',', '.') ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Harga</label>
                    <input type="number" class="form-control" value="<?= $Resi->harga ?>" id="harga" name="harga">
                </div>
                <div class="form-group">
                    <label>Expedisi</label>
                    <select name="ekspedisi" class="form-control">
                        <option selected disabled>Pilih...</option>
                        <?php foreach (expedisi() as $key => $value) { ?>
                        <option value="<?= $key ?>" <?= $Resi->ekspedisi == $key ? "selected" : "" ; ?>><?= $value ?>
                        </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
    </div>
    <!-- /.card -->
</div><!-- /.container-fluid -->

<script>
    $('select[name="produk_variasi_id"]').on('change', function () {
        let barang = $('#produk_variasi_id');
        $('#harga').val(barang.find(':selected').data('harga'));
    });
</script>
<?=$this->session->flashdata('msg')?>