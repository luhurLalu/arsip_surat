<!-- 📝 Modal Edit Surat Masuk -->
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="modal fade" id="modalEditSuratMasuk" tabindex="-1" aria-labelledby="modalEditSuratMasukLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-warning">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditSuratMasukLabel">
          <i class="bi bi-pencil-square text-warning me-2"></i> Edit Surat Masuk
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditSuratMasuk" method="post" enctype="multipart/form-data" class="form-dark" action="#">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id_masuk">
          <?= csrf_field() ?>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="edit_nomor_surat_masuk" class="form-label">Nomor Surat</label>
              <input type="text" name="nomor_surat" id="edit_nomor_surat_masuk" class="form-control" readonly required>
            </div>
            <div class="col-md-6">
              <label for="edit_pengirim" class="form-label">Pengirim</label>
              <input type="text" name="pengirim" id="edit_pengirim" class="form-control text-uppercase" required>
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="edit_tanggal_terima" class="form-label">Tanggal Terima</label>
              <input type="text" name="tanggal_terima" id="edit_tanggal_terima" class="form-control" required>
            </div>
            <div class="col-md-6">
              <label for="edit_perihal_masuk" class="form-label">Perihal</label>
              <input type="text" name="perihal" id="edit_perihal_masuk" class="form-control text-uppercase" required>
            </div>
          </div>
          <div class="mb-4">
            <label for="edit_file_surat_masuk" class="form-label">Ganti File (Opsional)</label>
            <input type="file" name="file_surat" id="edit_file_surat_masuk" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
            <div id="edit_filePreview_masuk" class="mt-2 text-info small"></div>
            <div id="edit_fileLama_masuk" class="form-text text-light mt-1"></div>
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

