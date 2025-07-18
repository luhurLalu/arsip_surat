<!-- 📝 Modal Edit Surat Keluar -->
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="modal fade" id="modalEditSuratKeluar" tabindex="-1" aria-labelledby="modalEditSuratKeluarLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-white border-warning">
      <div class="modal-header">
        <h5 class="modal-title" id="modalEditSuratKeluarLabel">
          <i class="bi bi-pencil-square text-warning me-2"></i> Edit Surat Keluar
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <form id="formEditSuratKeluar" method="post" enctype="multipart/form-data" class="form-dark" action="#">
        <div class="modal-body">
          <input type="hidden" name="id" id="edit_id">
          <?= csrf_field() ?>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="edit_nomor_surat" class="form-label">Nomor Surat</label>
              <input type="text" name="nomor_surat" id="edit_nomor_surat" class="form-control" readonly required value="<?= isset($surat['nomor_surat']) ? esc($surat['nomor_surat']) : '' ?>">
            </div>
            <div class="col-md-6">
              <label for="edit_pengirim" class="form-label">Asal Surat</label>
              <input type="text" name="pengirim" id="edit_pengirim" class="form-control text-uppercase" required value="">
            </div>
          </div>
          <div class="row mb-3">
            <div class="col-md-6">
              <label for="edit_tanggal_kirim" class="form-label">Tanggal Kirim</label>
              <input type="text" name="tanggal_kirim" id="edit_tanggal_kirim" class="form-control" required value="<?= isset($surat['tanggal_kirim']) ? esc($surat['tanggal_kirim']) : '' ?>">
            </div>
            <div class="col-md-6">
              <label for="edit_perihal" class="form-label">Perihal</label>
              <input type="text" name="perihal" id="edit_perihal" class="form-control text-uppercase" required value="<?= isset($surat['perihal']) ? esc($surat['perihal']) : '' ?>">
            </div>
          </div>
          <div class="mb-4">
            <div class="row">
              <div class="col-md-6">
                <label for="edit_file_surat" class="form-label">Ganti File (Opsional)</label>
                <input type="file" name="file_surat" id="edit_file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
                <?php if (!empty($surat['file_surat'])): ?>
                  <div id="edit_fileLama" class="form-text text-light mt-1">File lama: <a href="<?= base_url('uploads/suratkeluar/' . $surat['file_surat']) ?>" target="_blank" class="text-info"><?= esc($surat['file_surat']) ?></a></div>
                <?php endif; ?>
                <div id="edit_filePreview" class="mt-2 text-info small"></div>
                <div id="edit_fileLama" class="form-text text-light mt-1"></div>
              </div>
              <div class="col-md-6">
                <label for="edit_tujuan_surat" class="form-label">Tujuan Surat</label>
                <?php
                $presetTujuan = [
                  'KEPALA KANTOR',
                  'KASUBBAG TU',
                  'SEKRETARIAT',
                  'BIMBINGAN MASYARAKAT',
                  'PENDIDIKAN AGAMA ISLAM',
                  'PENYELENGGARA HAJI',
                ];
                $isLainnya = isset($surat['tujuan_surat']) && !in_array($surat['tujuan_surat'], $presetTujuan);
                ?>
                <select name="tujuan_surat" id="edit_tujuan_surat" class="form-select text-uppercase" required>
                  <option value="">- Pilih Tujuan Surat -</option>
                  <?php foreach ($presetTujuan as $opt): ?>
                    <option value="<?= $opt ?>" <?= (isset($surat['tujuan_surat']) && $surat['tujuan_surat'] == $opt) ? 'selected' : '' ?>><?= $opt ?></option>
                  <?php endforeach; ?>
                  <option value="Lainnya" <?= $isLainnya ? 'selected' : '' ?>>Lainnya</option>
                </select>
                <input type="text" name="tujuan_surat_lainnya" id="edit_tujuan_surat_lainnya" class="form-control text-uppercase mt-2" placeholder="Isi tujuan surat lainnya..." style="display:none;" value="<?= $isLainnya ? $surat['tujuan_surat'] : '' ?>">
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    var tujuanSelect = document.getElementById('edit_tujuan_surat');
                    var tujuanLainnya = document.getElementById('edit_tujuan_surat_lainnya');

                    function toggleLainnya() {
                      if (tujuanSelect.value === 'Lainnya') {
                        tujuanLainnya.style.display = '';
                        tujuanLainnya.required = true;
                      } else {
                        tujuanLainnya.style.display = 'none';
                        tujuanLainnya.required = false;
                      }
                    }
                    tujuanSelect.addEventListener('change', toggleLainnya);
                    toggleLainnya();
                  });
                </script>
              </div>
            </div>
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