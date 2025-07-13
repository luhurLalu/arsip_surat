<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>


<div class="dashboard-wrapper">

  <section class="dashboard-card shadow-sm">
    <div class="card-header">
      <div class="marquee">
        <span>📌 ARSIP SURAT KEMENAG KABUPATEN LOMBOK UTARA</span>
      </div>
    </div>
    <div class="chart-row">
      <div class="chart-container">
        <canvas id="chartSurat"></canvas>
      </div>
      <div class="chart-description">
        <div class="desc-box">
          <h5>📥 Surat Masuk</h5>
          <div class="value"><?= $totalMasuk ?></div>
          <div class="note">Total surat yang diterima tahun ini</div>
        </div>
        <div class="desc-box">
          <h5>📤 Surat Keluar</h5>
          <div class="value"><?= $totalKeluar ?></div>
          <div class="note">Total surat yang dikirim tahun ini</div>
        </div>
        <div class="desc-box">
          <h5>🔍 Insight</h5>
          <div class="note">
            <?= $totalMasuk > $totalKeluar
              ? 'Jumlah surat masuk lebih tinggi dari surat keluar.'
              : ($totalMasuk < $totalKeluar
                ? 'Jumlah surat keluar lebih tinggi dari surat masuk.'
                : 'Jumlah surat masuk dan keluar seimbang.') ?>
          </div>
        </div>
      </div>
    </div>
  </section>

</div>


<!-- Chart.js (CDN) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js" defer></script>
<!-- Chart Data for JS -->
<script type="application/json" id="chart-surat-data">
  <?= json_encode([
    'labels' => ['Surat Masuk', 'Surat Keluar'],
    'data' => [(int)$totalMasuk, (int)$totalKeluar]
  ]) ?>
</script>
<!-- Chart init moved to public/js/index.js for modularity -->

<?= $this->endSection() ?>