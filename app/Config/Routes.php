<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index' , ['filter' => 'auth']);

$routes->get('login', 'AuthController::login', ['filter' => 'redirect']);
$routes->post('login', 'AuthController::login', ['filter' => 'redirect']);
$routes->get('logout', 'AuthController::logout');

$routes->group('produk', ['filter' => 'auth'], function ($routes) { 
    $routes->get('', 'ProdukController::index');
    $routes->post('', 'ProdukController::create');
    $routes->post('edit/(:any)', 'ProdukController::edit/$1');
    $routes->get('delete/(:any)', 'ProdukController::delete/$1');
    $routes->get('download', 'ProdukController::download');
});

$routes->group('kategori', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'KategoriProdukController::index');
    $routes->post('', 'KategoriProdukController::create');
    $routes->post('create', 'KategoriProdukController::create');
    $routes->post('update/(:any)', 'KategoriProdukController::update/$1');
    $routes->post('edit/(:any)', 'KategoriProdukController::edit/$1');
    $routes->get('delete/(:any)', 'KategoriProdukController::delete/$1');
});

$routes->group('keranjang', ['filter' => 'auth'], function ($routes) {
    $routes->get('', 'TransaksiController::index');
    $routes->post('', 'TransaksiController::cart_add');
    $routes->post('edit', 'TransaksiController::cart_edit');
    $routes->get('delete/(:any)', 'TransaksiController::cart_delete/$1');
    $routes->get('clear', 'TransaksiController::cart_clear');
});

$routes->group('diskon', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'DiskonController::index');
    $routes->get('create', 'DiskonController::create');
    $routes->post('store', 'DiskonController::store');
    $routes->get('edit/(:num)', 'DiskonController::edit/$1');
    $routes->post('update/(:num)', 'DiskonController::update/$1');
    $routes->get('delete/(:num)', 'DiskonController::delete/$1');
    $routes->post('delete/(:num)', 'DiskonController::delete/$1');
});

$routes->group('pembelian', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'PembelianController::index');
    $routes->get('ubah_status/(:num)', 'PembelianController::ubahStatus/$1');
    $routes->get('detail/(:num)', 'PembelianController::detail/$1');
});

$routes->get('checkout', 'TransaksiController::checkout', ['filter' => 'auth']);
$routes->post('buy', 'TransaksiController::buy', ['filter' => 'auth']);

$routes->get('get-location', 'TransaksiController::getLocation', ['filter' => 'auth']);
$routes->get('get-cost', 'TransaksiController::getCost', ['filter' => 'auth']);

$routes->get('faq', 'FAQController::index', ['filter' => 'auth']);
$routes->get('profile', 'Home::profile', ['filter' => 'auth']);
$routes->get('contact', 'ContactController::index', ['filter' => 'auth']);

$routes->resource('api', ['controller' => 'apiController']);
