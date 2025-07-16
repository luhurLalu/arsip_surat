<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * Helpers to be loaded automatically.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Initialize controller and apply global login protection.
     *
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Cek login kecuali di halaman yang diizinkan
        // Proteksi login dipindahkan ke filter Auth

        // Jika perlu akses session lewat $this->session
        // $this->session = \Config\Services::session();
    }

    /**
     * Cek role pengguna dan batasi akses ke halaman tertentu.
     *
     * @param array $allowedRoles
     * @return void
     */
    protected function checkRole(array $allowedRoles = [])
    {
        $userRole = session()->get('role');
        if (!in_array($userRole, $allowedRoles)) {
            return redirect()->to('/')->with('error', 'Akses ditolak');
        }
    }
}