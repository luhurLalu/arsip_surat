<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<?php
function tanggal_indo($datetime) {
  if (!$datetime) return '-';

  $hari = [
    'Sun' => 'Minggu', 'Mon' => 'Senin', 'Tue' => 'Selasa',
    'Wed' => 'Rabu', 'Thu' => 'Kamis', 'Fri' => 'Jumat', 'Sat' => 'Sabtu'
  ];

  $bulan = [
    1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];

  $utc = new DateTime($datetime, new DateTimeZone('UTC'));
  $utc->setTimezone(new DateTimeZone('Asia/Makassar'));

  $hariIni = $hari[$utc->format('D')] ?? $utc->format('l');
  $tanggal = $utc->format('d');
  $bulanNum = (int) $utc->format('m');
  $tahun = $utc->format('Y');
  $jam = $utc->format('H:i');

  return "$hariIni, $tanggal " . $bulan[$bulanNum] . " $tahun pukul $jam WITA";
}
?>

<div class="content-wrapper">
  <div class="row-balanced">
    <?php
      $file = $surat['file_surat'] ?? '';
      $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
      // Samakan dengan surat masuk: PDF pakai route preview
      $fileUrl = ($ext === 'pdf') ? base_url('preview/' . $file) : base_url('uploads/suratkeluar/' . $file);
    ?>
    <div class="card shadow card-custom">
      <div class="card-header bg-dark text-white">
        <i class="bi bi-file-earmark-text-fill text-info"></i> Preview Dokumen
      </div>
      <div class="preview-zone">
        <?php if (!$file): ?>
          <p class="text-muted text-center py-5">📭 File belum tersedia</p>
        <?php elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
          <img src="<?= $fileUrl ?>" alt="Preview Gambar">
        <?php elseif ($ext === 'pdf'): ?>
          <iframe src="<?= $fileUrl ?>" title="Preview PDF"></iframe>
        <?php else: ?>
          <div class="text-center py-4 text-warning">
            <p><strong><?= strtoupper($ext) ?></strong> tidak bisa dipreview langsung</p>
            <a href="<?= base_url('uploads/suratkeluar/' . $file) ?>" class="btn btn-outline-light btn-sm">📥 Download File</a>
          </div>
        <?php endif ?>
<?= $this->section('scripts') ?>
<script>
// Cegah error JS global jika elemen tidak ada
document.addEventListener("DOMContentLoaded", function() {
  if (typeof paginationContainer !== 'undefined' && paginationContainer) {
    // ...fungsi JS terkait pagination...
  }
});
</script>
<?= $this->endSection() ?>
      </div>
      <?php if ($file): ?>
        <div class="card-footer text-end bg-dark">
          <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-outline-light btn-sm">
            🔗 Buka di Tab Baru
          </a>
        </div>
      <?php endif ?>
    </div>

    <div class="card shadow card-custom">
      <div class="card-header bg-dark text-white">
        <i class="bi bi-info-circle-fill text-info"></i> Informasi Surat
      </div>
      <div class="info-zone">
        <dl class="row mb-4">
          <dt class="col-sm-4">Nomor Surat</dt>
          <dd class="col-sm-8"><?= esc($surat['nomor_surat']) ?></dd>

          <dt class="col-sm-4">Tujuan</dt>
          <dd class="col-sm-8"><?= esc($surat['tujuan']) ?></dd>

          <dt class="col-sm-4">Tanggal Kirim</dt>
          <dd class="col-sm-8"><?= tanggal_indo($surat['tanggal_kirim']) ?></dd>

          <dt class="col-sm-4">Perihal</dt>
          <dd class="col-sm-8"><?= esc($surat['perihal']) ?></dd>

          <?php if (!empty($surat['created_at'])): ?>
            <dt class="col-sm-4">Waktu Input</dt>
            <dd class="col-sm-8"><?= tanggal_indo($surat['created_at']) ?></dd>
          <?php endif ?>

          <?php if (!empty($surat['updated_at'])): ?>
            <dt class="col-sm-4">Update Terakhir</dt>
            <dd class="col-sm-8"><?= tanggal_indo($surat['updated_at']) ?></dd>
          <?php endif ?>
        </dl>

        <div class="d-flex justify-content-between border-top pt-3 mt-auto">
          <a href="<?= base_url('suratkeluar') ?>" class="btn btn-secondary btn-sm">← Kembali</a>
          <?php if ($file): ?>
            <a href="<?= $fileUrl ?>" class="btn btn-outline-light btn-sm">📥 Download</a>
          <?php endif ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>