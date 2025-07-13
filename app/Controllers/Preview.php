<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Preview extends Controller
{
    public function file($filename)
    {
        // Cek di suratmasuk dulu
        $filepathMasuk = FCPATH . 'uploads/suratmasuk/' . $filename;
        $filepathKeluar = FCPATH . 'uploads/suratkeluar/' . $filename;
        if (file_exists($filepathMasuk)) {
            $filepath = $filepathMasuk;
        } elseif (file_exists($filepathKeluar)) {
            $filepath = $filepathKeluar;
        } else {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('File tidak ditemukan');
        }
        $mime = mime_content_type($filepath);
        $response = service('response');
        return $response
            ->setHeader('Content-Type', $mime)
            ->setHeader('Content-Disposition', 'inline; filename="'.$filename.'"')
            ->setBody(file_get_contents($filepath));
    }
}