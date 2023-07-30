<div class="card card-primary card-outline card-outline-tabs">
    <div class="card-header p-0 border-bottom-0">
        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="dataProduk-tab" data-toggle="pill" href="#dataProduk" role="tab"
                    aria-controls="dataProduk" aria-selected="true">Data Produk</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="variasiHarga-tab" data-toggle="pill" href="#variasiHarga" role="tab"
                    aria-controls="variasiHarga" aria-selected="false">Variasi Harga</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content" id="custom-tabs-four-tabContent">
            <div class="tab-pane fade show active" id="dataProduk" role="tabpanel" aria-labelledby="dataProduk-tab">
                <form method="POST" action="<?= base_url('admin/produk/addProccess' ) ?>">
                    <div class="card-body">
                        <small style="color: red">Silahkan submit terlebih dahulu, sebelum menambahkan variasi harga.</small>
                        <?php if ($this->session->flashdata('error') !== null) : ?>
                        <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error') ?></div>
                        <?php endif ?>

                        <?php if ($this->session->flashdata('message') !== null) : ?>
                        <div class="alert alert-success" role="alert"><?= $this->session->flashdata('message') ?></div>
                        <?php endif ?>

                        <div class="form-group">
                            <label>Nama Produk</label>
                            <input type="text" class="form-control" id="nama_barang" name="nama_barang">
                        </div>
                        <div class="form-group">
                            <label>Kelompok Produk</label>
                            <input type="text" class="form-control" id="kelompok_barang" name="kelompok_barang"
                                autocomplte="off">
                        </div>
                        <div class="form-group">
                            <label>Berat Produk (Gram)</label>
                            <input type="number" class="form-control" id="berat" name="berat" autocomplete="off">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="variasiHarga" role="tabpanel" aria-labelledby="variasiHarga-tab">

                <form method="POST" action="<?= base_url('admin/produk/' ) ?>">
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th width="5%">#</th>
                                <th width="35%">Variasi</th>
                                <th width="25%">Harga</th>
                                <th width="15%">.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $no = 1;
                                for ($i = 0; $i < 10; $i++){
                            ?>
                            <tr>
                                <td width="5%"><?=$no++?></td>
                                <td width="35%">
                                    <input type="text" name="nama_variasi" id="nama_variasinew<?=$i?>"
                                        class="form-control">
                                    <input type="hidden" name="produk_variasi_id" id="produk_variasi_idnew<?=$i?>"
                                        class="form-control" value="--">
                                </td>
                                <td width="25%">
                                    <input type="text" name="harga" id="harganew<?=$i?>" class="form-control">
                                </td>
                                <td width="15%" class="text-center">
                                    <a name="" id="" class="btn btn-primary btn-sm" onclick="btnSimpan('new<?=$i?>')"
                                        role="button"><i class="fa fa-edit"> Simpan</i></a>
                                </td>
                            </tr>
                            <?php } ?>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function btnSimpan(variasi_id = ''){
        produk_variasi_id   = $('#produk_variasi_id'+variasi_id).val();
        nama_variasi        = $('#nama_variasi'+variasi_id).val();
        harga               = $('#harga'+variasi_id).val();
        
        $.post('<?=base_url()?>/admin/variasi/create', 'nama_variasi='+nama_variasi+'&harga='+harga+'&kode_barang=<?=$Produk->kode_barang?>&produk_variasi_id='+produk_variasi_id, function(data){
            alert(data);
        });
    }
</script>
<?=$this->session->flashdata('msg')?>