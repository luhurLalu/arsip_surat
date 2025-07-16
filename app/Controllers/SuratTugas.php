<?php

namespace App\Controllers;

use App\Models\SuratTugasModel;

class SuratTugas extends BaseController
{
    protected $suratTugas;

    public function __construct()
    {
        $this->suratTugas = new SuratTugasModel();
    }

    public function index()
    {
        $data['surattugas'] = $this->suratTugas->orderBy('tanggal_tugas', 'DESC')->findAll();
        return view('surattugas/index', $data);
    }

    public function create()
    {
        return view('surattugas/create');
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $rules = [
            'nomor_surat'    => 'required',
            'tujuan'         => 'required',
            'tanggal_tugas'  => 'required|valid_date',
            'perihal'        => 'required',
            'file_surat'     => 'uploaded[file_surat]|max_size[file_surat,2048]|ext_in[file_surat,pdf,jpg,jpeg,png,gif]'
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }
        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads/surattugas', $fileName);
        $this->suratTugas->save([
            'nomor_surat'   => $this->request->getPost('nomor_surat'),
            'tujuan'        => $this->request->getPost('tujuan'),
            'tanggal_tugas' => $this->request->getPost('tanggal_tugas'),
            'perihal'       => $this->request->getPost('perihal'),
            'file_surat'    => $fileName
        ]);
        return redirect()->to('surattugas')->with('success', 'Data berhasil disimpan.');
    }

    public function detail($id)
    {
        $data['surat'] = $this->suratTugas->find($id);
        return view('surattugas/detail', $data);
    }

    public function edit($id)
    {
        $data['surat'] = $this->suratTugas->find($id);
        return view('surattugas/edit', $data);
    }

    public function update($id)
    {
        $rules = [
            'nomor_surat'   => 'required',
            'tujuan'        => 'required',
            'tanggal_tugas' => 'required|valid_date',
            'perihal'       => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }
        $data = [
            'nomor_surat'   => $this->request->getPost('nomor_surat'),
            'tujuan'        => $this->request->getPost('tujuan'),
            'tanggal_tugas' => $this->request->getPost('tanggal_tugas'),
            'perihal'       => $this->request->getPost('perihal'),
        ];
        $file = $this->request->getFile('file_surat');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('uploads/surattugas', $newName);
            $data['file_surat'] = $newName;
        }
        $this->suratTugas->update($id, $data);
        return redirect()->to('surattugas')->with('success', 'Data berhasil diupdate.');
    }

    public function delete($id)
    {
        $surat = $this->suratTugas->find($id);
        if ($surat) {
            if ($surat['file_surat'] && file_exists('uploads/surattugas/' . $surat['file_surat'])) {
                unlink('uploads/surattugas/' . $surat['file_surat']);
            }
            $this->suratTugas->delete($id);
            return redirect()->to('surattugas')->with('success', 'Data berhasil dihapus.');
        }
        return redirect()->to('surattugas')->with('error', 'Data tidak ditemukan.');
    }
    public function cleanup()
    {
        $files = scandir('uploads/surattugas/');
        $dataFileSurat = array_column($this->suratTugas->findAll(), 'file_surat');

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            if (!in_array($file, $dataFileSurat)) {
                unlink('uploads/surattugas/' . $file);
            }
        }

        return redirect()->to('surattugas')->with('success', 'File tak terpakai berhasil dibersihkan.');
    }
}
