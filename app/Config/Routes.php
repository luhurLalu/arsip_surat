<?php
// Tambahkan route login agar tidak 404
$routes->get('login', 'Auth::login');

use CodeIgniter\Router\RouteCollection;

/** 
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');
//📤 Routes untuk Surat Keluar
$routes->get('surat-masuk', 'SuratMasuk::index');
$routes->get('suratmasuk', 'SuratMasuk::index');
$routes->get('suratmasuk/create', 'SuratMasuk::create');
$routes->post('suratmasuk/store', 'SuratMasuk::store');
$routes->get('suratmasuk/detail/(:num)', 'SuratMasuk::detail/$1');
$routes->get('suratmasuk/edit/(:num)', 'SuratMasuk::edit/$1');
$routes->post('suratmasuk/update/(:num)', 'SuratMasuk::update/$1');
$routes->post('suratmasuk/delete/(:num)', 'SuratMasuk::delete/$1');
$routes->post('suratmasuk/bulkdelete', 'SuratMasuk::bulkdelete');
$routes->get('suratmasuk/cleanup', 'SuratMasuk::cleanup');
$routes->get('preview/(:segment)', 'Preview::file/$1');
// 📤 Routes untuk Surat Keluar
$routes->get('suratkeluar',              'SuratKeluar::index');
$routes->get('suratkeluar/create',       'SuratKeluar::create');
$routes->post('suratkeluar/store',       'SuratKeluar::store');
$routes->get('suratkeluar/detail/(:num)','SuratKeluar::detail/$1');
$routes->get('suratkeluar/edit/(:num)',  'SuratKeluar::edit/$1');
$routes->post('suratkeluar/update/(:num)','SuratKeluar::update/$1');
$routes->post('suratkeluar/delete/(:num)','SuratKeluar::delete/$1');
$routes->post('suratkeluar/bulkdelete', 'SuratKeluar::bulkdelete');
$routes->get('suratkeluar/cleanup', 'SuratKeluar::cleanup');
$routes->get('surattugas',              'SuratTugas::index');
$routes->get('surattugas/create',       'SuratTugas::create');
$routes->post('surattugas/store',       'SuratTugas::store');
$routes->get('surattugas/detail/(:num)','SuratTugas::detail/$1');
$routes->get('surattugas/edit/(:num)',  'SuratTugas::edit/$1');
$routes->post('surattugas/update/(:num)','SuratTugas::update/$1');
$routes->post('surattugas/delete/(:num)','SuratTugas::delete/$1');
$routes->post('surattugas/bulkdelete', 'SuratTugas::bulkdelete');
$routes->get('surattugas/cleanup', 'SuratTugas::cleanup');
// Routes untuk User
$routes->get('user/edit/(:num)', 'User::edit/$1');
// Routes untuk mengupdate user
$routes->post('user/update/(:num)', 'User::update/$1');
$routes->get('user/delete/(:num)', 'User::delete/$1');
// Routes untuk Auth
$routes->get('auth/login', 'Auth::login');
$routes->post('auth/processLogin', 'Auth::processLogin');
$routes->get('auth/logout', 'Auth::logout');