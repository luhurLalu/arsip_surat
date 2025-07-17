<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="modal show fade" tabindex="-1" style="display:block; background:rgba(0,0,0,0.7); z-index:1050;">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content bg-dark text-light border-warning" style="border-width:2px;">
      <div class="modal-header border-0 pb-0">
        <h4 class="modal-title text-white mb-0">
          <i class="bi bi-pencil-square text-warning"></i> Edit Surat Tugas
        </h4>
        <button type="button" class="btn-close btn-close-white" onclick="window.location.href='/surattugas'"></button>
      </div>
      <div class="modal-body py-4 px-4">
        
        <?php if (session()->getFlashdata('error')): ?>
          <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
        <?php endif ?>
        
        <form action="/surattugas/update/<?= $surat['id'] ?>" method="post" enctype="multipart/form-data" class="form-dark">
            <?= csrf_field() ?>
            <input type="hidden" name="old_file" id="old_file" value="<?= esc($surat['file_surat']) ?>">

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="nomor_surat" class="form-label">Nomor Surat</label>
                <input type="text" name="nomor_surat" id="nomor_surat" class="form-control text-uppercase" value="<?= esc($surat['nomor_surat']) ?>" readonly required>
              </div>
              <div class="col-md-6">
                <label for="tujuan" class="form-label">Tujuan</label>
                <input type="text" name="tujuan" id="tujuan" class="form-control text-uppercase" value="<?= esc($surat['tujuan']) ?>" required>
              </div>
            </div>

            <div class="row mb-3">
              <div class="col-md-6">
                <label for="tanggal_tugas" class="form-label">Tanggal Tugas</label>
                <input type="text" name="tanggal_tugas" id="tanggal_tugas" class="form-control" value="<?= esc($surat['tanggal_tugas']) ?>" required>
              </div>
              <div class="col-md-6">
                <label for="perihal" class="form-label">Perihal</label>
                <input type="text" name="perihal" id="perihal" class="form-control text-uppercase" value="<?= esc($surat['perihal']) ?>" required>
              </div>
            </div>

            <div class="mb-4">
              <label for="file_surat" class="form-label">Ganti File (Opsional)</label>
              <input type="file" name="file_surat" id="file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx">
              <?php if (!empty($surat['file_surat'])): ?>
                <div class="form-text text-light mt-1">
                  File lama: <a href="<?= base_url('uploads/surattugas/' . esc($surat['file_surat'])) ?>" target="_blank" class="text-info">Lihat File</a>
                </div>
              <?php endif ?>
              <div id="filePreview"></div>
            </div>

            <div class="d-flex justify-content-between mt-5 mb-2 border-top pt-3">
              <a href="/surattugas" class="btn btn-secondary btn-sm">Batal</a>
              <button type="submit" class="btn btn-info btn-sm text-dark">
                <i class="bi bi-save-fill"></i> Update
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#tanggal_tugas", {
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "l, d F Y",
      allowInput: true,
      defaultDate: document.getElementById('tanggal_tugas').value
    });
  });

  const inputFile = document.getElementById("file_surat");
  const previewFile = document.getElementById("filePreview");

  const fileIcons = {
    pdf: 'bi-file-earmark-pdf-fill text-danger',
    doc: 'bi-file-earmark-word-fill text-primary',
    docx: 'bi-file-earmark-word-fill text-primary',
    jpg: 'bi-file-earmark-image-fill text-warning',
    jpeg: 'bi-file-earmark-image-fill text-warning',
    png: 'bi-file-earmark-image-fill text-warning'
  };

  inputFile.addEventListener("change", function () {
    const file = this.files[0];
    if (!file) {
      previewFile.innerHTML = "";
      return;
    }

    const ext = file.name.split('.').pop().toLowerCase();
    const icon = fileIcons[ext] || 'bi-file-earmark-fill text-light';
    const sizeMB = (file.size / 1024 / 1024).toFixed(2);
    const label = `<i class="bi ${icon}"></i> ${file.name} (${sizeMB} MB)`;

    previewFile.innerHTML = label;
  });
</script>
<?= $this->endSection() ?>