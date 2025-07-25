<?php

namespace App\Controllers;

use App\Models\SuratKeluarModel;

class SuratKeluar extends BaseController
{
    protected $suratKeluar;

    public function __construct()
    {
        $this->suratKeluar = new SuratKeluarModel();
    }

    // 📄 Tampilkan semua surat keluar
    public function index()
    {
        $data['suratkeluar'] = $this->suratKeluar->orderBy('tanggal_kirim', 'DESC')->findAll();
        return view('suratkeluar/index', $data);
    }

    // ➕ Form tambah
    public function create()
    {
        return view('suratkeluar/create');
    }

    // ✅ Simpan surat keluar baru
    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'nomor_surat'    => 'required',
            'tujuan_surat'   => 'required',
            'tanggal_kirim'  => 'required|valid_date',
            'perihal'        => 'required',
            'file_surat'     => 'uploaded[file_surat]|max_size[file_surat,2048]|ext_in[file_surat,pdf,jpg,jpeg,png,gif]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        // Validasi nomor surat unik
        $nomorSurat = $this->request->getPost('nomor_surat');
        $existing = $this->suratKeluar->where('nomor_surat', $nomorSurat)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Nomor surat sudah ada di database, silakan gunakan nomor lain.');
        }

        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads/suratkeluar', $fileName);
        $tujuanSurat = $this->request->getPost('tujuan_surat');
        if ($tujuanSurat === 'Lainnya') {
            $tujuanSurat = $this->request->getPost('tujuan_surat_lainnya');
        }
        $this->suratKeluar->save([
            'nomor_surat'   => $nomorSurat,
            'tujuan_surat'  => $tujuanSurat,
            'tanggal_kirim' => $this->request->getPost('tanggal_kirim'),
            'perihal'       => $this->request->getPost('perihal'),
            'file_surat'    => $fileName
        ]);
        return redirect()->to('suratkeluar')->with('success', 'Data berhasil disimpan.');
    }

    // 🧐 Lihat detail surat keluar
    public function detail($id)
    {
        $data['surat'] = $this->suratKeluar->find($id);
        return view('suratkeluar/detail', $data);
    }

    // ✏️ Form edit
    public function edit($id)
    {
        $data['surat'] = $this->suratKeluar->find($id);
        return view('suratkeluar/edit', $data);
    }

    // 🔁 Update surat keluar
    public function update($id)
    {
        $rules = [
            'nomor_surat'   => 'required',
            'tujuan_surat'  => 'required',
            'tanggal_kirim' => 'required|valid_date',
            'perihal'       => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }
        $tujuanSurat = $this->request->getPost('tujuan_surat');
        if ($tujuanSurat === 'Lainnya') {
            $tujuanSurat = $this->request->getPost('tujuan_surat_lainnya');
        }
        $data = [
            'nomor_surat'   => $this->request->getPost('nomor_surat'),
            'tujuan_surat'  => $tujuanSurat,
            'tanggal_kirim' => $this->request->getPost('tanggal_kirim'),
            'perihal'       => $this->request->getPost('perihal'),
        ];
        $file = $this->request->getFile('file_surat');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('uploads/suratkeluar', $newName);
            $data['file_surat'] = $newName;
        }
        $this->suratKeluar->update($id, $data);
        return redirect()->to('suratkeluar')->with('success', 'Data berhasil diupdate.');
    }

    // ❌ Hapus surat keluar
    public function delete($id)
    {
        $surat = $this->suratKeluar->find($id);
        if ($surat) {
            if ($surat['file_surat'] && file_exists('uploads/suratkeluar/' . $surat['file_surat'])) {
                unlink('uploads/suratkeluar/' . $surat['file_surat']);
            }
            $this->suratKeluar->delete($id);
            return redirect()->to('suratkeluar')->with('success', 'Data berhasil dihapus.');
        }
        return redirect()->to('suratkeluar')->with('error', 'Data tidak ditemukan.');
    }
    public function cleanup()
    {
        $files = scandir('uploads/suratkeluar/');
        $dataFileSurat = array_column($this->suratKeluar->findAll(), 'file_surat');

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            if (!in_array($file, $dataFileSurat)) {
                unlink('uploads/suratkeluar/' . $file);
            }
        }

        return redirect()->to('suratkeluar')->with('success', 'File tak terpakai berhasil dibersihkan.');
    }

    // Bulk delete Surat Keluar 
    public function bulkdelete()
    {
        $ids = $this->request->getPost('ids');
        if (!$ids || !is_array($ids)) {
            return redirect()->to('suratkeluar')->with('error', 'Tidak ada data yang dipilih.');
        }
        $deleted = 0;
        foreach ($ids as $id) {
            $surat = $this->suratKeluar->find($id);
            if ($surat) {
                if ($surat['file_surat'] && file_exists('uploads/suratkeluar/' . $surat['file_surat'])) {
                    unlink('uploads/suratkeluar/' . $surat['file_surat']);
                }
                $this->suratKeluar->delete($id);
                $deleted++;
            }
        }
        if ($deleted > 0) {
            return redirect()->to('suratkeluar')->with('success', "$deleted data berhasil dihapus.");
        } else {
            return redirect()->to('suratkeluar')->with('error', 'Tidak ada data yang dihapus.');
        }
    }
}
