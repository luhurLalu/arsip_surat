<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
    /* Tombol Hapus Terpilih animasi smooth dan keren, sama seperti surat masuk */
    /* Efek transisi tombol Hapus Terpilih konsisten seperti surat tugas */
    .bulkdelete-anim {
        opacity: 0;
        transform: translateY(-10px);
        transition: opacity 0.3s cubic-bezier(.4, 0, .2, 1), transform 0.3s cubic-bezier(.4, 0, .2, 1);
        pointer-events: none;
    }

    .bulkdelete-anim.show {
        opacity: 1;
        transform: translateY(0);
        pointer-events: auto;
    }
</style>

<div class="container mt-3">
    <!-- ✅ Toast Notification -->
    <div class="position-fixed top-0 end-0 p-3 toast-z">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-check-circle-fill me-2"></i><?= session()->getFlashdata('success') ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        <?php elseif (session()->getFlashdata('error')): ?>
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i><?= session()->getFlashdata('error') ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        <?php endif ?>
    </div>

    <!-- 🧭 Header Surat Keluar -->
    <div class="mb-3">
        <h2 class="m-0 text-light fw-bold heading-poppins">📤 Arsip Surat Keluar</h2>
    </div>

    <!-- 🔍 Live Search & Pagination -->
    <div class="d-flex justify-content-between align-items-center flex-wrap mb-3 gap-2">
        <div class="d-flex align-items-center gap-2 flex-wrap" style="flex:1;">
            <div class="input-group search-group">
                <span class="input-group-text bg-dark text-white"><i class="bi bi-search"></i></span>
                <input type="text" class="form-control text-uppercase" id="searchInput" placeholder="Cari berdasarkan nomor, tujuan, atau perihal...">
            </div>
            <div style="min-width:38px;display:flex;align-items:center;">
                <button type="button" class="btn btn-danger btn-sm bulkdelete-anim d-none" id="btnBulkDeleteKeluar" data-bs-toggle="modal" data-bs-target="#modalBulkDeleteKeluar" style="margin-left:8px;">
                    <i class="bi bi-trash-fill"></i> Hapus Terpilih
                </button>
            </div>
        </div>
        <nav>
            <ul class="pagination mb-0" id="paginationControls"></ul>
        </nav>
    </div>

    <!-- 🔔 Pesan jika tidak ditemukan -->
    <div id="noResultMessage" class="text-center text-warning fw-bold my-3 d-none">
        🔍 Data tidak ditemukan.
    </div>

    <!-- 📝 Tabel Surat Keluar -->
    <div class="table-responsive">
        <form id="formBulkDeleteKeluar" method="post" action="<?= base_url('suratkeluar/bulkdelete') ?>">
            <!-- Tombol hapus terpilih hanya di header, tidak perlu di sini lagi -->
            <table class="table table-dark table-bordered table-hover align-middle" id="suratTable">
                <thead class="table-light text-center">
                    <tr>
                        <th class="col-check" style="width:32px;padding:0;vertical-align:middle;">
                            <input type="checkbox" id="selectAllKeluar" class="form-check-input m-0" style="width:18px;height:18px;background-color:#fff;border:2px solid #888;box-shadow:0 0 2px #000;">
                        </th>
                        <th class="col-no">No</th>
                        <th class="col-nomor">Nomor Surat</th>
                        <th class="col-pengirim">Asal Surat</th>
                        <th class="col-tujuan">Tujuan Surat</th>
                        <th class="col-tanggal">Tanggal Terima</th>
                        <th class="col-perihal">Perihal</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    usort($suratkeluar, fn($a, $b) => strtotime($b['tanggal_kirim']) <=> strtotime($a['tanggal_kirim']));
                    $no = 1;
                    foreach ($suratkeluar as $s): ?>
                        <tr class="paginated">
                            <td class="text-center" style="width:32px;padding:0;vertical-align:middle;">
                                <input type="checkbox" class="rowCheckboxKeluar form-check-input m-0" name="ids[]" value="<?= $s['id'] ?>" style="width:18px;height:18px;">
                            </td>
                            <td class="text-center"><?= $no++ ?></td>
                            <td class="col-nomor">
                                <span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['nomor_surat']) ?>"><?= esc($s['nomor_surat']) ?></span>
                            </td>
                            <td class="col-pengirim">
                                <span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['tujuan'] ?? '-') ?>">
                                    <?= esc($s['tujuan'] ?? '-') ?>
                                </span>
                            </td>
                            <td class="col-tujuan">
                                <span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['tujuan_surat']) ?>"><?= esc($s['tujuan_surat']) ?></span>
                            </td>
                            <td class="text-center">
                                <?= esc($s['tanggal_kirim'] ?? '-') ?>
                            </td>
                            <td class="col-perihal">
                                <span class="truncate-text" data-bs-toggle="tooltip" title="<?= esc($s['perihal']) ?>"><?= esc($s['perihal']) ?></span>
                            </td>
                            <td class="text-center text-nowrap">
                                <div class="d-flex justify-content-center flex-wrap gap-1">
                                    <a href="<?= base_url('suratkeluar/detail/' . $s['id']) ?>" class="btn btn-info btn-sm text-white"><i class="bi bi-eye-fill"></i></a>
                                    <a href="#" class="btn btn-warning btn-sm text-dark btn-edit-suratkeluar"
                                        data-id="<?= $s['id'] ?>"
                                        data-nomor="<?= esc($s['nomor_surat']) ?>"
                                        data-pengirim="<?= esc($s['pengirim'] ?? $s['tujuan'] ?? '-') ?>"
                                        data-tujuan="<?= esc($s['tujuan_surat']) ?>"
                                        data-tanggal="<?= esc($s['tanggal_kirim']) ?>"
                                        data-perihal="<?= esc($s['perihal']) ?>"
                                        data-file="<?= esc($s['file_surat']) ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalEditSuratKeluar">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="<?= base_url('uploads/suratkeluar/' . $s['file_surat']) ?>" class="btn btn-secondary btn-sm text-white" download><i class="bi bi-download"></i></a>
                                    <button class="btn btn-danger btn-sm text-white btn-hapus-suratkeluar"
                                        data-id="<?= $s['id'] ?>"
                                        data-tujuan="<?= esc($s['tujuan']) ?>"
                                        data-nomor="<?= esc($s['nomor_surat']) ?>"
                                        data-action="<?= base_url('suratkeluar/delete/' . $s['id']) ?>"
                                        data-bs-toggle="modal" data-bs-target="#modalHapusSuratKeluar">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </form>


        <!-- 🧨 Modal Hapus BULK Surat Keluar -->
        <div class="modal fade" id="modalBulkDeleteKeluar" tabindex="-1" aria-labelledby="modalBulkDeleteKeluarLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-dark text-white border-danger">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalBulkDeleteKeluarLabel">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        🗑️ <strong>Hapus Item yg Dipilih?</strong>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="confirmBulkDeleteKeluar">Ya, Hapus</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- 📝 Modal Edit Surat Keluar -->
<?= view('suratkeluar/modal_edit') ?>

</div>

<!-- 🧨 Modal Hapus GLOBAL (pindah ke luar container) -->
<div class="modal fade" id="modalHapusSuratKeluar" tabindex="-1" aria-labelledby="modalHapusSuratKeluarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-dark text-white border-danger">
            <div class="modal-header">
                <h5 class="modal-title" id="modalHapusSuratKeluarLabel">Konfirmasi Hapus</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="hapusModalBody">
                <!-- Diisi dinamis oleh JS -->
            </div>
            <div class="modal-footer">
                <form id="formHapusSuratKeluar" action="#" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">Ya, Hapus</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

<!-- 🔌 Panggil JS modular -->
<script>
    // Checkbox select all & enable bulk delete Surat Keluar
    document.addEventListener('DOMContentLoaded', function() {
        // Bulk Delete Logic (modular, sama seperti surat tugas)
        const selectAll = document.getElementById('selectAllKeluar');
        const btnBulkDelete = document.getElementById('btnBulkDeleteKeluar');
        const confirmBulkDelete = document.getElementById('confirmBulkDeleteKeluar');

        function getRowCheckboxes() {
            return document.querySelectorAll('.rowCheckboxKeluar');
        }

        function updateBulkDeleteVisibility() {
            const rowCheckboxes = getRowCheckboxes();
            const checked = Array.from(rowCheckboxes).some(cb => cb.checked);
            // Smooth animation
            if (checked) {
                btnBulkDelete.classList.remove('d-none');
                btnBulkDelete.classList.add('show');
            } else {
                btnBulkDelete.classList.remove('show');
                // Delay d-none agar animasi sempat jalan
                setTimeout(() => {
                    if (!btnBulkDelete.classList.contains('show')) {
                        btnBulkDelete.classList.add('d-none');
                    }
                }, 300);
            }
            // Disable semua tombol hapus di kolom aksi jika ada yang dicentang
            document.querySelectorAll('.btn-hapus-suratkeluar').forEach(btn => {
                btn.disabled = checked;
                btn.classList.toggle('opacity-50', checked);
                btn.classList.toggle('pointer-events-none', checked);
            });
        }
        if (selectAll) {
            selectAll.addEventListener('change', function() {
                const rowCheckboxes = getRowCheckboxes();
                rowCheckboxes.forEach(cb => cb.checked = selectAll.checked);
                updateBulkDeleteVisibility();
            });
        }

        function attachRowCheckboxListeners() {
            const rowCheckboxes = getRowCheckboxes();
            rowCheckboxes.forEach(cb => {
                cb.addEventListener('change', function() {
                    const allChecked = Array.from(getRowCheckboxes()).every(cb => cb.checked);
                    selectAll.checked = allChecked;
                    updateBulkDeleteVisibility();
                });
            });
        }
        attachRowCheckboxListeners();
        updateBulkDeleteVisibility();
        if (confirmBulkDelete) {
            confirmBulkDelete.addEventListener('click', function() {
                document.getElementById('formBulkDeleteKeluar').submit();
            });
        }
        updateBulkDeleteVisibility();
    });
    // Modal Edit & Hapus Surat Keluar (khusus modal, bukan search/pagination)
    document.addEventListener('DOMContentLoaded', function() {
        // Modal Edit (isi otomatis modal_edit.php)
        const modalEdit = document.getElementById('modalEditSuratKeluar');
        if (modalEdit) {
            modalEdit.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                document.getElementById('formEditSuratKeluar').setAttribute('action', '/suratkeluar/update/' + button.getAttribute('data-id'));
                document.getElementById('edit_id_keluar').value = button.getAttribute('data-id');
                document.getElementById('edit_nomor_surat_keluar').value = button.getAttribute('data-nomor');
                document.getElementById('edit_tujuan_keluar').value = button.getAttribute('data-tujuan');
                // Set tanggal (flatpickr dan input)
                const tanggal = button.getAttribute('data-tanggal') || '';
                document.getElementById('edit_tanggal_keluar').value = tanggal;
                if (window.flatpickrEditKeluar) {
                    window.flatpickrEditKeluar.setDate(tanggal, true);
                }
                document.getElementById('edit_perihal_keluar').value = button.getAttribute('data-perihal');
                // Tampilkan file lama jika ada
                const fileLama = button.getAttribute('data-file') || '';
                const fileLamaDiv = document.getElementById('edit_fileLama_keluar');
                if (fileLama) {
                    const fileUrl = `/uploads/suratkeluar/${fileLama}`;
                    fileLamaDiv.innerHTML = `File lama: <a href='${fileUrl}' target='_blank' class='text-info text-decoration-underline'>Lihat File</a>`;
                } else {
                    fileLamaDiv.innerHTML = '';
                }
                // Reset preview file baru
                const previewFile = document.getElementById('edit_filePreview_keluar');
                if (previewFile) previewFile.innerHTML = '';
            });
        }
        // Modal Hapus 
        const modalHapus = document.getElementById('modalHapusSuratKeluar');
        if (modalHapus) {
            modalHapus.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-id');
                const tujuan = button.getAttribute('data-tujuan');
                const nomor = button.getAttribute('data-nomor');
                const actionUrl = button.getAttribute('data-action');
                const modalBody = document.getElementById('hapusModalBody');
                modalBody.innerHTML = `🗑️ Hapus surat ke <strong>${tujuan}</strong>?<br>Nomor: <strong>${nomor}</strong>`;
                document.getElementById('formHapusSuratKeluar').setAttribute('action', actionUrl);
            });
            // Pastikan form hanya di-submit saat tombol 'Ya, Hapus' diklik
            const formHapus = document.getElementById('formHapusSuratKeluar');
            if (formHapus) {
                formHapus.addEventListener('submit', function(e) {
                    // Tidak ada validasi bulk di sini, biarkan controller yang handle
                    // Pastikan tidak ada submit otomatis selain klik tombol submit
                });
            }
        }
    });
</script>

<?= $this->endSection() ?>