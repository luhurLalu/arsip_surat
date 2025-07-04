<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
  body {
    overflow-x: hidden;
    scroll-behavior: smooth;
  }

  .dashboard-wrapper {
    padding-top: 0;
  }

  .dashboard-card {
    background-color: #1e212d;
    border: 1px solid #2b2f3c;
    border-radius: 10px;
    color: white;
    padding: 1rem;
    margin-top: 0;
  }

  .dashboard-card .card-header {
    padding: 0.5rem 0;
    border-bottom: 1px solid #2c2c2c;
    overflow: hidden;
  }

  .marquee {
    white-space: nowrap;
    overflow: hidden;
    position: relative;
  }

  .marquee span {
    display: inline-block;
    padding-left: 100%;
    animation: marquee 12s linear infinite;
    font-weight: bold;
    font-size: 1rem;
    color: #81d4fa;
  }

  @keyframes marquee {
    0%   { transform: translateX(0); }
    100% { transform: translateX(-100%); }
  }

  .chart-row {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
  }

  @media (min-width: 768px) {
    .chart-row {
      flex-direction: row;
    }
  }

  .chart-container {
    flex: 1;
    max-width: 420px;
  }

  .chart-description {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .desc-box {
    background-color: #262b3a;
    border: 1px solid #3a3f4f;
    border-radius: 8px;
    padding: 1rem;
  }

  .desc-box h5 {
    margin: 0 0 0.5rem;
    font-size: 1rem;
    color: #81d4fa;
  }

  .desc-box .value {
    font-size: 1.4rem;
    font-weight: bold;
    color: #fff;
  }

  .desc-box .note {
    font-size: 0.9rem;
    color: #b0bec5;
    margin-top: 0.25rem;
  }

  canvas#chartSurat {
    width: 100% !important;
    height: auto !important;
  }
</style>

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

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('chartSurat').getContext('2d');
  new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: ['Surat Masuk', 'Surat Keluar'],
      datasets: [{
        label: 'Distribusi Surat',
        data: [<?= $totalMasuk ?>, <?= $totalKeluar ?>],
        backgroundColor: ['#42a5f5', '#66bb6a'],
        borderColor: '#1e212d',
        borderWidth: 4
      }]
    },
    options: {
      responsive: true,
      cutout: '60%',
      plugins: {
        legend: {
          position: 'bottom',
          labels: {
            color: '#ccc',
            font: { size: 13 }
          }
        },
        tooltip: {
          backgroundColor: '#222',
          titleFont: { size: 14, weight: 'bold' },
          bodyFont: { size: 13 }
        }
      }
    }
  });
</script>

<?= $this->endSection() ?>