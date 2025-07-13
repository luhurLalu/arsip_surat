<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// $routes->get('/', 'Home::index');
$routes->get('/', 'Dashboard::index');
//📤 Routes untuk Surat Keluar
$routes->get('surat-masuk', 'SuratMasuk::index');
$routes->get('suratmasuk', 'SuratMasuk::index');
$routes->get('suratmasuk/create', 'SuratMasuk::create');
$routes->post('suratmasuk/store', 'SuratMasuk::store');
$routes->get('suratmasuk/detail/(:num)', 'SuratMasuk::detail/$1');
$routes->get('suratmasuk/edit/(:num)', 'SuratMasuk::edit/$1');
$routes->post('suratmasuk/update/(:num)', 'SuratMasuk::update/$1');
$routes->post('suratmasuk/delete/(:num)', 'SuratMasuk::delete/$1');
// $routes->get('suratmasuk/cleanup', 'SuratMasuk::cleanup');
$routes->get('preview/(:segment)', 'Preview::file/$1');
// 📤 Routes untuk Surat Keluar
$routes->get('suratkeluar',              'SuratKeluar::index');
$routes->get('suratkeluar/create',       'SuratKeluar::create');
$routes->post('suratkeluar/store',       'SuratKeluar::store');
$routes->get('suratkeluar/detail/(:num)','SuratKeluar::detail/$1');
$routes->get('suratkeluar/edit/(:num)',  'SuratKeluar::edit/$1');
$routes->post('suratkeluar/update/(:num)','SuratKeluar::update/$1');
$routes->post('suratkeluar/delete/(:num)','SuratKeluar::delete/$1');