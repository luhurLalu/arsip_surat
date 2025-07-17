
<!-- 📝 Modal Edit Surat Tugas -->
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="modal fade" id="modalEditSuratTugas" tabindex="-1" aria-labelledby="modalEditSuratTugasLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-warning">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditSuratTugasLabel">
          <i class="bi bi-pencil-square text-warning me-2"></i> Edit Surat Tugas
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditSuratTugas" method="post" enctype="multipart/form-data" class="form-dark" action="#">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id_tugas">
          <?= csrf_field() ?>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="edit_nomor_surat_tugas" class="form-label">Nomor Surat</label>
              <input type="text" name="nomor_surat" id="edit_nomor_surat_tugas" class="form-control" readonly required>
            </div>
            <div class="col-md-6">
              <label for="edit_tujuan_tugas" class="form-label">Tujuan</label>
              <input type="text" name="tujuan" id="edit_tujuan_tugas" class="form-control text-uppercase" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="edit_tanggal_tugas" class="form-label">Tanggal Tugas</label>
              <input type="text" name="tanggal_tugas" id="edit_tanggal_tugas" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="edit_perihal_tugas" class="form-label">Perihal</label>
              <input type="text" name="perihal" id="edit_perihal_tugas" class="form-control text-uppercase" required>
            </div>
          </div>
          <div class="mb-4">
            <label for="edit_file_surat_tugas" class="form-label">Ganti File (Opsional)</label>
            <input type="file" name="file_surat" id="edit_file_surat_tugas" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            <div id="edit_filePreview_tugas" class="mt-2 text-info small"></div>
            <div id="edit_fileLama_tugas" class="form-text text-light mt-1"></div>
          </div>
        </div>
        <div class="modal-footer border-top pt-3">
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-warning btn-sm text-dark">
            <i class="bi bi-save-fill"></i> Update
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  let flatpickrEditTugas;
  document.addEventListener('DOMContentLoaded', function() {
    if (window.flatpickrEditTugas) {
      window.flatpickrEditTugas.setDate(document.getElementById('edit_tanggal_tugas').value, true);
    }
    flatpickrEditTugas = flatpickr("#edit_tanggal_tugas", {
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "l, d F Y",
      allowInput: true
    });
    window.flatpickrEditTugas = flatpickrEditTugas;
  });

  const inputFileEditTugas = document.getElementById("edit_file_surat_tugas");
  const previewFileEditTugas = document.getElementById("edit_filePreview_tugas");
  window.fileIcons = window.fileIcons || {
    pdf: 'bi-file-earmark-pdf-fill text-danger',
    doc: 'bi-file-earmark-word-fill text-primary',
    docx: 'bi-file-earmark-word-fill text-primary',
    jpg: 'bi-file-earmark-image-fill text-warning',
    jpeg: 'bi-file-earmark-image-fill text-warning',
    png: 'bi-file-earmark-image-fill text-warning'
  };
  inputFileEditTugas.addEventListener("change", function () {
    const file = this.files[0];
    if (!file) return previewFileEditTugas.innerHTML = "";
    const ext = file.name.split('.').pop().toLowerCase();
    const icon = window.fileIcons[ext] || 'bi-file-earmark-fill text-light';
    const sizeMB = (file.size / 1024 / 1024).toFixed(2);
    previewFileEditTugas.innerHTML = `<i class=\"bi ${icon}\"></i> ${file.name} (${sizeMB} MB)`;
  });
</script>
