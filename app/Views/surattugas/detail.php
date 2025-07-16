<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

<div class="content-wrapper">
    <div class="row-balanced">
        <?php
        $file = $surat['file_surat'] ?? '';
        $ext  = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $fileUrl = base_url('uploads/surattugas/' . $file);
        ?>

        <div class="card shadow card-custom">
            <div class="card-header bg-dark text-white">
                <i class="bi bi-file-earmark-text-fill text-info"></i> Preview Dokumen
            </div>
            <div class="preview-zone text-center">
                <?php if (!$file): ?>
                    <p class="text-muted py-5">📭 File belum tersedia</p>
                <?php elseif (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])): ?>
                    <img src="<?= $fileUrl ?>" alt="Preview Gambar" class="img-fluid rounded shadow w-100 mb-3">
                <?php elseif ($ext === 'pdf'): ?>
                    <iframe src="<?= $fileUrl ?>" title="Preview PDF" width="100%" height="400px" style="border:1px solid #444; border-radius:8px; background:#232c3a;"></iframe>
                <?php else: ?>
                    <div class="text-warning py-4">
                        <p><strong><?= strtoupper($ext) ?></strong> tidak bisa dipreview langsung</p>
                        <a href="<?= base_url('uploads/surattugas/' . $file) ?>" class="btn btn-outline-light btn-sm">📥 Download File</a>
                    </div>
                <?php endif ?>
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
                <dl class="row mb-4 text-light">
                    <dt class="col-sm-4">Nomor Surat</dt>
                    <dd class="col-sm-8"><?= esc($surat['nomor_surat']) ?></dd>

                    <dt class="col-sm-4">Tujuan</dt>
                    <dd class="col-sm-8"><?= esc($surat['tujuan']) ?></dd>

                    <dt class="col-sm-4">Tanggal Tugas</dt>
                    <dd class="col-sm-8"><?= esc($surat['tanggal_tugas']) ?></dd>

                    <dt class="col-sm-4">Perihal</dt>
                    <dd class="col-sm-8"><?= esc($surat['perihal']) ?></dd>

                    <?php if (!empty($surat['created_at'])): ?>
                        <dt class="col-sm-4">Waktu Input</dt>
                        <dd class="col-sm-8"><?= esc($surat['created_at']) ?></dd>
                    <?php endif ?>

                    <?php if (!empty($surat['updated_at'])): ?>
                        <dt class="col-sm-4">Update Terakhir</dt>
                        <dd class="col-sm-8"><?= esc($surat['updated_at']) ?></dd>
                    <?php endif ?>
                </dl>

                <div class="d-flex justify-content-between border-top pt-3 mt-auto">
                    <a href="/surattugas" class="btn btn-secondary btn-sm">← Kembali</a>
                    <?php if ($file): ?>
                        <a href="<?= $fileUrl ?>" class="btn btn-outline-light btn-sm">📥 Download</a>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>