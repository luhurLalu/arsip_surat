<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="container py-4">
  <h4 class="text-white mb-4">
    <i class="bi bi-plus-circle-fill text-info"></i> Tambah Surat Keluar
  </h4>

  <?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <?= session()->getFlashdata('error') ?>
      <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
  <?php endif; ?>

  <form action="<?= base_url('suratkeluar/store') ?>" method="post" enctype="multipart/form-data" class="form-dark">

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="nomor_surat" class="form-label">Nomor Surat</label>
        <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" required value="<?= old('nomor_surat') ?>">
      </div>
      <div class="col-md-6">
        <label for="pengirim" class="form-label">Asal Surat</label>
        <input type="text" name="pengirim" id="pengirim" class="form-control text-uppercase" required value="<?= old('pengirim') ?>">
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="tanggal_kirim" class="form-label">Tanggal Kirim</label>
        <input type="text" name="tanggal_kirim" id="tanggal_kirim" class="form-control" required value="<?= old('tanggal_kirim') ?>">
      </div>
      <div class="col-md-6">
        <label for="perihal" class="form-label">Perihal</label>
        <input type="text" name="perihal" id="perihal" class="form-control" required value="<?= old('perihal') ?>">
      </div>
    </div>
    <div class="mb-4">
      <div class="row">
        <div class="col-md-6">
          <label for="file_surat" class="form-label">File Surat (PDF/Gambar/Doc)</label>
          <input type="file" name="file_surat" id="file_surat" class="form-control" accept=".pdf,.jpg,.jpeg,.png,.gif,.doc,.docx">
          <div id="filePreview"></div>
        </div>
        <div class="col-md-6">
          <label for="tujuan_surat" class="form-label">Tujuan Surat</label>
          <select name="tujuan_surat" id="tujuan_surat" class="form-select" required onchange="toggleTujuanLainnya(this)">
            <option value="">- PILIH TUJUAN SURAT -</option>
            <option value="KEPALA KANTOR" <?= old('tujuan_surat')=='KEPALA KANTOR'?'selected':'' ?>>KEPALA KANTOR</option>
            <option value="KASUBBAG TU" <?= old('tujuan_surat')=='KASUBBAG TU'?'selected':'' ?>>KASUBBAG TU</option>
            <option value="SEKRETARIAT" <?= old('tujuan_surat')=='SEKRETARIAT'?'selected':'' ?>>SEKRETARIAT</option>
            <option value="BIMBINGAN MASYARAKAT" <?= old('tujuan_surat')=='BIMBINGAN MASYARAKAT'?'selected':'' ?>>BIMBINGAN MASYARAKAT</option>
            <option value="PENDIDIKAN AGAMA ISLAM" <?= old('tujuan_surat')=='PENDIDIKAN AGAMA ISLAM'?'selected':'' ?>>PENDIDIKAN AGAMA ISLAM</option>
            <option value="PENYELENGGARA HAJI" <?= old('tujuan_surat')=='PENYELENGGARA HAJI'?'selected':'' ?>>PENYELENGGARA HAJI</option>
            <option value="LAINNYA" <?= old('tujuan_surat')=='LAINNYA'?'selected':'' ?>>LAINNYA</option>
          </select>
          <input type="text" name="tujuan_surat_lainnya" id="tujuan_surat_lainnya" class="form-control mt-2" style="display:none;" placeholder="Isi tujuan surat lainnya..." value="<?= old('tujuan_surat_lainnya') ?>">
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-between mt-5 mb-2 border-top pt-3">
      <a href="<?= base_url('suratkeluar') ?>" class="btn btn-secondary btn-sm">← Batal</a>
      <button type="submit" class="btn btn-info btn-sm text-dark">
        <i class="bi bi-save-fill"></i> Simpan
      </button>
    </div>
  </form>

</div>
<!-- Flatpickr + Preview Dinamis -->
<script>
  document.addEventListener('DOMContentLoaded', function() {
    flatpickr("#tanggal_kirim", {
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "l, d F Y",
      allowInput: true
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
  inputFile.addEventListener("change", function() {
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