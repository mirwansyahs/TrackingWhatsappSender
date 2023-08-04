<!-- Main Sidebar Container -->
<aside class="main-sidebar elevation-4   sidebar-dark-black">
    <!-- Brand Logo -->
    <a href="<?=base_url()?>admin/home" class="brand-link navbar-black sidebar-dark-black ">
      <img src="<?=base_url()?>assets/img/AdminLTELogo.png" alt="<?=base_name()?>" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light"><?=base_name()?></span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column " data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
          <li class="nav-item">
            <a href="<?=base_url()?>admin/home" class="nav-link <?=(@$active == "home")?'active':''?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Halaman Awal
              </p>
            </a>
          </li>
          <?php if ($this->userdata->role == "Manager"){ ?>
          <li class="nav-item">
            <a href="<?=base_url()?>admin/produk" class="nav-link <?=(@$active == "produk")?'active':''?>">
              <i class="nav-icon fas fa-laptop"></i>
              <p>
                Daftar Produk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>admin/resi" class="nav-link <?=(@$active == "resi")?'active':''?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>
                Daftar Resi
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>admin/whatsapp" class="nav-link <?=(@$active == "whatsapp")?'active':''?>">
              <i class="nav-icon fas fa-comments"></i>
              <p>
                Daftar Whatsapp
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="<?=base_url()?>admin/members" class="nav-link <?=(@$active == "users")?'active':''?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Daftar User
              </p>
            </a>
          </li>
          <?php } ?>
          <li class="nav-item">
            <a href="<?=base_url()?>admin/members/edit" class="nav-link <?=(@$active == "members")?'active':''?>">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Data Diri
              </p>
            </a>
          </li>

          <li class="nav-item">
            <a href="<?=base_url()?>auth/signout" class="nav-link text-danger">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Keluar
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>