<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/artikel', 'Artikel::index');
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');
$routes->get('/tos', 'Page::tos');

// TAMBAHKAN RUTE INI UNTUK TUGAS 4 (Posisinya WAJIB di atas view artikel)
$routes->get('/artikel/kategori/(:any)', 'Artikel::kategori/$1');

// Rute ini tetap di bawahnya
$routes->get('/artikel/(:any)', 'Artikel::view/$1');

/* LOGIN */
$routes->get('/user/login', 'User::login');
$routes->post('/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

/* AJAX ROUTES */
$routes->get('ajax', 'AjaxController::index');
$routes->get('ajax/getData', 'AjaxController::getData');
$routes->get('ajax/getById/(:num)', 'AjaxController::getById/$1');
$routes->post('ajax/save', 'AjaxController::save');
$routes->post('ajax/update/(:num)', 'AjaxController::update/$1');
$routes->delete('ajax/delete/(:num)', 'AjaxController::delete/$1');

/* ADMIN (PAKAI FILTER AUTH) */
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'Artikel::dashboard');
    $routes->get('artikel', 'Artikel::admin_index');
    $routes->add('artikel/add', 'Artikel::add');
    $routes->add('artikel/edit/(:any)', 'Artikel::edit/$1');
    $routes->get('artikel/delete/(:any)', 'Artikel::delete/$1');
});

/* REST API ROUTES (Praktek 10 & 14) */
// MATIKAN fungsi resource agar tidak membocorkan akses tanpa filter
// $routes->resource('post'); 

// 1. Rute Publik API (Bisa diakses tanpa token untuk membaca tabel artikel VueJS)
$routes->get('post', 'Post::index');
$routes->get('post/new', 'Post::new');
$routes->get('post/(:segment)/edit', 'Post::edit/$1');
$routes->get('post/(:segment)', 'Post::show/$1');

// 2. Rute Terproteksi API (WAJIB menggunakan token karena ada filter 'apiauth')
$routes->post('post', 'Post::create', ['filter' => 'apiauth']);
$routes->put('post/(:segment)', 'Post::update/$1', ['filter' => 'apiauth']);
$routes->patch('post/(:segment)', 'Post::update/$1', ['filter' => 'apiauth']);
$routes->delete('post/(:segment)', 'Post::delete/$1', ['filter' => 'apiauth']);


/* AUTHENTICATION API REST (Praktek 13) */
$routes->post('api/login', 'Api\Auth::login');