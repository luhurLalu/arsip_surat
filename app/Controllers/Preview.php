<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class Preview extends Controller
{
    public function file($filename)
    {
        $filepath = WRITEPATH . '../public/uploads/' . $filename;

        if (!file_exists($filepath)) {
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