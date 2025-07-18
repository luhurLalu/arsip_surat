<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="container py-4">
  <h4 class="text-white mb-4">
    <i class="bi bi-plus-circle-fill text-info"></i> Tambah Surat Keluar
  </h4>

  <form action="<?= base_url('suratkeluar/store') ?>" method="post" enctype="multipart/form-data" class="form-dark">

    <div class="row mb-3">
      <div class="col-md-6">
        <label for="nomor_surat" class="form-label">Nomor Surat</label>
        <input type="text" name="nomor_surat" id="nomor_surat" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="pengirim" class="form-label">Asal Surat</label>
        <input type="text" name="pengirim" id="pengirim" class="form-control text-uppercase" required>
      </div>
    </div>
    <div class="row mb-3">
      <div class="col-md-6">
        <label for="tanggal_kirim" class="form-label">Tanggal Kirim</label>
        <input type="text" name="tanggal_kirim" id="tanggal_kirim" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label for="perihal" class="form-label">Perihal</label>
        <input type="text" name="perihal" id="perihal" class="form-control" required>
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
            <option value="">- Pilih Tujuan Surat -</option>
            <option value="Kepala Kantor">KEPALA KANTOR</option>
            <option value="KASUBBAG TU">KASUBBAG TU</option>
            <option value="SETJEN">SEKRETARIAT</option>
            <option value="BIMAS">BIMBINGAN MASYARAKAT ISLAM</option>
            <option value="PENDIS">PENDIDIKAN AGAMA ISLAM</option>
            <option value="PENYELENGGARA HAJI">PENYELENGGARA HAJI</option>
            <option value="Lainnya">Lainnya</option>
          </select>
          <input type="text" name="tujuan_surat_lainnya" id="tujuan_surat_lainnya" class="form-control mt-2" style="display:none;" placeholder="Isi tujuan surat lainnya...">
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