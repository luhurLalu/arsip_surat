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
    <div class="d-flex align-items-center gap-2 flex-wrap" style="flex:1;">
      <div class="input-group search-group">
        <span class="input-group-text bg-dark text-white"><i class="bi bi-search"></i></span>
        <input type="text" class="form-control text-uppercase" id="searchInput" placeholder="Cari berdasarkan nomor, tujuan, atau perihal...">
      </div>
      <div style="min-width:38px;">
        <button type="button" class="btn btn-danger btn-sm bulkdelete-anim d-none" id="btnBulkDeleteTugas" data-bs-toggle="modal" data-bs-target="#modalBulkDeleteTugas">
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

  <div class="table-responsive">
    <form id="formBulkDeleteTugas" method="post" action="<?= base_url('surattugas/bulkdelete') ?>">
      <table class="table table-dark table-bordered table-hover align-middle" id="suratTable">
        <thead class="table-light text-center">
          <tr>
            <th class="col-check" style="width:32px;padding:0;vertical-align:middle;">
              <input type="checkbox" id="selectAllTugas" class="form-check-input m-0" style="width:18px;height:18px;background-color:#fff;border:2px solid #888;box-shadow:0 0 2px #000;">
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
          <?php if (!empty($surattugas)): $no = 1;
            foreach ($surattugas as $surat): ?>
              <tr class="paginated">
                <td class="text-center" style="width:32px;padding:0;vertical-align:middle;">
                  <input type="checkbox" class="rowCheckboxTugas form-check-input m-0" name="ids[]" value="<?= $surat['id'] ?>" style="width:18px;height:18px;">
                </td>
                <td class="text-center"><?= $no++ ?></td>
                <td class="col-nomor">
                  <span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($surat['nomor_surat']) ?>"><?= esc($surat['nomor_surat']) ?></span>
                </td>
                <td class="col-pengirim"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($surat['tujuan'] ?? '-') ?>"><?= esc($surat['tujuan'] ?? '-') ?></span></td>
                <td class="col-tujuan"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($surat['tujuan_surat'] ?? '-') ?>"><?= esc($surat['tujuan_surat'] ?? '-') ?></span></td>
                <td class="text-center"><?= esc($surat['tanggal_tugas'] ?? '-') ?></td>
                <td class="col-perihal"><span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($surat['perihal']) ?>"><?= esc($surat['perihal']) ?></span></td>
                <td class="text-center text-nowrap">
                  <div class="d-flex justify-content-center flex-nowrap gap-1">
                    <a href="/surattugas/detail/<?= $surat['id'] ?>" class="btn btn-info btn-sm text-white"><i class="bi bi-eye-fill"></i></a>
                    <button type="button" class="btn btn-warning btn-sm text-dark btn-edit-surattugas"
                      data-id="<?= $surat['id'] ?>"
                      data-nomor="<?= esc($surat['nomor_surat']) ?>"
                      data-tujuan="<?= esc($surat['tujuan_surat'] ?? '-') ?>"
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
                      data-tujuan="<?= esc($surat['tujuan_surat'] ?? '-') ?>"
                      data-nomor="<?= esc($surat['nomor_surat']) ?>"
                      data-action="<?= base_url('surattugas/delete/' . $surat['id']) ?>"
                      data-bs-toggle="modal" data-bs-target="#modalHapusSuratTugas">
                      <i class="bi bi-trash-fill"></i>
                    </button>
                  </div>
                </td>
              </tr>
            <?php endforeach;
          else: ?>
            <tr>
              <td colspan="8" class="text-center">
                <div class="alert alert-warning mb-0">Data surat tugas kosong.</div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </form>
<!-- 🧨 Modal Hapus BULK Surat Tugas -->
<div class="modal fade" id="modalBulkDeleteTugas" tabindex="-1" aria-labelledby="modalBulkDeleteTugasLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-danger">
      <div class="modal-header">
        <h5 class="modal-title" id="modalBulkDeleteTugasLabel">Konfirmasi Hapus</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        🗑️ <strong>Hapus Item yg Dipilih?</strong>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" id="confirmBulkDeleteTugas">Ya, Hapus</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
      </div>
    </div>
  </div>
</div>

</div>

<?= view('surattugas/modal_edit') ?>

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

<script>
  // Checkbox select all & enable bulk delete Surat Tugas
  document.addEventListener('DOMContentLoaded', function () {
    const selectAll = document.getElementById('selectAllTugas');
    const btnBulkDelete = document.getElementById('btnBulkDeleteTugas');
    const confirmBulkDelete = document.getElementById('confirmBulkDeleteTugas');
    function getRowCheckboxes() {
      return document.querySelectorAll('.rowCheckboxTugas');
    }
    function updateBulkDeleteVisibility() {
      const rowCheckboxes = getRowCheckboxes();
      const checked = Array.from(rowCheckboxes).some(cb => cb.checked);
      // Smooth animation
      if (checked) {
        btnBulkDelete.classList.remove('d-none');
        btnBulkDelete.classList.add('show');
      } else {
        btnBulkDelete.classList.remove('show');
        // Delay d-none agar animasi sempat jalan
        setTimeout(() => {
          if (!btnBulkDelete.classList.contains('show')) {
            btnBulkDelete.classList.add('d-none');
          }
        }, 300);
      }
    }
    if (selectAll) {
      selectAll.addEventListener('change', function () {
        const rowCheckboxes = getRowCheckboxes();
        rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
        updateBulkDeleteVisibility();
      });
    }
    function attachRowCheckboxListeners() {
      const rowCheckboxes = getRowCheckboxes();
      rowCheckboxes.forEach(cb => {
        cb.addEventListener('change', function () {
          const allChecked = Array.from(getRowCheckboxes()).every(cb => cb.checked);
          selectAll.checked = allChecked;
          updateBulkDeleteVisibility();
        });
      });
    }
    attachRowCheckboxListeners();
    updateBulkDeleteVisibility();
    if (confirmBulkDelete) {
      confirmBulkDelete.addEventListener('click', function () {
        document.getElementById('formBulkDeleteTugas').submit();
      });
    }
    updateBulkDeleteVisibility();
  });
  // Modal Edit & Hapus Surat Tugas (khusus modal, bukan search/pagination)
  document.addEventListener('DOMContentLoaded', function() {
    // Modal Edit (isi otomatis modal_edit.php)
    const modalEdit = document.getElementById('modalEditSuratTugas');
    if (modalEdit) {
      modalEdit.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        document.getElementById('formEditSuratTugas').setAttribute('action', '/surattugas/update/' + button.getAttribute('data-id'));
        document.getElementById('edit_id_tugas').value = button.getAttribute('data-id');
        document.getElementById('edit_nomor_surat_tugas').value = button.getAttribute('data-nomor');
        document.getElementById('edit_tujuan_tugas').value = button.getAttribute('data-tujuan');
        // Set tanggal (flatpickr dan input)
        const tanggal = button.getAttribute('data-tanggal') || '';
        document.getElementById('edit_tanggal_tugas').value = tanggal;
        if (window.flatpickrEditTugas) {
          window.flatpickrEditTugas.setDate(tanggal, true);
        }
        document.getElementById('edit_perihal_tugas').value = button.getAttribute('data-perihal');
        // Tampilkan file lama jika ada
        const fileLama = button.getAttribute('data-file') || '';
        const fileLamaDiv = document.getElementById('edit_fileLama_tugas');
        if (fileLama) {
          const fileUrl = `/uploads/surattugas/${fileLama}`;
          fileLamaDiv.innerHTML = `File lama: <a href='${fileUrl}' target='_blank' class='text-info text-decoration-underline'>Lihat File</a>`;
        } else {
          fileLamaDiv.innerHTML = '';
        }
        // Reset preview file baru
        const previewFile = document.getElementById('edit_filePreview_tugas');
        if (previewFile) previewFile.innerHTML = '';
      });
    }
    // Modal Hapus
    const modalHapus = document.getElementById('modalHapusSuratTugas');
    if (modalHapus) {
      modalHapus.addEventListener('show.bs.modal', function(event) {
        const button = event.relatedTarget;
        const id = button.getAttribute('data-id');
        const tujuan = button.getAttribute('data-tujuan');
        const nomor = button.getAttribute('data-nomor');
        const actionUrl = button.getAttribute('data-action');
        const modalBody = document.getElementById('hapusTugasModalBody');
        modalBody.innerHTML = `🗑️ Hapus surat ke <strong>${tujuan}</strong>?<br>Nomor: <strong>${nomor}</strong>`;
        document.getElementById('formHapusSuratTugas').setAttribute('action', actionUrl);
      });
    }
  });
</script>

<?php $this->endSection(); ?>
<?= $this->endSection() ?>