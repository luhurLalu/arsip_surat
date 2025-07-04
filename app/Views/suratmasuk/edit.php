<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/material_blue.css">

<style>
  input[type="text"],
  textarea {
    text-transform: uppercase;
  }

  .form-dark input,
  .form-dark select,
  .form-dark textarea {
    background-color: #1e212d;
    border: 1px solid #495057;
    color: white;
    min-height: 44px;
  }

  .form-dark input:focus,
  .form-dark textarea:focus,
  .form-dark select:focus {
    border-color: #0dcaf0;
    box-shadow: 0 0 0 0.15rem rgba(13, 202, 240, 0.25);
    background-color: #212531;
    color: white;
  }

  .form-label {
    color: #aeb6c1;
    font-weight: 500;
  }

  .btn-sm {
    padding: 6px 14px;
  }

  .btn-info.text-dark {
    background-color: #0dcaf0;
    border: none;
  }

  .btn-info.text-dark:hover {
    background-color: #31d2f2;
  }

  .btn-secondary {
    background-color: #6c757d;
    border: none;
  }

  .btn-secondary:hover {
    background-color: #5a6268;
  }

  #filePreview {
    color: #0dcaf0;
    font-size: 0.95rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
  }
</style>

<div class="container py-4">
  <h4 class="text-white mb-4">
    <i class="bi bi-pencil-square text-warning"></i> Edit Surat Masuk
  </h4>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
  <?php endif ?>

  <form action="<?= base_url('suratmasuk/update/' . $surat['id']) ?>" method="post" enctype="multipart/form-data" class="form-dark">
    <?= csrf_field() ?>
    <input type="hidden" name="old_file" value="<?= esc($surat['file_surat']) ?>">

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="nomor_surat" class="form-label">Nomor Surat</label>
        <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" value="<?= esc($surat['nomor_surat']) ?>" required>
      </div>
      <div class="col-md-6">
        <label for="pengirim" class="form-label">Pengirim</label>
        <input type="text" name="pengirim" id="pengirim" class="form-control" value="<?= esc($surat['pengirim']) ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="tanggal_terima" class="form-label">Tanggal Terima</label>
        <input type="text" name="tanggal_terima" id="tanggal_terima" class="form-control" value="<?= esc($surat['tanggal_terima']) ?>" required>
      </div>
      <div class="col-md-6">
        <label for="perihal" class="form-label">Perihal</label>
        <input type="text" name="perihal" id="perihal" class="form-control" value="<?= esc($surat['perihal']) ?>" required>
      </div>
    </div>

    <div class="mb-4">
      <label for="file_surat" class="form-label">Ganti File (Opsional)</label>
      <input type="file" name="file_surat" id="file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.doc,.docx">
      <?php if ($surat['file_surat']): ?>
        <div class="form-text text-light mt-1">
          File lama: <a href="<?= base_url('uploads/' . $surat['file_surat']) ?>" target="_blank" class="text-info">Lihat File</a>
        </div>
      <?php endif ?>
      <div id="filePreview"></div>
    </div>

    <div class="d-flex justify-content-between mt-5 mb-2 border-top pt-3">
      <a href="<?= base_url('suratmasuk') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
      <button type="submit" class="btn btn-info btn-sm text-dark">
        <i class="bi bi-save-fill"></i> Update
      </button>
    </div>

  </form>
</div>

<!-- Flatpickr + Preview Dinamis -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
  flatpickr("#tanggal_terima", {
    dateFormat: "Y-m-d",
    altInput: true,
    altFormat: "l, d F Y",
    allowInput: true
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