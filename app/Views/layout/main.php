<!doctype html>
<html lang="en">

<head>
  <style>
    /* Dropdown submenu support for Bootstrap 5 */
    .dropdown-submenu {
      position: relative;
    }
    .dropdown-submenu > .dropdown-menu {
      top: 0;
      right: 100%;
      left: auto;
      margin-top: -0.25rem;
      margin-right: 0.1rem;
    }
  </style>
  <meta charset="UTF-8">
  <title>E-ARSIP | KEMENAG KLU<?= $this->renderSection('title') ? ' | ' . $this->renderSection('title') : '' ?></title>

  <!-- Bootstrap CSS -->
  <link rel="icon" type="image/png" href="<?= base_url('images/Logo.png') ?>">
 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
  <!-- Flatpickr CSS (before custom CSS for override) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">
  <!-- Custom CSS (after vendor CSS for easy override) -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <!-- Style Pendukung Layout -->
  <!-- Style kustom dipindahkan ke public/css/style.css -->
</head>
<body<?= service('uri')->getSegment(1) === '' || service('uri')->getSegment(1) === 'dashboard' ? ' class="dashboard-page"' : '' ?>>


  <?php $isLoginPage = in_array(service('uri')->getSegment(1), ['login', 'auth']) && (service('uri')->getSegment(2) === 'login' || service('uri')->getSegment(1) === 'login'); ?>
  <?php if (!$isLoginPage): ?>
    <!-- 🔷 Logo + Judul -->
    <nav class="navbar navbar-dark bg-dark border-bottom shadow-sm">
      <div class="container-fluid justify-content-center d-flex px-3">
        <a class="navbar-brand d-flex align-items-center gap-2 mx-auto" href="<?= base_url('/') ?>">
          <img src="<?= base_url('images/logo.png') ?>" alt="Logo" width="32" height="32" class="shadow">
          <span class="login-title-dashboard mb-0" style="font-size:1.7rem;line-height:1.1;">E-ARSIP KEMENAG KLU</span>
        </a>
      </div>
    </nav>

    <!-- 🌌 Navbar Navigasi -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary shadow-sm">
      <div class="container-fluid px-3">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#arsipNavbar" aria-controls="arsipNavbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="arsipNavbar">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <?php
              $seg1 = service('uri')->getSegment(1);
              $isDashboard = $seg1 === '' || $seg1 === 'dashboard';
              $isMasuk = $seg1 === 'suratmasuk';
              $isKeluar = $seg1 === 'suratkeluar';
            ?>
            <li class="nav-item d-flex align-items-center gap-2">
              <a href="<?= base_url('/') ?>" class="nav-link p-0<?= $isDashboard ? ' active-underline' : '' ?>" style="font-weight:600;<?= $isDashboard ? 'color:#81d4fa;' : 'color:#fff;' ?>">
                <i class="bi bi-speedometer2"></i> Dashboard
              </a>
              <span style="color:#888;">|</span>
              <a href="<?= base_url('suratmasuk') ?>" class="nav-link p-0<?= $isMasuk ? ' active-underline' : '' ?>" style="font-weight:600;<?= $isMasuk ? 'color:#81d4fa;' : 'color:#fff;' ?>">
                <i class="bi bi-envelope-open"></i> Surat Masuk
              </a>
              <span style="color:#888;">|</span>
              <a href="<?= base_url('suratkeluar') ?>" class="nav-link p-0<?= $isKeluar ? ' active-underline' : '' ?>" style="font-weight:600;<?= $isKeluar ? 'color:#81d4fa;' : 'color:#fff;' ?>">
                <i class="bi bi-send-check"></i> Surat Keluar
              </a>
              <span style="color:#888;">|</span>
              <?php $isTugas = $seg1 === 'surattugas'; ?>
              <a href="<?= base_url('surattugas') ?>" class="nav-link p-0<?= $isTugas ? ' active-underline' : '' ?>" style="font-weight:600;<?= $isTugas ? 'color:#81d4fa;' : 'color:#fff;' ?>">
                <i class="bi bi-briefcase"></i> Surat Tugas
              </a>
            </li>
          </ul>

          <div class="d-flex gap-2">

            <a href="<?= base_url('suratmasuk/create') ?>" class="btn btn-outline-light btn-sm">
              <i class="bi bi-plus-circle"></i> Masuk
            </a>
            <a href="<?= base_url('suratkeluar/create') ?>" class="btn btn-outline-primary btn-sm">
              <i class="bi bi-plus-circle-fill"></i> Keluar
            </a>
            <a href="/surattugas/create" class="btn btn-success btn-sm text-dark">
              <i class="bi bi-briefcase-fill"></i> Tugas
            </a>
          </div>

          <!-- User Dropdown Menu with Avatar, Username, and Menu Items -->
          <div class="dropdown ms-3">
            <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="background:none;box-shadow:none;padding:0;">
              <span class="rounded-circle d-flex justify-content-center align-items-center me-2" style="width:36px;height:36px;overflow:hidden;background:#e0e0e0;">
                <i class="bi bi-person-circle fs-3 text-secondary"></i>
              </span>
              <span class="fw-normal text-secondary" style="font-size:1.08rem;"><?= esc(session()->get('username')) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown" style="min-width: 180px;">
              <li class="px-3 py-2">
                <div class="fw-bold mb-1" style="font-size:1.05rem;">
                  <?= esc(session()->get('username')) ?>
                </div>
                <div class="text-muted small mb-1">
                  <?= esc(session()->get('role')) ?>
                </div>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li class="dropdown-submenu">
                <a class="dropdown-item dropdown-toggle d-flex align-items-center gap-2" href="#" id="cleanupDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="bi bi-trash"></i> Cleanup
                </a>
                <ul class="dropdown-menu" aria-labelledby="cleanupDropdown">
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="<?= base_url('suratmasuk/cleanup') ?>">
                      <i class="bi bi-envelope-open"></i> Surat Masuk
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item d-flex align-items-center gap-2" href="<?= base_url('suratkeluar/cleanup') ?>">
                      <i class="bi bi-envelope-paper"></i> Surat Keluar
                    </a>
                  </li>
                </ul>
              </li>
              <li>
                <a class="dropdown-item d-flex align-items-center gap-2" href="#">
                  <i class="bi bi-sliders"></i> Settings
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="<?= base_url('auth/logout') ?>">
                  <i class="bi bi-power"></i> Logout
                </a>
              </li>
            </ul>
          </div>

        </div>
      </div>
    </nav>
  <?php endif; ?>

  <!-- 🔽 Konten Halaman -->
  <main class="container">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- 🍞 Container Toast -->
  <div class="toast-container">
    <?= $this->renderSection('toast') ?>
  </div>

  <!-- Bootstrap JS (always before custom JS) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Flatpickr JS (before custom JS that uses it) -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
  <!-- Section for custom/global JS -->
  <script src="<?= base_url('js/index.js') ?>"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Enable Bootstrap tooltips
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.forEach(function(el) {
        new bootstrap.Tooltip(el, { animation: true, html: false });
      });
      // Enable dropdown submenu for Cleanup
      var dropdownSubmenus = document.querySelectorAll('.dropdown-submenu');
      dropdownSubmenus.forEach(function (submenu) {
        submenu.addEventListener('mouseenter', function () {
          var menu = submenu.querySelector('.dropdown-menu');
          if (menu) menu.classList.add('show');
        });
        submenu.addEventListener('mouseleave', function () {
          var menu = submenu.querySelector('.dropdown-menu');
          if (menu) menu.classList.remove('show');
        });
      });
    });
  </script>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      // Enable Bootstrap tooltips
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.forEach(function(el) {
        new bootstrap.Tooltip(el, {
          animation: true,
          html: false
        });
      });
    });
  </script>
  <!-- Section for page-specific scripts -->
  <?= $this->renderSection('scripts') ?>
  </body>

</html>