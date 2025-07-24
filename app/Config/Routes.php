<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false); // ❗ Set to false in production for security

// Public Routes

$routes->GET('/', 'Home::index');
$routes->match(['GET', 'POST'], 'login', 'Auth::login');
$routes->match(['GET', 'POST'], 'register', 'Auth::register');
$routes->GET('logout', 'Auth::logout');
$routes->GET('language/(:segment)', 'Language::setLanguage/$1');

// Protected Routes (requires user to be logged in)
$routes->group('', ['filter' => 'authGuard'], function($routes) {

    $routes->GET('dashboard', 'Dashboard::index');
    $routes->GET('trial-status', 'Trial::status');

    // Products Routes
    $routes->GET('products', 'Products::index');
    $routes->GET('products/create', 'Products::create');
    $routes->POST('products', 'Products::store');
    $routes->GET('products/(:num)', 'Products::show/$1');
    $routes->GET('products/(:num)/edit', 'Products::edit/$1');
    $routes->POST('products/(:num)', 'Products::update/$1');
    $routes->GET('products/(:num)/delete', 'Products::delete/$1');
    $routes->GET('products/search', 'Products::search');
    $routes->GET('products/category', 'Products::filterByCategory');
    $routes->GET('products/low-stock', 'Products::lowStock');
    
    // Inventory Routes
    $routes->GET('inventory', 'Inventory::index');
    $routes->GET('inventory/adjust/(:num)', 'Inventory::adjust/$1');
    $routes->POST('inventory/adjust/(:num)', 'Inventory::processAdjustment/$1');
    $routes->GET('inventory/history', 'Inventory::history');
    $routes->GET('inventory/history/(:num)', 'Inventory::history/$1');
    $routes->GET('inventory/valuation', 'Inventory::valuation');
    $routes->GET('inventory/warehouse', 'Inventory::byWarehouse');
    $routes->GET('inventory/warehouse/(:num)', 'Inventory::byWarehouse/$1');
    $routes->GET('inventory/batches', 'Inventory::batches');

    // Settings Routes
    $routes->GET('settings', 'Settings::index');
    $routes->POST('settings/update', 'Settings::update');

    // POS Routes
    $routes->GET('pos', 'Pos::index');
    $routes->POST('pos/add', 'Pos::add');
    $routes->POST('pos/checkout', 'Pos::checkout');
});
