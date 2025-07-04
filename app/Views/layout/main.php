<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Arsip Surat</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@600&display=swap" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

  <!-- Style Pendukung Layout -->
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-color: #1e1e2f;
      color: white;
      overflow: hidden;
    }

    body {
      display: flex;
      flex-direction: column;
    }

    main.container {
      flex: 1;
      height: 100%;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow: hidden;
      padding-top: 1rem;
      padding-bottom: 1rem;
    }

    .brand-font {
      font-family: 'Rajdhani', sans-serif;
      font-weight: 600;
      font-size: 1.5rem;
      letter-spacing: 1px;
    }

    .navbar-brand img {
      object-fit: cover;
    }
  </style>
</head>
<body>

  <!-- 🔷 Logo + Judul -->
  <nav class="navbar navbar-dark bg-dark border-bottom shadow-sm">
    <div class="container-fluid">
      <a class="navbar-brand d-flex align-items-center gap-2" href="<?= base_url('/') ?>">
        <img src="<?= base_url('images/logo.png') ?>" alt="Logo" width="32" height="32" class="rounded-circle shadow">
        <span class="brand-font text-primary">E-ARSIP KEMENAG KLU</span>
      </a>
    </div>
  </nav>

  <!-- 🌌 Navbar Navigasi -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom border-secondary shadow-sm">
    <div class="container-fluid">
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#arsipNavbar" aria-controls="arsipNavbar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="arsipNavbar">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link<?= service('uri')->getSegment(1) === 'dashboard' ? ' active' : '' ?>" href="/">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= service('uri')->getSegment(1) === 'suratmasuk' ? ' active' : '' ?>" href="<?= base_url('suratmasuk') ?>">
              <i class="bi bi-envelope-open"></i> Surat Masuk
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link<?= service('uri')->getSegment(1) === 'suratkeluar' ? ' active' : '' ?>" href="<?= base_url('suratkeluar') ?>">
              <i class="bi bi-send-check"></i> Surat Keluar
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
        </div>
      </div>
    </div>
  </nav>

  <!-- 🔽 Konten Halaman -->
  <main class="container">
    <?= $this->renderSection('content') ?>
  </main>

  <!-- Bootstrap JS & Tooltip Activation -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
      tooltipTriggerList.forEach(function (el) {
        new bootstrap.Tooltip(el, {
          animation: true,
          html: false
        });
      });
    });
  </script>
</body>
</html>