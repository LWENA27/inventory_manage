<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LineShop Africa - Inventory & POS System</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fc;
        }
        .hero {
            background: linear-gradient(135deg, #4e73df 0%, #224abe 100%);
            color: white;
            padding: 5rem 0;
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #4e73df;
            margin-bottom: 1rem;
        }
        .feature-card {
            border: none;
            border-radius: 0.5rem;
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
        .navbar {
            box-shadow: 0 0.15rem 1.75rem rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #2e59d9;
            border-color: #2e59d9;
        }
        .btn-success {
            background-color: #1cc88a;
            border-color: #1cc88a;
        }
        .btn-success:hover {
            background-color: #17a673;
            border-color: #17a673;
        }
        .language-selector {
            margin-left: 1rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">
            <a class="navbar-brand" href="<?= site_url() ?>">
                <i class="fas fa-store me-2 text-primary"></i>
                <span class="fw-bold">LineShop Africa</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#features">Features</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">Pricing</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe me-1"></i> <?= service('request')->getLocale() === 'sw' ? 'Swahili' : 'English' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('language/en') ?>">English</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('language/sw') ?>">Swahili</a></li>
                        </ul>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-primary" href="<?= site_url('login') ?>">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item ms-2">
                        <a class="btn btn-success" href="<?= site_url('register') ?>">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Inventory & POS System for East African Businesses</h1>
            <p class="lead mb-5">A complete solution for pharmacies, retail shops, and warehouses. Easy to use, no training required!</p>
            <div class="d-flex justify-content-center">
                <a href="<?= site_url('register') ?>" class="btn btn-success btn-lg me-3">
                    <i class="fas fa-rocket me-2"></i> Start Free Trial
                </a>
                <a href="#features" class="btn btn-outline-light btn-lg">
                    <i class="fas fa-info-circle me-2"></i> Learn More
                </a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5" id="features">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Key Features</h2>
                <p class="lead text-muted">Everything you need to run your business efficiently</p>
            </div>
            
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-cash-register"></i>
                            </div>
                            <h4>Point of Sale (POS)</h4>
                            <p class="text-muted">Fast and easy checkout process with barcode scanning, discounts, and multiple payment methods.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-boxes"></i>
                            </div>
                            <h4>Inventory Management</h4>
                            <p class="text-muted">Track stock levels, manage multiple warehouses, and get low stock alerts.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <h4>Reports & Analytics</h4>
                            <p class="text-muted">Get insights into sales, inventory, and profits with detailed reports and charts.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h4>User Management</h4>
                            <p class="text-muted">Create different user roles with specific permissions for better security and control.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-globe"></i>
                            </div>
                            <h4>Multilingual Support</h4>
                            <p class="text-muted">Use the system in English or Swahili, with easy language switching.</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-4">
                            <div class="feature-icon">
                                <i class="fas fa-mobile-alt"></i>
                            </div>
                            <h4>Mobile Friendly</h4>
                            <p class="text-muted">Access your system from any device - desktop, tablet, or smartphone.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section class="py-5 bg-light" id="pricing">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Affordable Pricing</h2>
                <p class="lead text-muted">Start with a 30-day free trial, no credit card required</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6">
                    <div class="card feature-card h-100">
                        <div class="card-body text-center p-5">
                            <h3 class="card-title">Standard Plan</h3>
                            <div class="display-4 my-4">$XX/mo</div>
                            <ul class="list-unstyled">
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i> All core features</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Unlimited products</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i> 5 user accounts</li>
                                <li class="mb-3"><i class="fas fa-check text-success me-2"></i> Email support</li>
                            </ul>
                            <a href="<?= site_url('register') ?>" class="btn btn-primary btn-lg d-block">Start Free Trial</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-5" id="contact">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Contact Us</h2>
                <p class="lead text-muted">Have questions? We're here to help!</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card feature-card">
                        <div class="card-body p-5">
                            <div class="row mb-4">
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="feature-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <h5>Email</h5>
                                    <p class="text-muted">info@lineshopafrica.com</p>
                                </div>
                                <div class="col-md-4 text-center mb-3 mb-md-0">
                                    <div class="feature-icon">
                                        <i class="fas fa-phone"></i>
                                    </div>
                                    <h5>Phone</h5>
                                    <p class="text-muted">+255 XXX XXX XXX</p>
                                </div>
                                <div class="col-md-4 text-center">
                                    <div class="feature-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <h5>Location</h5>
                                    <p class="text-muted">Dar es Salaam, Tanzania</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="fas fa-store me-2"></i> LineShop Africa</h5>
                    <p>Empowering East African businesses with simple, effective inventory and POS solutions.</p>
                </div>
                <div class="col-md-3">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#features" class="text-white">Features</a></li>
                        <li><a href="#pricing" class="text-white">Pricing</a></li>
                        <li><a href="#contact" class="text-white">Contact</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Legal</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-white">Terms of Service</a></li>
                        <li><a href="#" class="text-white">Privacy Policy</a></li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p>&copy; <?= date('Y') ?> LineShop Africa. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
