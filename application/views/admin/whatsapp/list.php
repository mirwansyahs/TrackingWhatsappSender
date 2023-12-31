    <div class="card">
        <div class="card-header">
            <h3 class="card-title"><?=@$headerTitle?></h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Authorized</th>
                                <th>Name</th>
                                <th>Status</th>
                                <th class="text-center" width="10%">
                                    <a href="<?=base_url()?>admin/whatsapp/add">
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
                                    if ($key->whatsapp_vendor == "fonnte"){
                                        $dataWA = json_decode($this->api->CallAPI('POST', fonnteUrl('/device'), false, ['Authorization:'. $key->whatsapp_authorized]));
                                    }else{
                                        $dataWA = json_decode($this->api->CallAPI('GET', localUrl('/getStatus')));
                                    }
                            ?>
                            <tr>
                                <td><small class="badge badge-success"><?=$key->whatsapp_vendor?></small><br/>
                                    <?=$key->whatsapp_authorized?>
                                </td>
                                <td><?=$key->whatsapp_label?></td>
                                <td>
                                    <?php
                                    if (@$dataWA->device_status == "connect" || $dataWA->status == "CONNECTED"){
                                    ?>
                                        <a href="<?=base_url()?>admin/whatsapp/disconnect?whatsapp_authorized=<?=base64_encode($key->whatsapp_authorized)?>">
                                            <span class="btn btn-success"><i class="fa fa-link"></i> Connected</span>
                                        </a>
                                    <?php }else{ 
                                    
                                        if ($key->whatsapp_vendor == "fonnte"){
                                            $getQR = json_decode($this->api->CallAPI('POST', fonnteUrl('/qr'), false, ['Authorization:'. $key->whatsapp_authorized]));
                                            if ($getQR->status){
                                                $url = $getQR->url;
                                                $message = "";
                                            }else{
                                                $url = "";
                                                $message = $getQR->reason;
                                            }
                                        ?>
                                        <a href="data:image/png;base64,<?= $url?>" id="srcWhatsapp" data-toggle="lightbox" data-title="QR Code - <?=$key->whatsapp_label?> <?=$message?>" data-gallery="gallery">
                                            <span class="btn btn-danger"><i class="fa fa-unlink"></i> Disconnected</span>
                                            <!-- <img src="https://via.placeholder.com/300/FFFFFF?text=1" class="img-fluid mb-2" alt="white sample" /> -->
                                        </a>
                                        <?php
                                        }else{
                                            $getQR = json_decode($this->api->CallAPI('GET', localUrl('/getqr')));
                                            $url = $getQR->qr;
                                            $message = "";
                                        ?>
                                        <a href="data:image/svg+xml;base64,<?= base64_encode($url)?>" id="srcWhatsapp" data-toggle="lightbox" data-title="QR Code - <?=$key->whatsapp_label?> <?=$message?>" data-gallery="gallery">
                                            <span class="btn btn-danger"><i class="fa fa-unlink"></i> Disconnected</span>
                                        </a>
                                        <?php
                                        }
                                        ?>
                                    
                                    <?php } ?>
                                </td>

                                <td class="text-center">
                                    <a href="<?=base_url()?>admin/whatsapp/edit/<?=$key->whatsapp_id?>">
                                        <button class="btn btn-warning text-white btn-sm">
                                            <i class="far fa-edit"></i>
                                        </button>
                                    </a>

                                    <?php if ($key->whatsapp_vendor != "local"){ ?>
                                    <a href="<?=base_url()?>admin/whatsapp/delete/<?=$key->whatsapp_id  ?>">
                                        <button class="btn btn-danger btn-sm">
                                            <i class="far fa-trash-alt"></i>
                                        </button>
                                    </a>
                                    <?php } ?>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

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

            $(document).on('click', '[data-toggle="lightbox"]', function(event) {
                event.preventDefault();
                $(this).ekkoLightbox({
                    alwaysShowClose: true
                });
            });
                
            $(function () {
                $("#example1").DataTable({
                "responsive": true, "lengthChange": false, "autoWidth": false, "bSort": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            });

            function getQR(authorized = ''){
                $.post('<?=base_url()?>admin/whatsapp/getQR', 'whatsapp_authorized='+authorized, function(data){
                    data = JSON.parse(data);
                    if (data.status){
                        // alert("data:image/png;base64,"+data.url);
                        $('#srcWhatsapp').attr("href", "data:image/png;base64,"+data.url);
                    }else{
                        swal.fire("Ooppss...", data.reason, "error");
                        $('#srcWhatsapp').attr("href", '#');
                    }
                })
            }
        </script>