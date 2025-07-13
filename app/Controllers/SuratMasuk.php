<?php

namespace App\Controllers;

use App\Models\SuratMasukModel;

class SuratMasuk extends BaseController
{
    protected $suratMasuk;



    public function __construct()
    {
        $this->suratMasuk = new SuratMasukModel();
    }



    public function create()
    {
        return view('suratmasuk/create');
    }

    public function index()
    {
        $keyword = $this->request->getGet('keyword');
        $builder = $this->suratMasuk;

        if ($keyword) {
            $builder->like('nomor_surat', $keyword)
                    ->orLike('pengirim', $keyword)
                    ->orLike('perihal', $keyword);
        }

        $surat = $builder->orderBy('tanggal_terima', 'DESC')->findAll();
        // usort tidak perlu lagi karena sudah orderBy di query
        $data['surat'] = $surat;
        $data['keyword'] = $keyword;
        return view('suratmasuk/index', $data);
    }



    public function detail($id)
    {
        $surat = $this->suratMasuk->find($id);
        if (!$surat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Surat tidak ditemukan");
        }

        return view('suratmasuk/detail', ['surat' => $surat]);
    }

    public function edit($id)
    {
        $surat = $this->suratMasuk->find($id);
        if (!$surat) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException("Data tidak ditemukan");
        }

        return view('suratmasuk/edit', ['surat' => $surat]);
    }

    public function update($id)
    {
        $rules = [
            'nomor_surat'    => 'required',
            'pengirim'       => 'required',
            'tanggal_terima' => 'required|valid_date',
            'perihal'        => 'required',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $this->validator->listErrors());
        }

        $data = [
            'nomor_surat'    => $this->request->getPost('nomor_surat'),
            'pengirim'       => $this->request->getPost('pengirim'),
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
            'perihal'        => $this->request->getPost('perihal'),
        ];

        $file = $this->request->getFile('file_surat');
        if ($file && $file->isValid()) {
            $newName = $file->getRandomName();
            $file->move('uploads/suratmasuk', $newName);
            $data['file_surat'] = $newName;
        }

        $this->suratMasuk->update($id, $data);
        return redirect()->to('suratmasuk')->with('success', 'Data berhasil diupdate.');
    }

    public function delete($id)
    {
        $surat = $this->suratMasuk->find($id);
        if ($surat) {
            if (!empty($surat['file_surat']) && file_exists('uploads/suratmasuk/' . $surat['file_surat'])) {
                unlink('uploads/suratmasuk/' . $surat['file_surat']);
            }

            $this->suratMasuk->delete($id);
            return redirect()->to('suratmasuk')->with('success', 'Data berhasil dihapus.');
        }

        return redirect()->to('suratmasuk')->with('error', 'Data tidak ditemukan.');
    }

    // public function cleanup()
    // {
    //     $files = scandir('uploads/');
    //     $dataFileSurat = array_column($this->suratMasuk->findAll(), 'file_surat');

    //     foreach ($files as $file) {
    //         if ($file === '.' || $file === '..') continue;
    //         if (!in_array($file, $dataFileSurat)) {
    //             unlink('uploads/' . $file);
    //         }
    //     }

    //     return redirect()->to('suratmasuk')->with('success', 'File tak terpakai berhasil dibersihkan.');
    // }
}