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
        $data['surat'] = $this->suratKeluar->orderBy('tanggal_kirim', 'DESC')->findAll();
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
        $validation = $this->validate([
            'nomor_surat'   => 'required|is_unique[surat_keluar.nomor_surat]',
            'tujuan'        => 'required',
            'tanggal_kirim' => 'required',
            'perihal'       => 'required',
            'file_surat'    => 'uploaded[file_surat]|max_size[file_surat,2048]|ext_in[file_surat,pdf,jpg,jpeg,png,gif]',
        ]);

        if (!$validation) {
            return redirect()->back()->withInput()->with('error', 'Data tidak valid!');
        }

        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads', $fileName);

        $this->suratKeluar->save([
            'nomor_surat'   => $this->request->getPost('nomor_surat'),
            'tujuan'        => $this->request->getPost('tujuan'),
            'tanggal_kirim' => $this->request->getPost('tanggal_kirim'),
            'perihal'       => $this->request->getPost('perihal'),
            'file_surat'    => $fileName
        ]);

        return redirect()->to('/suratkeluar')->with('success', 'Surat keluar berhasil disimpan.');
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
        $surat = $this->suratKeluar->find($id);
        $data = [
            'nomor_surat'   => $this->request->getPost('nomor_surat'),
            'tujuan'        => $this->request->getPost('tujuan'),
            'tanggal_kirim' => $this->request->getPost('tanggal_kirim'),
            'perihal'       => $this->request->getPost('perihal'),
        ];

        $file = $this->request->getFile('file_surat');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $valid = $this->validate([
                'file_surat' => 'max_size[file_surat,2048]|ext_in[file_surat,pdf,jpg,jpeg,png,gif]',
            ]);

            if (!$valid) {
                return redirect()->back()->withInput()->with('error', 'File tidak valid.');
            }

            $newName = $file->getRandomName();
            $file->move('uploads', $newName);
            $data['file_surat'] = $newName;

            if ($surat['file_surat'] && file_exists('uploads/' . $surat['file_surat'])) {
                unlink('uploads/' . $surat['file_surat']);
            }
        }

        $this->suratKeluar->update($id, $data);
        return redirect()->to('/suratkeluar')->with('success', 'Surat keluar berhasil diperbarui.');
    }

    // ❌ Hapus surat keluar
    public function delete($id)
    {
        $surat = $this->suratKeluar->find($id);
        if ($surat && $surat['file_surat'] && file_exists('uploads/' . $surat['file_surat'])) {
            unlink('uploads/' . $surat['file_surat']);
        }

        $this->suratKeluar->delete($id);
        return redirect()->to('/suratkeluar')->with('success', 'Surat keluar berhasil dihapus.');
    }
}
