<div class="container-fluid">
        <?php if (@$this->session->flashdata('error') !== null) : ?>
            <div class="alert alert-danger" role="alert"><?= @$this->session->flashdata('error') ?></div>
        <?php endif ?>

        <?php if (@$this->session->flashdata('message') !== null) : ?>
            <div class="alert alert-success" role="alert"><?= @$this->session->flashdata('message') ?></div>
        <?php endif ?>
        
        <div class="row">
          <?php if(@$this->userdata->role == "Manager") { ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= @$produk ?></h3>

                <p>Total Data Produk</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <?php } ?>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= @$resi ?></h3>

                <p>Total Data Resi</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <?php if(@$this->userdata->role == "Manager") { ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= @$admin ?></h3>

                <p>Total Data Admin</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
    </div><!-- /.container-fluid -->