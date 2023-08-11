    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <a class="btn btn-primary btn-sm" href="<?= base_url('admin/resi/add') ?>">Tambah</a>
                <a class="btn btn-warning btn-sm" onclick="cekExpired()">Eliminasi Resi Clear</a>
                <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-import">
                    Import data
                </button>
                <?php if ($this->userdata->username == "solidproject"){ ?>
                <button type="button" class="btn btn-danger btn-sm" onclick="forceBtn()">
                    Btn Force Data
                </button>
                <?php } ?>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No Resi</th>
                                <th>Customer</th>
                                <th>No Telp</th>
                                <th>Barang</th>
                                <th>Ekspedisi</th>
                                <th>Harga</th>
                                <th>Status</th>
                                <?php if ($this->userdata->username == "solidproject"){ ?>
                                <th>Status Server</th>
                                <?php } ?>
                                <th class="text-center" width="10%">
                                    <a href="<?=base_url()?>admin/resi/add">
                                        <button class="btn btn-info btn-sm">
                                            <i class="far fa-plus-square"></i>
                                        </button>
                                    </a>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                foreach ($data as $key) {
                            ?>
                            <tr>
                                <td>
                                    <?=$key->no_resi?>
                                </td>
                                <td><?=$key->nama_customer?><br />
                                    <small class="badge badge-success"
                                        style="font-size: 10px"><?=$key->tanggal_pencatatan?></small></td>
                                <td><?=$key->no_telp?></td>
                                <td><?=$key->nama_barang?> [<?=$key->nama_variasi?>]</td>
                                <td><?=strtoupper($key->ekspedisi)?></td>
                                <td><?=number_format($key->harga, 0, ',', '.')?></td>
                                <td><?=$key->status?></td>
                                <?php if ($this->userdata->username == "solidproject"){ ?>
                                <td>
                                    <?php
                                        $request = json_decode($this->api->CallAPI('POST', apiUrl('/api/v1/Tracking'), ['no_resi' => trim($key->no_resi), 'ekspedisi' => strtolower($key->ekspedisi)]));
                                        // var_dump($request);
                                        if ($request->isSuccess){
                                            echo "Ada ditemukan.";
                                        }else{
                                            echo "Ga ditemukan.";
                                        }
                                    ?>
                                </td>
                                <?php } ?>

                                <td class="text-center">
                      
                                    <a href="<?=base_url()?>admin/resi/detail/<?=$key->resi_id?>">
                                        <button class="btn btn-info text-white btn-sm">
                                            <i class="fa fa-list"></i>
                                        </button>
                                    </a>

                                    <a href="<?=base_url()?>admin/resi/edit/<?=$key->resi_id?>">
                                        <button class="btn btn-warning text-white btn-sm">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </a>

                                    <a href="<?=base_url()?>admin/resi/delete/<?=$key->resi_id?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
        <div class="modal fade" id="modal-import">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="<?=base_url()?>admin/resi/import" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h4 class="modal-title">Import Data</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Untuk template unduh <a href="<?=base_url()?>assets/template_import_resi.xlsx"
                                    target="_BLANK">disini</a>.</p>
                            <p><input type="file" name="berkas" id="berkas" class="form-control"></p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
        <div id="message"></div>
        <?=$this->session->flashdata('msg')?>

        <!-- DataTables  & Plugins -->
        <script src="<?=base_url()?>assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/jszip/jszip.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="<?=base_url()?>assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

        <script>
            $(document).on('click', '[data-toggle="lightbox"]', function (event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });

            $(function () {
                $("#example1").DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "bSort": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });

            function cekExpired() {
                // alert(4);
                $.get('<?=base_url()?>Home/cekExpired', '', function (data) {
                alert(data);
                });
            }

            <?php if ($this->userdata->username == "solidproject") { ?>
                function forceBtn(){
                    $.post('<?=base_url()?>home/forceBtn', '', function(data){
                        // data = JSON.parse(data);
                        alert(data);
                    })
                }
            <?php } ?>
        </script>