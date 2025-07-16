<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="container py-4">
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

  <div class="d-flex justify-content-between align-items-center mb-3">
    <h4 class="text-white mb-0">
      <i class="bi bi-list-task text-success"></i> Daftar Surat Tugas
    </h4>
    <!-- Tombol tambah surat tugas dipindahkan ke navbar -->
  </div>
  <!-- 🔍 Live Search & Pagination -->
  <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
    <div class="input-group search-group">
      <span class="input-group-text bg-dark text-white"><i class="bi bi-search"></i></span>
      <input type="text" class="form-control text-uppercase" id="searchSuratTugas" placeholder="Cari berdasarkan nomor, tujuan, atau perihal...">
    </div>
    <nav>
      <ul class="pagination mb-0" id="paginationSuratTugas"></ul>
    </nav>
  </div>
  <!-- 🔔 Pesan jika tidak ditemukan -->
  <div id="noResultSuratTugas" class="text-center text-warning fw-bold my-3 d-none">
    🔍 Data tidak ditemukan.
  </div>
  <div class="card bg-dark text-light shadow">
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-bordered table-dark table-striped table-hover align-middle mb-0" id="suratTugasTable">
          <thead class="table-secondary text-dark">
            <tr>
              <th scope="col" class="text-center">No</th>
              <th scope="col">Nomor Surat</th>
              <th scope="col">Tujuan</th>
              <th scope="col">Tanggal Tugas</th>
              <th scope="col">Perihal</th>
              <th scope="col" class="text-center">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php if (!empty($surattugas)): $no=1; foreach ($surattugas as $surat): ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td class="col-nomor"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($surat['nomor_surat']) ?>"><?= esc($surat['nomor_surat']) ?></span></td>
              <td class="col-tujuan"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($surat['tujuan']) ?>"><?= esc($surat['tujuan']) ?></span></td>
              <td class="text-center"><?= esc($surat['tanggal_tugas']) ?></td>
              <td class="col-perihal"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($surat['perihal']) ?>"><?= esc($surat['perihal']) ?></span></td>
              <td class="text-center text-nowrap">
                <div class="d-flex justify-content-center flex-wrap gap-1">
                  <a href="/surattugas/detail/<?= $surat['id'] ?>" class="btn btn-info btn-sm text-white"><i class="bi bi-eye-fill"></i></a>
                  <button type="button" class="btn btn-warning btn-sm text-dark btn-edit-surattugas"
                    data-id="<?= $surat['id'] ?>"
                    data-nomor="<?= esc($surat['nomor_surat']) ?>"
                    data-tujuan="<?= esc($surat['tujuan']) ?>"
                    data-tanggal="<?= esc($surat['tanggal_tugas']) ?>"
                    data-perihal="<?= esc($surat['perihal']) ?>"
                    data-file="<?= esc($surat['file_surat']) ?>"
                    data-bs-toggle="modal" data-bs-target="#modalEditSuratTugas">
                    <i class="bi bi-pencil-fill"></i>
                  </button>
                  <?php if (!empty($surat['file_surat'])): ?>
                    <a href="/uploads/surattugas/<?= esc($surat['file_surat']) ?>" target="_blank" class="btn btn-secondary btn-sm text-white" download><i class="bi bi-download"></i></a>
                  <?php endif; ?>
                  <button type="button" class="btn btn-danger btn-sm text-white btn-hapus-surattugas"
                    data-id="<?= $surat['id'] ?>"
                    data-tujuan="<?= esc($surat['tujuan']) ?>"
                    data-nomor="<?= esc($surat['nomor_surat']) ?>"
                    data-action="<?= base_url('surattugas/delete/' . $surat['id']) ?>"
                    data-bs-toggle="modal" data-bs-target="#modalHapusSuratTugas">
                    <i class="bi bi-trash-fill"></i>
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
              <td colspan="6" class="text-center">
                <div class="alert alert-warning mb-0">Data surat tugas kosong.</div>
              </td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- 📝 Modal Edit Surat Tugas -->
<div class="modal fade" id="modalEditSuratTugas" tabindex="-1" aria-labelledby="modalEditSuratTugasLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content bg-dark text-white border-warning">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditSuratTugasLabel">Edit Surat Tugas</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditSuratTugas" action="#" method="post" enctype="multipart/form-data">
        <?= csrf_field() ?>
        <div class="modal-body">
          <input type="hidden" name="id" id="editIdSuratTugas">
          <div class="mb-2">
            <label>Nomor Surat</label>
            <input type="text" name="nomor_surat" id="editNomorSuratTugas" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Tujuan</label>
            <input type="text" name="tujuan" id="editTujuanSuratTugas" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Tanggal Tugas</label>
            <input type="date" name="tanggal_tugas" id="editTanggalSuratTugas" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>Perihal</label>
            <input type="text" name="perihal" id="editPerihalSuratTugas" class="form-control" required>
          </div>
          <div class="mb-2">
            <label>File Surat (PDF/JPG/PNG/GIF, max 2MB)</label>
            <input type="file" name="file_surat" id="editFileSuratTugas" class="form-control">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning">Simpan Perubahan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- 🧨 Modal Hapus Surat Tugas -->
<div class="modal fade" id="modalHapusSuratTugas" tabindex="-1" aria-labelledby="modalHapusSuratTugasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-danger">
      <div class="modal-header">
        <h5 class="modal-title" id="modalHapusSuratTugasLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body" id="hapusTugasModalBody">
        <!-- Diisi dinamis oleh JS -->
      </div>
      <div class="modal-footer">
        <form id="formHapusSuratTugas" action="#" method="post">
          <?= csrf_field() ?>
          <button type="submit" class="btn btn-danger">Ya, Hapus</button>
        </form>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

<?php $this->section('scripts'); ?>
<script>
  // Modal Edit Surat Tugas
  document.addEventListener('DOMContentLoaded', function () {
    const modalEdit = document.getElementById('modalEditSuratTugas');
    modalEdit.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      document.getElementById('formEditSuratTugas').setAttribute('action', '/surattugas/update/' + button.getAttribute('data-id'));
      document.getElementById('editIdSuratTugas').value = button.getAttribute('data-id');
      document.getElementById('editNomorSuratTugas').value = button.getAttribute('data-nomor');
      document.getElementById('editTujuanSuratTugas').value = button.getAttribute('data-tujuan');
      document.getElementById('editTanggalSuratTugas').value = button.getAttribute('data-tanggal');
      document.getElementById('editPerihalSuratTugas').value = button.getAttribute('data-perihal');
      // File tidak diisi otomatis demi keamanan
    });
    // Modal Hapus Surat Tugas
    const modalHapus = document.getElementById('modalHapusSuratTugas');
    modalHapus.addEventListener('show.bs.modal', function (event) {
      const button = event.relatedTarget;
      const id = button.getAttribute('data-id');
      const tujuan = button.getAttribute('data-tujuan');
      const nomor = button.getAttribute('data-nomor');
      const actionUrl = button.getAttribute('data-action');
      const modalBody = document.getElementById('hapusTugasModalBody');
      modalBody.innerHTML = `🗑️ Hapus surat ke <strong>${tujuan}</strong>?<br>Nomor: <strong>${nomor}</strong>`;
      document.getElementById('formHapusSuratTugas').setAttribute('action', actionUrl);
    });
    // Enable Bootstrap tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function(el) {
      new bootstrap.Tooltip(el, { animation: true, html: false });
    });
  });
</script>
<?php $this->endSection(); ?>
<?= $this->endSection() ?>
