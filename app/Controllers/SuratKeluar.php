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
            'tujuan'         => 'required',
            'tanggal_kirim'  => 'required|valid_date',
            'perihal'        => 'required',
            'file_surat'     => 'uploaded[file_surat]|max_size[file_surat,2048]|ext_in[file_surat,pdf,jpg,jpeg,png,gif]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads/suratkeluar', $fileName);
        $this->suratKeluar->save([
            'nomor_surat'   => $this->request->getPost('nomor_surat'),
            'tujuan'        => $this->request->getPost('tujuan'),
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
            'tujuan'        => 'required',
            'tanggal_kirim' => 'required|valid_date',
            'perihal'       => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }
        $data = [
            'nomor_surat'   => $this->request->getPost('nomor_surat'),
            'tujuan'        => $this->request->getPost('tujuan'),
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
}
