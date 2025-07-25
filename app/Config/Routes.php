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

    // Dashboard & Trial
    $routes->GET('dashboard', 'Dashboard::index');
    // Profile
    $routes->GET('profile', 'Profile::index');
    $routes->GET('trial-status', 'Trial::status');

    // Products
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

    // Inventory
    $routes->GET('inventory', 'Inventory::index');
    $routes->GET('inventory/adjust/(:num)', 'Inventory::adjust/$1');
    $routes->POST('inventory/adjust/(:num)', 'Inventory::processAdjustment/$1');
    $routes->GET('inventory/history', 'Inventory::history');
    $routes->GET('inventory/history/(:num)', 'Inventory::history/$1');
    $routes->GET('inventory/valuation', 'Inventory::valuation');
    $routes->GET('inventory/warehouse', 'Inventory::byWarehouse');
    $routes->GET('inventory/warehouse/(:num)', 'Inventory::byWarehouse/$1');
    $routes->GET('inventory/batches', 'Inventory::batches');

    // Invoices & Purchases
    $routes->GET('invoices', 'Invoices::index');
    $routes->GET('invoices/create', 'Invoices::create');
    $routes->POST('invoices', 'Invoices::store');
    $routes->GET('invoices/(:num)', 'Invoices::show/$1');
    $routes->GET('invoices/(:num)/edit', 'Invoices::edit/$1');
    $routes->POST('invoices/(:num)', 'Invoices::update/$1');
    $routes->GET('invoices/(:num)/delete', 'Invoices::delete/$1');
    $routes->GET('invoices/(:num)/print', 'Invoices::print/$1');
    $routes->GET('purchases', 'Purchases::index');
    $routes->GET('purchases/create', 'Purchases::create');

    // Transfers
    $routes->GET('transfers', 'Transfers::index');
    $routes->GET('transfers/create', 'Transfers::create');

    // Reports
    $routes->GET('reports', 'Reports::index');
    $routes->GET('reports/sales', 'Reports::sales');
    $routes->GET('reports/purchases', 'Reports::purchases');
    $routes->GET('reports/inventory', 'Reports::inventory');
    $routes->GET('reports/profit', 'Reports::profit');
    $routes->GET('reports/taxes', 'Reports::taxes');
    $routes->GET('reports/customers', 'Reports::customers');
    $routes->GET('reports/suppliers', 'Reports::suppliers');

    // Settings
    $routes->GET('settings', 'Settings::index');
    $routes->POST('settings/update', 'Settings::update');
    $routes->GET('settings/manage_category', 'Settings::manageCategory');
    $routes->POST('settings/category/add', 'Settings::addCategory');
    $routes->GET('settings/category/edit/(:num)', 'Settings::editCategory/$1');
    $routes->GET('settings/category/delete/(:num)', 'Settings::deleteCategory/$1');

    // POS
    $routes->GET('pos', 'Pos::index');
    $routes->POST('pos/add', 'Pos::add');
    $routes->post('pos/checkout', 'Pos::checkout');

});
