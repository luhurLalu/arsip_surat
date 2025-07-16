<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<div class="d-flex justify-content-center align-items-center" style="min-height: 80vh;">
  <div class="card shadow-lg p-4" style="background: #23243a; min-width:340px; max-width:370px; border-radius:18px;">
    <div class="text-center mb-3">
      <img src="<?= base_url('images/Logo.png') ?>" alt="Logo" width="56" height="56" class=" shadow mb-2">
      <h3 class="login-title-dashboard mb-0">E-ARSIP KEMENAG KLU</h3>
      <div class="text-secondary" style="font-size:0.95rem;">Login Sistem Arsip Surat</div>
    </div>

    <?php if (session()->getFlashdata('error') && session()->getFlashdata('error') !== 'Silakan login terlebih dahulu'): ?>
      <div class="alert alert-danger py-2 mb-2 animate__animated animate__shakeX animate__faster" id="loginErrorAlert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <?= session()->getFlashdata('error') ?>
      </div>
      <script>
        setTimeout(function() {
          const alert = document.getElementById('loginErrorAlert');
          if(alert) {
            alert.classList.add('animate__fadeOutUp');
            setTimeout(() => alert.style.display = 'none', 800);
          }
        }, 2200);
      </script>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
      <div class="alert alert-success py-2 mb-2">
        <?= session()->getFlashdata('success') ?>
      </div>
    <?php endif; ?>

    <form action="<?= base_url('auth/processLogin') ?>" method="post" autocomplete="off">
      <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input type="text" class="form-control bg-dark text-light border-0" id="username" name="username" value="<?= old('username') ?>" required autofocus autocomplete="username" style="text-transform:none;">
      </div>
      <div class="mb-3 position-relative">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control bg-dark text-light border-0 pr-5" id="password" name="password" required autocomplete="current-password" style="text-transform:none;">
        <button type="button" tabindex="-1" class="btn btn-sm btn-link position-absolute end-0" id="togglePassword" style="color:#81d4fa;z-index:2;top:70%;transform:translateY(-50%);height:2.2rem;display:flex;align-items:center;" aria-label="Lihat Password">
          <i class="bi bi-eye-slash" id="iconPassword"></i>
        </button>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login <i class="bi bi-box-arrow-in-right"></i></button>
    </form>
  </div>
</div>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const toggle = document.getElementById('togglePassword');
    const input = document.getElementById('password');
    const icon = document.getElementById('iconPassword');
    if(toggle && input && icon) {
      // Show password on hold (mouse/touch)
      const show = () => {
        input.type = 'text';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      };
      const hide = () => {
        input.type = 'password';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      };
      toggle.addEventListener('mousedown', show);
      toggle.addEventListener('touchstart', show);
      toggle.addEventListener('mouseup', hide);
      toggle.addEventListener('mouseleave', hide);
      toggle.addEventListener('touchend', hide);
      toggle.addEventListener('touchcancel', hide);
    }
  });
</script>
<!-- Animasi Alert: animate.css CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<?= $this->endSection() ?>