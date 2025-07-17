// Pastikan baseUrl tersedia di JS
var baseUrl = window.baseUrl || '';

// --- Pagination, search, dan handler utama ---
document.addEventListener("DOMContentLoaded", () => {
    const table = document.querySelector("#suratTable");
    const rows = table?.querySelectorAll("tbody tr") || [];
    const rowsPerPage = 7;
    let currentPage = 1;

    const searchInput = document.getElementById("searchInput");
    const paginationContainer = document.getElementById("paginationControls");
    const noResultMessage = document.getElementById("noResultMessage");

    function filterRows() {
        const keyword = searchInput?.value.toLowerCase() || "";
        rows.forEach(row => {
            const nomor = row.cells[1]?.textContent.toLowerCase() || "";
            const kolom2 = row.cells[2]?.textContent.toLowerCase() || "";
            const perihal = row.cells[4]?.textContent.toLowerCase() || "";
            const match = nomor.includes(keyword) || kolom2.includes(keyword) || perihal.includes(keyword);
            row.dataset.visible = match ? "true" : "false";
        });
    }

    function showPage(page) {
        currentPage = page;
        const visibleRows = Array.from(rows).filter(row => row.dataset.visible === "true");
        if (noResultMessage) {
            noResultMessage.classList.toggle("d-none", visibleRows.length !== 0);
        }
        rows.forEach(row => {
            row.style.display = "none";
        });
        visibleRows.forEach((row, i) => {
            if (i >= (page - 1) * rowsPerPage && i < page * rowsPerPage) {
                row.style.display = "";
                row.style.opacity = "1";
                row.style.transform = "scale(1)";
            }
        });
        renderPagination(visibleRows.length);
    }

    function renderPagination(totalVisible) {
        const totalPages = Math.ceil(totalVisible / rowsPerPage);
        paginationContainer.innerHTML = "";
        const prev = document.createElement("li");
        prev.className = "page-item" + (currentPage === 1 ? " disabled" : "");
        prev.innerHTML = `<button class="page-link">«</button>`;
        prev.querySelector("button").onclick = () => showPage(currentPage - 1);
        paginationContainer.appendChild(prev);
        for (let i = 1; i <= totalPages; i++) {
            const li = document.createElement("li");
            li.className = "page-item" + (i === currentPage ? " active" : "");
            li.innerHTML = `<button class="page-link">${i}</button>`;
            li.querySelector("button").onclick = () => showPage(i);
            paginationContainer.appendChild(li);
        }
        const next = document.createElement("li");
        next.className = "page-item" + (currentPage === totalPages ? " disabled" : "");
        next.innerHTML = `<button class="page-link">»</button>`;
        next.querySelector("button").onclick = () => showPage(currentPage + 1);
        paginationContainer.appendChild(next);
    }

    if (searchInput) {
        searchInput.addEventListener("input", () => {
            filterRows();
            showPage(1);
        });
    }
    filterRows();
    showPage(1);
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(el => new bootstrap.Tooltip(el));
});

// --- Modal Edit Surat Keluar ---
const editButtons = document.querySelectorAll('.btn-edit-suratkeluar');
const formEdit = document.getElementById('formEditSuratKeluar');
if (formEdit && editButtons.length > 0) {
  editButtons.forEach(btn => {
    btn.addEventListener('click', function (e) {
      document.getElementById('edit_id').value = this.dataset.id;
      document.getElementById('edit_nomor_surat').value = this.dataset.nomor;
      document.getElementById('edit_tujuan').value = this.dataset.tujuan;
      setTanggalEditSuratKeluar(this.dataset.tanggal);
      document.getElementById('edit_perihal').value = this.dataset.perihal;
      document.getElementById('edit_fileLama').innerHTML = this.dataset.file ? `File lama: <a href='${baseUrl}/uploads/suratkeluar/${this.dataset.file}' target='_blank' class='text-info'>Lihat File</a>` : '';
      formEdit.action = `${baseUrl}/suratkeluar/update/${this.dataset.id}`;
      document.getElementById('edit_file_surat').value = '';
      document.getElementById('edit_filePreview').innerHTML = '';
    });
  });
}

// --- Modal Edit Surat Masuk ---
const editButtonsMasuk = document.querySelectorAll('.btn-edit-suratmasuk');
const formEditMasuk = document.getElementById('formEditSuratMasuk');
if (formEditMasuk && editButtonsMasuk.length > 0) {
  editButtonsMasuk.forEach(btn => {
    btn.addEventListener('click', function () {
      document.getElementById('edit_id_masuk').value = this.dataset.id;
      document.getElementById('edit_nomor_surat_masuk').value = this.dataset.nomor;
      document.getElementById('edit_pengirim').value = this.dataset.pengirim;
      if (window.flatpickr && document.getElementById('edit_tanggal_terima')) {
        flatpickr('#edit_tanggal_terima').setDate(this.dataset.tanggal, true);
        document.getElementById('edit_tanggal_terima').value = this.dataset.tanggal;
      }
      document.getElementById('edit_perihal_masuk').value = this.dataset.perihal;
      document.getElementById('edit_fileLama_masuk').innerHTML = this.dataset.file ? `File lama: <a href='${baseUrl}/uploads/suratmasuk/${this.dataset.file}' target='_blank' class='text-info'>Lihat File</a>` : '';
      formEditMasuk.action = `${baseUrl}/suratmasuk/update/${this.dataset.id}`;
      document.getElementById('edit_file_surat_masuk').value = '';
      document.getElementById('edit_filePreview_masuk').innerHTML = '';
    });
  });
}

// --- Handler hapus surat keluar ---
const hapusButtons = document.querySelectorAll('.btn-hapus-suratkeluar');
const hapusModal = document.getElementById('modalHapusSuratKeluar');
const hapusModalBody = document.getElementById('hapusModalBody');
const formHapus = document.getElementById('formHapusSuratKeluar');
if (hapusButtons.length > 0 && hapusModal && hapusModalBody && formHapus) {
  hapusButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      const editModal = document.getElementById('modalEditSuratKeluar');
      if (editModal && editModal.classList.contains('show')) {
        const instance = bootstrap.Modal.getInstance(editModal);
        if (instance) instance.hide();
      }
      const tambahModal = document.getElementById('modalTambahSuratKeluar');
      if (tambahModal && tambahModal.classList.contains('show')) {
        const instance = bootstrap.Modal.getInstance(tambahModal);
        if (instance) instance.hide();
      }
      hapusModalBody.innerHTML = `🗑️ Hapus surat ke <strong>${this.dataset.tujuan}</strong>?<br>Nomor: <strong>${this.dataset.nomor}</strong>`;
      formHapus.action = this.dataset.action;
    });
  });
}

// --- Handler hapus surat masuk ---
const hapusMasukButtons = document.querySelectorAll('.btn-hapus-suratmasuk');
const hapusMasukModal = document.getElementById('modalHapusSuratMasuk');
const hapusMasukModalBody = document.getElementById('hapusMasukModalBody');
const formHapusMasuk = document.getElementById('formHapusSuratMasuk');
if (hapusMasukButtons.length > 0 && hapusMasukModal && hapusMasukModalBody && formHapusMasuk) {
  hapusMasukButtons.forEach(btn => {
    btn.addEventListener('click', function () {
      const editModal = document.getElementById('modalEditSuratMasuk');
      if (editModal && editModal.classList.contains('show')) {
        const instance = bootstrap.Modal.getInstance(editModal);
        if (instance) instance.hide();
      }
      const tambahModal = document.getElementById('modalTambahSurat');
      if (tambahModal && tambahModal.classList.contains('show')) {
        const instance = bootstrap.Modal.getInstance(tambahModal);
        if (instance) instance.hide();
      }
      hapusMasukModalBody.innerHTML = `🗑️ Hapus surat dari <strong>${this.dataset.pengirim}</strong>?<br>Nomor: <strong>${this.dataset.nomor}</strong>`;
      formHapusMasuk.action = this.dataset.action;
    });
  });
}

// --- Fungsi tanggal edit surat keluar ---
function setTanggalEditSuratKeluar(tanggal) {
  if (window.flatpickrEdit && document.getElementById('edit_tanggal_kirim')) {
    window.flatpickrEdit.setDate(tanggal, true);
    document.getElementById('edit_tanggal_kirim').value = tanggal;
  } else if (document.getElementById('edit_tanggal_kirim')) {
    document.getElementById('edit_tanggal_kirim').value = tanggal;
  }
}

// --- Preview file upload Modal Tambah Surat Masuk ---
document.addEventListener("DOMContentLoaded", () => {
  const inputFile = document.getElementById("modalFileSurat");
  const previewFile = document.getElementById("modalFilePreview");
  if (inputFile && previewFile) {
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
      if (!file) return previewFile.innerHTML = "";
      const ext = file.name.split('.').pop().toLowerCase();
      const icon = fileIcons[ext] || 'bi-file-earmark-fill text-light';
      const sizeMB = (file.size / 1024 / 1024).toFixed(2);
      previewFile.innerHTML = `<i class=\"bi ${icon}\"></i> ${file.name} (${sizeMB} MB)`;
    });
  }

  // --- Preview file upload Modal Edit Surat Masuk ---
  const inputFileEditMasuk = document.getElementById("edit_file_surat_masuk");
  const previewFileEditMasuk = document.getElementById("edit_filePreview_masuk");
  if (inputFileEditMasuk && previewFileEditMasuk) {
    window.fileIcons = window.fileIcons || {
      pdf: 'bi-file-earmark-pdf-fill text-danger',
      doc: 'bi-file-earmark-word-fill text-primary',
      docx: 'bi-file-earmark-word-fill text-primary',
      jpg: 'bi-file-earmark-image-fill text-warning',
      jpeg: 'bi-file-earmark-image-fill text-warning',
      png: 'bi-file-earmark-image-fill text-warning'
    };
    inputFileEditMasuk.addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return previewFileEditMasuk.innerHTML = "";
      const ext = file.name.split('.').pop().toLowerCase();
      const icon = window.fileIcons[ext] || 'bi-file-earmark-fill text-light';
      const sizeMB = (file.size / 1024 / 1024).toFixed(2);
      previewFileEditMasuk.innerHTML = `<i class=\\"bi ${icon}\\"></i> ${file.name} (${sizeMB} MB)`;
    });
  }

  // --- Flatpickr untuk modal tambah & edit surat masuk ---
  if (window.flatpickr) {
    if (document.getElementById("modalTanggalTerima")) {
      flatpickr("#modalTanggalTerima", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "l, d F Y",
        allowInput: true
      });
    }
    if (document.getElementById("edit_tanggal_terima")) {
      flatpickr("#edit_tanggal_terima", {
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "l, d F Y",
        allowInput: true
      });
    }
  }
});


// --- Preview file upload Modal Tambah Surat Keluar ---
document.addEventListener("DOMContentLoaded", () => {
  // Dashboard Chart.js init
  if (document.body.classList.contains('dashboard-page')) {
    const chartDataScript = document.getElementById('chart-surat-data');
    if (chartDataScript && window.Chart) {
      try {
        const chartData = JSON.parse(chartDataScript.textContent);
        const ctx = document.getElementById('chartSurat').getContext('2d');
        new Chart(ctx, {
          type: 'doughnut',
          data: {
            labels: chartData.labels,
            datasets: [{
              label: 'Distribusi Surat',
              data: chartData.data,
              // Biru untuk Masuk, Hijau untuk Keluar, Kuning untuk Tugas
              backgroundColor: ['#42a5f5', '#ffd600', '#66bb6a'],
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
      } catch (e) { console.error('Chart data error:', e); }
    }
  }

  const inputFileKeluar = document.getElementById("modalFileSuratKeluar");
  const previewFileKeluar = document.getElementById("modalFilePreviewKeluar");
  if (inputFileKeluar && previewFileKeluar) {
    const fileIcons = {
      pdf: 'bi-file-earmark-pdf-fill text-danger',
      doc: 'bi-file-earmark-word-fill text-primary',
      docx: 'bi-file-earmark-word-fill text-primary',
      jpg: 'bi-file-earmark-image-fill text-warning',
      jpeg: 'bi-file-earmark-image-fill text-warning',
      png: 'bi-file-earmark-image-fill text-warning'
    };
    inputFileKeluar.addEventListener("change", function () {
      const file = this.files[0];
      if (!file) return previewFileKeluar.innerHTML = "";
      const ext = file.name.split('.').pop().toLowerCase();
      const icon = fileIcons[ext] || 'bi-file-earmark-fill text-light';
      const sizeMB = (file.size / 1024 / 1024).toFixed(2);
      previewFileKeluar.innerHTML = `<i class=\\"bi ${icon}\\"></i> ${file.name} (${sizeMB} MB)`;
    });
  }

  // --- Flatpickr untuk modal tambah surat keluar ---
  if (window.flatpickr && document.getElementById("modalTanggalKirim")) {
    flatpickr("#modalTanggalKirim", {
      dateFormat: "Y-m-d",
      altInput: true,
      altFormat: "l, d F Y",
      allowInput: true
    });
  }
});
