<div class="container-fluid">
    <!-- general form elements -->
    <div class="card card">
        <div class="card-header">
            <h3 class="card-title"><a class="btn btn-primary btn-sm" href="<?= base_url('admin/whatsapp') ?>">Kembali</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form method="POST" action="<?= base_url('admin/whatsapp/addProccess') ?>">
            <div class="card-body">
                <div class="row">
                    <?php if ($this->session->flashdata('error') !== null) : ?>
                    <div class="alert alert-danger" role="alert"><?= $this->session->flashdata('error') ?></div>
                    <?php endif ?>

                    <?php if ($this->session->flashdata('message') !== null) : ?>
                    <div class="alert alert-success" role="alert"><?= $this->session->flashdata('message') ?></div>
                    <?php endif ?>

                    <div class="form-group col-md-12">
                        <label for="whatsapp_vendor">Vendor</label>
                        <?php $arr = array('fonnte'); ?>
                        <select name="whatsapp_vendor" class="form-control" id="whatsapp_vendor">
                            <?php for($i = 0; $i < count($arr); $i++) { ?>
                                <option value="<?=$arr[$i]?>"><?=$arr[$i]?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="whatsapp_authorized">Authorized</label>
                        <div class="row">
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="whatsapp_authorized" name="whatsapp_authorized" placeholder="mRZ4CLne8XXXX">
                            </div>
                            <div class="col-md-3">
                                <button type="button" class="form-control btn btn-success" id="whatsapp_authorized" name="whatsapp_authorized" onclick="checkAPI()">
                                        Check
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-12">
                        <label for="whatsapp_label">Label</label>
                        <input type="text" class="form-control" id="whatsapp_label" name="whatsapp_label" readonly>
                    </div>
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

function checkAPI()
{
    $.post('<?=base_url()?>admin/whatsapp/checkAPI', 'whatsapp_vendor='+$('#whatsapp_vendor').val()+'&whatsapp_authorized='+$('#whatsapp_authorized').val(), function(data){
        data = JSON.parse(data);
        if (data.status){
            $('#whatsapp_label').val(data.name + ' ('+data.device+')');
        }else{
            swal.fire("Ooppss...", data.reason, "error");
            $('#whatsapp_label').val('');
        }
    })
}

</script>
<?=$this->session->flashdata('msg')?>