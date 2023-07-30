<div class="card">
    <div class="card-header">
        <h3 class="card-title"><?=@$headerTitle?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <form id="form1" method="POST">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="inputNominal">Nominal Topup <span class="text-sm text-danger">*</span></label>
                        <input type="text" id="inputNominal" class="form-control form-control-sm rupiah" name="nominal"
                            required value="5.000" min="2000" max="999999">
                    </div>
                    <div class="row">
                        <?php for($i = 0; $i < count($nominal); $i++){ ?>
                        <div class="col-md-4">
                            <a onclick="parseNominal('<?=$nominal[$i]?>')" href="#">
                                <div class="card" id="card<?=$nominal[$i]?>">
                                    <div class="card-body text-center">
                                        <span id="nominal<?=$i?>"><?=number_format($nominal[$i], 0, ',', '.')?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn bg-pink" id="btnSubmit" onclick="pay()">
                            <i class="far fa-save"></i> Topup Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Topup History</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 load" id="formData">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="15%">Topup ID</th>
                            <th>Nominal</th>
                            <th width="10%">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            foreach ($data as $key) {
                        ?>
                        <tr>
                            <td><span class="badge badge-success"><?=$key->topup_id?></span> <span class="badge badge-info"><?=$key->date_topup?></span></td>
                            <td>Rp <?=number_format($key->nominal, 0, ',', '.')?></td>
                            <td>
                                <?php if ($key->status == "settlement"){ ?>
                                <span class="badge badge-success"><?=ucwords($key->status)?></span>
                                <?php }else if($key->status == "expire"){ ?>
                                <span class="badge badge-danger"><?=ucwords($key->status)?></span>
                                <?php }else{ ?>
                                <span class="badge badge-warning"><?=ucwords($key->status)?></span>
                                <?php } ?>

                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div id="message"></div>
<?=$this->session->flashdata('msg')?>
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

<script src="<?=base_url()?>assets/plugins/select2/js/select2.full.min.js"></script>
<script>
    $(function () {

        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
                alwaysShowClose: true
            });
        });
            
        $(function () {
            $("#example1").DataTable({
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        //Initialize Select2 Elements
        $('.select2').select2()

        //Initialize Select2 Elements
        $('.select2bs4').select2({
            theme: 'bootstrap4'
        })

        $('.rupiah').on('keyup', function () {
            this.value = formatRupiah(this.value, '');
        });
    })

    function parseNominal(nominal = '') {
        <?php
        for ($i = 0; $i < count($nominal); $i++) {
        ?>
            if (nominal == <?= $nominal[$i] ?> ) {
                $('#card<?=$nominal[$i]?>').addClass("bg-pink");
            } else {
                $('#card<?=$nominal[$i]?>').removeClass("bg-pink");
            } <?php
        } ?>
        $('#inputNominal').val(formatRupiah(nominal));
    }

    function pay() {
        $.ajax({
            url: '<?=base_url()?>admin/topup/token',
            data: {
                nominal: $('#inputNominal').val()
            },
            method: "POST",
            cache: false,

            success: function (data) {
                //location = data;

                console.log('token = ' + data);

                function changeResult(type, data) {
                    $("#result-type").val(type);
                    $("#result-data").val(JSON.stringify(data));
                    //resultType.innerHTML = type;
                    //resultData.innerHTML = JSON.stringify(data);
                }

                snap.pay(data, {

                    onSuccess: function (result) {
                        finish('success', result);
                        console.log(result.status_message);
                        console.log(result);
                        // $("#payment-form").submit();
                    },
                    onPending: function (result) {
                        finish('pending', result);
                        console.log(result.status_message);
                        // $("#payment-form").submit();
                    },
                    onError: function (result) {
                        finish('error', result);
                        console.log(result.status_message);
                        // $("#payment-form").submit();
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });

    }

    function finish(type, result) {
        $.post('<?=base_url()?>admin/topup/finish', result, function (data) {
            // alert(data);
            data = JSON.parse(data);
            Swal.fire({
                title: (data.succ)?'Berhasil':'',
                icon: (data.succ)?'success':'info',
                html: data.msg,
                }).then((result) => {
                    location.reload();
            })
        })
    }
</script>