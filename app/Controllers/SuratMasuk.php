<?php

namespace App\Controllers;

use App\Models\SuratMasukModel;

class SuratMasuk extends BaseController
{
    protected $suratMasuk;

    // Hapus banyak data sekaligus
    public function bulkdelete()
    {
        $ids = $this->request->getPost('ids');
        if (!$ids || !is_array($ids)) {
            return redirect()->to('suratmasuk')->with('error', 'Tidak ada data yang dipilih.');
        }
        $deleted = 0;
        foreach ($ids as $id) {
            $surat = $this->suratMasuk->find($id);
            if ($surat) {
                if (!empty($surat['file_surat']) && file_exists('uploads/suratmasuk/' . $surat['file_surat'])) {
                    unlink('uploads/suratmasuk/' . $surat['file_surat']);
                }
                $this->suratMasuk->delete($id);
                $deleted++;
            }
        }
        return redirect()->to('suratmasuk')->with('success', $deleted . ' surat berhasil dihapus.');
    }



    public function __construct()
    {
        $this->suratMasuk = new SuratMasukModel();
    }



    public function create()
    {
        return view('suratmasuk/create');
    }
    public function store()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'nomor_surat'     => 'required',
            'pengirim'        => 'required',
            'tanggal_terima'  => 'required|valid_date',
            'perihal'         => 'required',
            'file_surat'      => 'uploaded[file_surat]|mime_in[file_surat,application/pdf,image/jpeg,image/png]|max_size[file_surat,2048]'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        // Validasi nomor surat unik
        $nomorSurat = $this->request->getPost('nomor_surat');
        $existing = $this->suratMasuk->where('nomor_surat', $nomorSurat)->first();
        if ($existing) {
            return redirect()->back()->withInput()->with('error', 'Nomor surat sudah ada di database, silakan gunakan nomor lain.');
        }

        $file = $this->request->getFile('file_surat');
        $fileName = $file->getRandomName();
        $file->move('uploads/suratmasuk', $fileName);

        $tujuanSurat = $this->request->getPost('tujuan_surat');
        if ($tujuanSurat === 'Lainnya') {
            $tujuanSurat = $this->request->getPost('tujuan_surat_lainnya');
        }

        $this->suratMasuk->save([
            'nomor_surat'    => $nomorSurat,
            'pengirim'       => $this->request->getPost('pengirim'),
            'tujuan_surat'   => $tujuanSurat,
            'tanggal_terima' => $this->request->getPost('tanggal_terima'),
            'perihal'        => $this->request->getPost('perihal'),
            'file_surat'     => $fileName
        ]);

        return redirect()->to('suratmasuk')->with('success', 'Data berhasil disimpan.');
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

        // Ambil tujuan_surat dari dropdown, jika Lainnya ambil dari input manual
        $tujuanSurat = $this->request->getPost('tujuan_surat');
        if ($tujuanSurat === 'Lainnya') {
            $tujuanSurat = $this->request->getPost('tujuan_surat_lainnya');
        }
        $data = [
            'nomor_surat'    => $this->request->getPost('nomor_surat'),
            'pengirim'       => $this->request->getPost('pengirim'),
            'tujuan_surat'   => $tujuanSurat,
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

    public function cleanup()
    {
        $files = scandir('uploads/suratmasuk/');
        $dataFileSurat = array_column($this->suratMasuk->findAll(), 'file_surat');

        foreach ($files as $file) {
            if ($file === '.' || $file === '..') continue;
            if (!in_array($file, $dataFileSurat)) {
                unlink('uploads/suratmasuk/' . $file);
            }
        }

        return redirect()->to('suratmasuk')->with('success', 'File tak terpakai berhasil dibersihkan.');
    }
}