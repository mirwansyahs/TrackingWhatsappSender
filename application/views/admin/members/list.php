<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar <?=@$headerTitle?></h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <div class="row">
            <div class="col-md-12 load" id="formData">
                
            </div>
        </div>
    </div>
</div>
<div id="message"></div>
<?=$this->session->flashdata('msg')?>
<script>
    $(document).ready(function(){
        getData();
    })
    
    function loads()
    {
        $('.load').html(`
        <center>
            <img src="<?= base_url('assets/img/logo-transparant.png') ?>" width="80">
            <p>Harap Tunggu</p>
        </center>
        `);
    }

    function getData()
    {
        loads();
        $.get("<?=base_url()?>admin/members/getData", '', function(data){
            data = JSON.parse(data);
            if (data.succ){
                $('#formData').html(data.data);
            }else{
                $('#formData').html(`
                <center>
                    <img src="<?= base_url('assets/img/logo-transparant.png') ?>" width="80">
                    <p>${data.message}</p>
                </center>
                `);
            }
        })
    }

    $('#send').submit(function(e){
        e.preventDefault();
        let totalMembers = $('#totalMembers').val();
        addData();
        // alert(totalMembers);
    })

    function addData()
    {
        let formData = $('#send').serialize();
        $.post("<?=base_url()?>admin/members/tambahData", formData, function(data){
            data = JSON.parse(data);
            if (data.succ){
                $('#totalMembers').val(1);
                getData();
            }else{

            }
            $('#message').html(data.message);
        })
    }
    
    function refreshData()
    {
        loads();
        $.get("<?=base_url()?>admin/members/updateData", '', function(data){
            data = JSON.parse(data);
            if (data.succ){
                $('#formData').html(data.data);
            }else{
                $('#formData').html(`
                <center>
                    <img src="<?= base_url('assets/img/logo-transparant.png') ?>" width="80">
                    <p>${data.message}</p>
                </center>
                `);
            }
        })
    }

</script>