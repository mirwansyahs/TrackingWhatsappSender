<div class="container-fluid">
        <?php if (@$this->session->flashdata('error') !== null) : ?>
            <div class="alert alert-danger" role="alert"><?= @$this->session->flashdata('error') ?></div>
        <?php endif ?>

        <?php if (@$this->session->flashdata('message') !== null) : ?>
            <div class="alert alert-success" role="alert"><?= @$this->session->flashdata('message') ?></div>
        <?php endif ?>
        
        <div class="row">
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= @$this->M_resi->select()->num_rows() ?></h3>

                <p>Data Resi</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?= @$this->M_resi->select(['status' => "Terkirim"])->num_rows() ?></h3>

                <p>Paket Telah Terkirim</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-primary">
              <div class="inner">
                <h3><?= @$this->M_resi->select(['status' => "Sedang Diantar"])->num_rows() ?></h3>

                <p>Paket Sedang Diantar</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?= @$this->M_resi->select(['status' => "Telah Diretur"])->num_rows() ?></h3>

                <p>Paket Diretur</p>
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
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= @$this->M_produk->select()->num_rows() ?></h3>

                <p>Total Data Produk</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
            </div>
          </div>
          <?php } ?>
          <?php if(@$this->userdata->username == "solidproject") { ?>
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= @$this->M_admin->select()->num_rows() ?></h3>

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