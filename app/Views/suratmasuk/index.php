
<?= $this->extend('layout/main') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
<style>
.bulkdelete-anim {
    opacity: 0;
    transform: translateY(-10px);
    transition: opacity 0.3s cubic-bezier(.4,0,.2,1), transform 0.3s cubic-bezier(.4,0,.2,1);
    pointer-events: none;
}
.bulkdelete-anim.show {
    opacity: 1;
    transform: translateY(0);
    pointer-events: auto;
}
</style>
<?= $this->section('content') ?>

<div class="container mt-3">
    <!-- ✅ Toast Notification -->
    <div class="position-fixed top-0 end-0 p-3 toast-z">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        <?php endif ?>
    </div>

    <!-- 🧭 Header Surat Masuk -->
    <div class="mb-3">
        <h2 class="m-0 text-light fw-bold heading-poppins">📥 Arsip Surat Masuk</h2>
    </div>

    <!-- 🔍 Live Search & Pagination -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap" style="flex:1;">
            <div class="input-group search-group">
                <span class="input-group-text bg-dark text-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control text-uppercase" id="searchInput" placeholder="Cari berdasarkan nomor, pengirim, atau perihal...">
            </div>
            <div style="min-width:38px;">
                <button type="button" class="btn btn-danger btn-sm bulkdelete-anim d-none" id="btnBulkDelete" data-bs-toggle="modal" data-bs-target="#modalBulkDelete">
                    <i class="bi bi-trash-fill"></i> Hapus Terpilih
                </button>
            </div>
        </div>
        <nav>
            <ul class="pagination mb-0" id="paginationControls"></ul>
        </nav>
    </div>

    <!-- 🔔 Pesan jika tidak ditemukan -->
    <div id="noResultMessage" class="text-center text-warning fw-bold my-3 d-none">
        🔍 Data tidak ditemukan.
    </div>

    <!-- 📝 Tabel Surat Masuk -->
    <div class="table-responsive">
        <form id="formBulkDelete" method="post" action="<?= base_url('suratmasuk/bulkdelete') ?>">
        <div class="mb-2 d-flex justify-content-end">
            <button type="button" class="btn btn-danger btn-sm d-none" id="btnBulkDelete" data-bs-toggle="modal" data-bs-target="#modalBulkDelete">
                <i class="bi bi-trash-fill"></i> Hapus Terpilih
            </button>
<!-- 🧨 Modal Hapus BULK -->
<div class="modal fade" id="modalBulkDelete" tabindex="-1" aria-labelledby="modalBulkDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-danger">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBulkDeleteLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        🗑️ <strong>Hapus Item yg Dipilih?</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="confirmBulkDelete">Ya, Hapus</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>
        </div>
        <table class="table table-dark table-bordered table-hover align-middle" id="suratTable">
            <thead class="table-light text-center">
                <tr>
                    <th class="col-check" style="width:32px;padding:0;vertical-align:middle;">
                        <input type="checkbox" id="selectAll" class="form-check-input m-0" style="width:18px;height:18px;background-color:#fff;border:2px solid #888;box-shadow:0 0 2px #000;">
                    </th>
                    <th class="col-no">No</th>
                    <th class="col-nomor">Nomor Surat</th>
                    <th class="col-pengirim">Asal Surat</th>
                    <th class="col-tujuan">Tujuan Surat</th>
                    <th class="col-tanggal">Tanggal Terima</th>
                    <th class="col-perihal">Perihal</th>
                    <th class="col-aksi">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (isset($suratmasuk) && is_array($suratmasuk)): ?>
                <?php foreach ($suratmasuk as $s): ?>
                <tr>
                    <td class="text-center" style="width:32px;padding:0;vertical-align:middle;">
                        <input type="checkbox" class="rowCheckbox form-check-input m-0" name="ids[]" value="<?= $s['id'] ?>" style="width:18px;height:18px;">
                    </td>
                    <td class="text-center">...</td>
                    <td class="col-nomor"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['nomor_surat']) ?>"><?= esc($s['nomor_surat']) ?></span></td>
                    <td class="col-pengirim"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['pengirim']) ?>"><?= esc($s['pengirim']) ?></span></td>
                    <td class="col-tujuan"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['tujuan_surat']) ?>"><?= esc($s['tujuan_surat']) ?></span></td>
                    <td class="text-center"><?= esc($s['tanggal_terima']) ?></td>
                    <td class="col-perihal"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['perihal']) ?>"><?= esc($s['perihal']) ?></span></td>
                    <td class="text-center text-nowrap">
                        <div class="d-flex justify-content-center flex-wrap gap-1">
                            <a href="#" class="btn btn-warning btn-sm text-dark btn-edit-suratmasuk"
                               data-id="<?= $s['id'] ?>"
                               data-nomor="<?= esc($s['nomor_surat']) ?>"
                               data-pengirim="<?= esc($s['pengirim']) ?>"
                               data-tujuan="<?= esc($s['tujuan_surat']) ?>"
                               data-tanggal="<?= esc($s['tanggal_terima']) ?>"
                               data-perihal="<?= esc($s['perihal']) ?>"
                               data-file="<?= esc($s['file_surat']) ?>"
                               data-bs-toggle="modal" data-bs-target="#modalEditSuratMasuk">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                            <a href="<?= base_url('uploads/suratmasuk/' . $s['file_surat']) ?>" class="btn btn-secondary btn-sm text-white" download><i class="bi bi-download"></i></a>
                            <button class="btn btn-danger btn-sm text-white btn-hapus-suratmasuk"
                                data-id="<?= $s['id'] ?>"
                                data-pengirim="<?= esc($s['pengirim']) ?>"
                                data-nomor="<?= esc($s['nomor_surat']) ?>"
                                data-action="<?= base_url('suratmasuk/delete/' . $s['id']) ?>"
                                data-bs-toggle="modal" data-bs-target="#modalHapusSuratMasuk">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">
                        <div class="alert alert-warning mb-0">Data surat masuk kosong.</div>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        </form>
    </div>
</div>



<!-- 📝 Modal Edit Surat Masuk -->
<?= view('suratmasuk/modal_edit') ?>

<!-- 🧨 Modal Hapus GLOBAL -->
<div class="modal fade" id="modalHapusSuratMasuk" tabindex="-1" aria-labelledby="modalHapusSuratMasukLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-danger">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHapusSuratMasukLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="hapusMasukModalBody">
        <!-- Diisi dinamis oleh JS -->
      </div>
      <div class="modal-footer">
        <form id="formHapusSuratMasuk" action="#" method="post">
          <?= csrf_field() ?>
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<!-- 🔌 Panggil JS modular -->

<script>
    // Checkbox select all & enable bulk delete
    document.addEventListener('DOMContentLoaded', function () {
        const selectAll = document.getElementById('selectAll');
        const rowCheckboxes = document.querySelectorAll('.rowCheckbox');
        const btnBulkDelete = document.getElementById('btnBulkDelete');
        const confirmBulkDelete = document.getElementById('confirmBulkDelete');
    function updateBulkDeleteVisibility() {
        const checked = Array.from(rowCheckboxes).some(cb => cb.checked);
        // Smooth animation
        if (checked) {
            btnBulkDelete.classList.remove('d-none');
            btnBulkDelete.classList.add('show');
        } else {
            btnBulkDelete.classList.remove('show');
            setTimeout(() => {
                if (!btnBulkDelete.classList.contains('show')) {
                    btnBulkDelete.classList.add('d-none');
                }
            }, 300);
        }
    }
        selectAll.addEventListener('change', function () {
            rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
            updateBulkDeleteVisibility();
        });
        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', function () {
                updateBulkDeleteVisibility();
                selectAll.checked = Array.from(rowCheckboxes).every(cb => cb.checked);
            });
        });
        // Submit bulk delete hanya setelah konfirmasi di modal
        if (confirmBulkDelete) {
            confirmBulkDelete.addEventListener('click', function () {
                document.getElementById('formBulkDelete').submit();
            });
        }
        updateBulkDeleteVisibility();
    });
    // Script untuk mengisi konten modal hapus surat masuk
    document.addEventListener('DOMContentLoaded', function () {
        const modalHapus = document.getElementById('modalHapusSuratMasuk');
        modalHapus.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget; // Tombol yang memicu modal
            const id = button.getAttribute('data-id');
            const pengirim = button.getAttribute('data-pengirim');
            const nomor = button.getAttribute('data-nomor');
            const actionUrl = button.getAttribute('data-action');

            // Update konten modal
            const modalBody = document.getElementById('hapusMasukModalBody');
            modalBody.innerHTML = `
                🗑️ Hapus surat dari <strong>${pengirim}</strong>?<br>
                Nomor: <strong>${nomor}</strong>
            `;

            // Update action form
            const formHapus = document.getElementById('formHapusSuratMasuk');
            formHapus.setAttribute('action', actionUrl);
        });
    }); 
</script>

<?= $this->endSection() ?>