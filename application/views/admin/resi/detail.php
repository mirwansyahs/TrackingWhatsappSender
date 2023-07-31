<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><a class="btn btn-primary btn-sm"
                            href="<?= base_url('admin/resi') ?>">Kembali</a></h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <?php if ($this->session->flashdata('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error') ?></div>
                    <?php endif ?>

                    <?php if ($this->session->flashdata('message') !== null) : ?>
                    <div class="alert alert-success" role="alert"><?= $this->session->flashdata('message') ?></div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-md-12">
                            <table border="0" width="100%">
                                <tr>
                                    <td width="5%">Nomor Resi</td>
                                    <td width="1%" class="text-center">:</td>
                                    <td width="20%"><?= $Resi->no_resi ?></td>


                                    <td width="5%">Nomor Telpon</td>
                                    <td width="1%" class="text-center">:</td>
                                    <td width="10%"><?= $Resi->no_telp ?></td>
                                </tr>
                                <tr>
                                    <td width="5%">Expedisi</td>
                                    <td width="1%" class="text-center">:</td>
                                    <td width="20%"><?= expedisi($Resi->ekspedisi) ?></td>


                                    <td width="5%">Tanggal Pencatatan</td>
                                    <td width="1%" class="text-center">:</td>
                                    <td width="10%"><?= str_replace('-', '/', $Resi->tanggal_pencatatan) ?></td>
                                </tr>
                                <tr>
                                    <td width="5%">Nama Customer</td>
                                    <td width="1%" class="text-center">:</td>
                                    <td width="20%"><?= $Resi->nama_customer ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover" style="margin-top: 30px">
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>Deskripsi</th>
                                <th>Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($Resis as $key => $value) { ?>
                            <tr>
                                <td><?= $value->date ?></td>
                                <td><?= $value->description ?></td>
                                <td><?= $value->location ?></td>
                            </tr>
                            <?php } ?>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
</div><!-- /.container-fluid -->