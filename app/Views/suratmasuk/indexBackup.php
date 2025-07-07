<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-3">
    <!-- ✅ Toast Notification -->
    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
                </div>
            </div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Tutup"></button>
                </div>
            </div>
        <?php endif ?>
    </div>

    <!-- 🧭 Header & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h2 class="m-0 text-light fw-bold" style="font-size: 1.8rem; font-family: 'Poppins', sans-serif;">📥 Arsip Surat Masuk</h2>
        <a href="<?= base_url('suratmasuk/create') ?>" class="btn btn-primary mt-2 mt-md-0">
            <i class="bi bi-plus-circle"></i> Tambah Surat
        </a>
    </div>

    <!-- 🔔 Flash Message dengan styling lengkap -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
    <?php endif ?>

    <!-- 🔍 Live Search -->
    <div class="input-group mb-3" style="max-width: 500px;">
        <span class="input-group-text bg-dark text-white"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control text-uppercase" id="searchInput" placeholder="Cari berdasarkan nomor, pengirim, atau perihal...">
    </div>

    <!-- 📝 Tabel Surat Masuk -->
    <div class="table-responsive">
        <table class="table table-dark table-bordered table-hover align-middle" id="suratTable">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 40px;">No</th>
                    <th style="width: 160px;">Nomor Surat</th>
                    <th style="width: 180px;">Pengirim</th>
                    <th style="width: 140px;">Tanggal Terima</th>
                    <th style="width: 180px;">Perihal</th>
                    <th style="width: 210px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                usort($surat, function ($a, $b) {
                    return strtotime($b['tanggal_terima']) <=> strtotime($a['tanggal_terima']);
                });

                $no = 1;
                foreach ($surat as $s):
                ?>
                    <tr>
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="max-width:160px;">
                            <span class="truncate-text" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($s['nomor_surat']) ?>">
                                <?= esc($s['nomor_surat']) ?>
                            </span>
                        </td>
                        <td style="max-width:180px;">
                            <span class="truncate-text" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($s['pengirim']) ?>">
                                <?= esc($s['pengirim']) ?>
                            </span>
                        </td>
                        <td class="text-center"><?= esc($s['tanggal_terima']) ?></td>
                        <td style="max-width:180px;">
                            <span class="truncate-text" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($s['perihal']) ?>">
                                <?= esc($s['perihal']) ?>
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <div class="d-flex justify-content-center flex-wrap gap-1">
                                <a href="<?= base_url('suratmasuk/detail/' . $s['id']) ?>" class="btn btn-info btn-sm text-white"><i class="bi bi-eye-fill"></i></a>
                                <a href="<?= base_url('suratmasuk/edit/' . $s['id']) ?>" class="btn btn-warning btn-sm text-dark"><i class="bi bi-pencil-fill"></i></a>
                                <a href="<?= base_url('uploads/' . $s['file_surat']) ?>" class="btn btn-secondary btn-sm text-white" download><i class="bi bi-download"></i></a>
                                <button class="btn btn-danger btn-sm text-white" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $s['id'] ?>"><i class="bi bi-trash-fill"></i></button>
                            </div>

                            <!-- 🧨 Modal Hapus -->
                            <div class="modal fade" id="modalHapus<?= $s['id'] ?>" tabindex="-1" aria-labelledby="modalLabel<?= $s['id'] ?>" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content bg-dark text-white border-danger">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalLabel<?= $s['id'] ?>">Konfirmasi Hapus</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body">
                                            🗑️ Hapus surat dari <strong><?= esc($s['pengirim']) ?></strong>?<br>
                                            Nomor: <strong><?= esc($s['nomor_surat']) ?></strong>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="<?= base_url('suratmasuk/delete/' . $s['id']) ?>" method="post">
                                                <?= csrf_field() ?>
                                                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                                            </form>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<!-- 🔍 Script Search + Tooltip Bootstrap -->
<script>
    document.getElementById("searchInput").addEventListener("input", function() {
        this.value = this.value.toUpperCase();
        const keyword = this.value.toLowerCase();
        const rows = document.querySelectorAll("#suratTable tbody tr");

        rows.forEach(row => {
            const text = row.innerText.toLowerCase();
            row.style.display = text.includes(keyword) ? "" : "none";
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.forEach(function(el) {
            new bootstrap.Tooltip(el, {
                animation: true,
                html: false
            });
        });
    });
</script>

<!-- 🎯 Tiga Tips Tambahan -->
<script>
    // 1️⃣ Auto scroll ke flash message setelah muncul
    const flash = document.querySelector('.alert');
    if (flash) {
        flash.scrollIntoView({
            behavior: 'smooth'
        });
    }

    // 2️⃣ Timeout otomatis untuk menutup alert (opsional)
    setTimeout(() => {
        const alert = document.querySelector('.alert-dismissible');
        if (alert) {
            alert.classList.remove('show');
            alert.classList.add('fade');
        }
    }, 5000); // 5 detik

    // 3️⃣ Tambahkan animasi pop efek saat alert muncul
    document.querySelectorAll('.alert').forEach(el => {
        el.style.animation = "popIn 0.5s ease";
    });
</script>

<!-- Animasi CSS untuk efek popIn -->
<style>
    @keyframes popIn {
        0% {
            transform: scale(0.8);
            opacity: 0;
        }

        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
</style>

<script>
    setTimeout(() => {
        const toasts = document.querySelectorAll('.toast');
        toasts.forEach(toast => toast.classList.remove('show'));
    }, 4000); // Auto dismiss dalam 4 detik
</script>

<?= $this->endSection() ?>