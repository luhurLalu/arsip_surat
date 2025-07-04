<?php

namespace App\Controllers;
use App\Models\SuratMasukModel;
use App\Models\SuratKeluarModel;

class Dashboard extends BaseController
{
    protected $masuk, $keluar;

    public function __construct()
    {
        $this->masuk  = new SuratMasukModel();
        $this->keluar = new SuratKeluarModel();
    }

    public function index()
    {
        $data = [
            'totalMasuk'    => $this->masuk->countAll(),
            'totalKeluar'   => $this->keluar->countAll(),
            'bulanMasuk'    => $this->groupPerMonth($this->masuk, 'tanggal_terima'),
            'bulanKeluar'   => $this->groupPerMonth($this->keluar, 'tanggal_kirim'),
        ];

        return view('dashboard/index', $data);
    }

    private function groupPerMonth($model, $dateField)
    {
        $builder = $model->builder();
        $builder->select("MONTH($dateField) AS bulan, COUNT(*) as total");
        $builder->groupBy("MONTH($dateField)");
        $query = $builder->get();

        $result = array_fill(1, 12, 0);
        foreach ($query->getResultArray() as $row) {
            $result[(int)$row['bulan']] = (int)$row['total'];
        }
        return $result;
    }
}