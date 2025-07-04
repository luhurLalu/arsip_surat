<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="container mt-3">

    <!-- 🧭 Header & Tombol Tambah -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
        <h2 class="m-0 text-light fw-bold" style="font-size: 1.8rem; font-family: 'Poppins', sans-serif;">📤 Arsip Surat Keluar</h2>
        <a href="<?= base_url('suratkeluar/create') ?>" class="btn btn-primary mt-2 mt-md-0">
            <i class="bi bi-plus-circle"></i> Tambah Surat
        </a>
    </div>

    <!-- 🔔 Flash Message -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
    <?php elseif (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif ?>

    <!-- 🔍 Live Search & Pagination -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
        <div class="input-group" style="flex: 1 1 auto; max-width: 500px;">
            <span class="input-group-text bg-dark text-white"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control text-uppercase" id="searchInput" placeholder="Cari berdasarkan nomor, tujuan, atau perihal...">
        </div>
        <ul class="pagination mb-0" id="pagination"></ul>
    </div>

    <!-- 📝 Tabel Surat Keluar -->
    <div class="table-responsive mt-2">
        <table class="table table-dark table-bordered table-hover align-middle" id="suratTable">
            <thead class="table-light text-center">
                <tr>
                    <th style="width: 40px;">No</th>
                    <th style="width: 160px;">Nomor Surat</th>
                    <th style="width: 180px;">Tujuan</th>
                    <th style="width: 140px;">Tanggal Kirim</th>
                    <th style="width: 180px;">Perihal</th>
                    <th style="width: 210px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    // 🔁 Urutkan berdasarkan tanggal terbaru
                    usort($surat, function($a, $b) {
                        return strtotime($b['tanggal_kirim']) <=> strtotime($a['tanggal_kirim']);
                    });

                    $no = 1;
                    foreach ($surat as $s):
                ?>
                    <tr class="paginated">
                        <td class="text-center"><?= $no++ ?></td>
                        <td style="max-width:160px;">
                            <span class="truncate-text" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($s['nomor_surat']) ?>">
                                <?= esc($s['nomor_surat']) ?>
                            </span>
                        </td>
                        <td style="max-width:180px;">
                            <span class="truncate-text" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($s['tujuan']) ?>">
                                <?= esc($s['tujuan']) ?>
                            </span>
                        </td>
                        <td class="text-center"><?= esc($s['tanggal_kirim']) ?></td>
                        <td style="max-width:180px;">
                            <span class="truncate-text" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= esc($s['perihal']) ?>">
                                <?= esc($s['perihal']) ?>
                            </span>
                        </td>
                        <td class="text-center text-nowrap">
                            <div class="d-flex justify-content-center flex-wrap gap-1">
                                <a href="<?= base_url('suratkeluar/detail/' . $s['id']) ?>" class="btn btn-info btn-sm text-white"><i class="bi bi-eye-fill"></i></a>
                                <a href="<?= base_url('suratkeluar/edit/' . $s['id']) ?>" class="btn btn-warning btn-sm text-dark"><i class="bi bi-pencil-fill"></i></a>
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
                                            🗑️ Hapus surat ke <strong><?= esc($s['tujuan']) ?></strong>?<br>
                                            Nomor: <strong><?= esc($s['nomor_surat']) ?></strong>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="<?= base_url('suratkeluar/delete/' . $s['id']) ?>" method="post">
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

<!-- 🔍 Script Search + Pagination + Tooltip -->
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

    const rows = document.querySelectorAll(".paginated");
    const rowsPerPage = 7;
    const totalPages = Math.ceil(rows.length / rowsPerPage);
    const pagination = document.getElementById("pagination");
    let currentPage = 1;

    function showPage(page) {
        currentPage = page;
        rows.forEach((row, i) => {
            row.style.display = (i >= (page - 1) * rowsPerPage && i < page * rowsPerPage) ? "" : "none";
        });

        pagination.innerHTML = "";
        for (let i = 1; i <= totalPages; i++) {
            const btn = document.createElement("li");
            btn.className = "page-item" + (i === page ? " active" : "");
            btn.innerHTML = `<button class="page-link">${i}</button>`;
            btn.addEventListener("click", () => showPage(i));
            pagination.appendChild(btn);
        }
    }

    showPage(currentPage);

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

<?= $this->endSection() ?>