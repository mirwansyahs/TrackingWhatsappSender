<table id="example1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Wallet</th>
            <th>Email</th>
            <th>Nama</th>
            <th>Saldo</th>
            <th>Topup</th>
            <th class="text-center">
                <a href="<?=base_url()?>admin/members/add">
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
                $dataUsers = $this->M_admin->select('', $key->email);
                $sumDataUsers = $dataUsers->num_rows();
                $dataUsers = $dataUsers->row();
        ?>
        <tr>
            <td><?=(@$dataUsers->wallet)?$dataUsers->wallet:'<span class="badge badge-danger">Belum terdaftar disistem.</span>'?></td>
            <td><?=$key->email?></td>
            <td><?=$key->nama?></td>
            <td><?=(@$dataUsers->saldo)?"<span id='saldo".$dataUsers->id."'>".number_format($dataUsers->saldo, 0, ',', '.')."</span>":'<span class="badge badge-danger">Belum terdaftar disistem.</span>'?></td>
            <td><?php if(@$dataUsers->saldo)
                { ?>
                <input type="text" id="topupsaldo<?=$dataUsers->id?>" class="form-control">
            <?php } ?></td>
            <td>
                <?php if ($sumDataUsers > 0){ ?>
                    <button type="button" class="btn  bg-pink" data-bs-toggle="button" aria-pressed="false" onclick="payNow('<?=$dataUsers->id?>')" autocomplete="off">
                        <i class="fa fa-save"> Topup</i>
                    </button>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
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

    function payNow(id)
    {
        $.post('<?=base_url()?>admin/TopupUsers/pay/'+id, 'nominal='+$('#topupsaldo'+id).val(), function(data){
            data = JSON.parse(data);
            if (data.succ){
                $('#saldo'+id).html(data.saldo);
                $('#topupsaldo'+id).val("");
            }
        })
    }
</script>