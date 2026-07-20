<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// 1. Rute Otentikasi
$routes->get('login', 'AuthController::index');
$routes->post('login-process', 'AuthController::login');
$routes->get('logout', 'AuthController::logout');

// 2. Redirect Halaman Utama ke Dashboard (atau Login jika belum sesi)
$routes->get('/', 'DashboardController::index');

// 3. Rute Dashboard & Modul Inti (Dilindungi RBAC/Filter jika dikonfigurasi)
$routes->get('dashboard', 'DashboardController::index');

// Profil
$routes->get('profile', 'ProfileController::index');
$routes->post('profile/update', 'ProfileController::update');

// 4. Modul Santri (CRUD)
$routes->get('santri', 'SantriController::index');
$routes->get('santri/create', 'SantriController::create');
$routes->post('santri/store', 'SantriController::store');
$routes->get('santri/edit/(:num)', 'SantriController::edit/$1');
$routes->post('santri/update/(:num)', 'SantriController::update/$1');
$routes->get('santri/delete/(:num)', 'SantriController::delete/$1');

// 5. Modul Mutabaah Hafalan
$routes->get('mutabaah', 'MutabaahController::index');
$routes->get('mutabaah/create', 'MutabaahController::create');
$routes->post('mutabaah/store', 'MutabaahController::store');
$routes->get('mutabaah/delete/(:num)', 'MutabaahController::delete/$1');

// 6. Modul Kas & Keuangan (Dashboard Keuangan + CRUD)
$routes->get('keuangan', 'KeuanganController::index');
$routes->get('keuangan/donasi/create', 'DonasiController::create'); // form donasi/kas masuk
$routes->get('keuangan/pengeluaran/create', 'KeuanganController::createPengeluaran');
$routes->post('keuangan/pengeluaran/store', 'KeuanganController::storePengeluaran');

// 7. Endpoint Khusus API/Webhook
$routes->post('donasi/store', 'DonasiController::store');
$routes->post('donasi/midtransWebhook', 'DonasiController::midtransWebhook');
$routes->get('donasi/getSantriByNis', 'DonasiController::getSantriByNis');

