<!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('dashboard'); ?>">
        <div class="sidebar-brand-icon">
          <i class="fas fa-fw fa-video"></i>
        </div>
        <div class="sidebar-brand-text mx-3">CCTV ONLINE</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('dashboard'); ?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url(''); ?>">
          <i class="fa-solid fa-mountain-sun"></i>
          <span>Depan</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        CCTV
      </div>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('cctv'); ?>">
          <i class="fa-solid fa-video"></i>
          <span>Daftar CCTV</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('cctv/live'); ?>">
          <i class="fas fa-fw fa-eye"></i>
          <span>Live CCTV</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('group'); ?>">
          <i class="fa-solid fa-layer-group"></i>
          <span>Group</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('cctv/terminal'); ?>">
          <i class="fas fa-fw fa-terminal"></i>
          <span>Script Terminal</span></a>
      </li>

      <!-- Nav Item - Charts -->

      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">
        Pengaturan
      </div>

      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('setting'); ?>">
          <i class="fas fa-fw fa-cog"></i>
          <span>Pengaturan</span></a>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('profilecompany/'); ?>">
          <i class="fas fa-fw fa-building"></i>
          <span>Profile Perusahaan</span></a>
      </li>
      
      <?php if (is_admin()) : ?>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('admin'); ?>">
          <i class="fas fa-fw fa-user-plus"></i>
          <span>User Management</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link pt-0" href="<?= base_url('menu'); ?>">
          <i class="fa-solid fa-bars"></i>
          <span>Menu Management</span></a>
      </li>

      <?php endif; ?>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar