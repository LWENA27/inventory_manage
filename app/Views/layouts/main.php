<!DOCTYPE html>
<html lang="<?= service('request')->getLocale() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?> - LineShop Africa</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <style>
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 5px;
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, 0.1);
        }
        .sidebar .nav-link i {
            margin-right: 10px;
        }
        .content {
            padding: 20px;
        }
        .navbar-brand img {
            height: 30px;
        }
        @media (max-width: 768px) {
            .sidebar {
                min-height: auto;
            }
        }
    </style>
    
    <?= $this->renderSection('styles') ?>
</head>
<body>
    <!-- Top Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="<?= site_url('dashboard') ?>">
                <i class="fas fa-store me-2"></i> LineShop Africa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-globe me-1"></i> <?= service('request')->getLocale() === 'sw' ? 'Swahili' : 'English' ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('language/en') ?>">English</a></li>
                            <li><a class="dropdown-item" href="<?= site_url('language/sw') ?>">Swahili</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i> <?= session('name') ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?= site_url('profile') ?>"><i class="fas fa-user me-2"></i> <?= lang('App.profile') ?></a></li>
                            <li><a class="dropdown-item" href="<?= site_url('settings') ?>"><i class="fas fa-cog me-2"></i> <?= lang('App.settings') ?></a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="<?= site_url('logout') ?>"><i class="fas fa-sign-out-alt me-2"></i> <?= lang('App.logout') ?></a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar (desktop) -->
            <div class="col-md-3 col-lg-2 d-none d-md-block sidebar collapse show" id="sidebarMenu">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
            <!-- Sidebar Drawer (mobile) -->
            <div id="mobileSidebarDrawer" class="d-md-none" style="position:fixed;top:0;left:0;width:80vw;max-width:320px;height:100vh;z-index:1050;background:#343a40;box-shadow:2px 0 8px rgba(0,0,0,0.15);transform:translateX(-100%);transition:transform 0.3s;overflow-y:auto;">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column p-3">
                        <li class="nav-item mb-3 text-end">
                            <button onclick="closeMobileSidebar()" class="btn btn-sm btn-light"><i class="fas fa-times"></i></button>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('dashboard') ?>"><i class="fas fa-tachometer-alt"></i> <?= lang('App.dashboard') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('pos') ?>"><i class="fas fa-cash-register"></i> <?= lang('App.pos') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('products') ?>"><i class="fas fa-box"></i> <?= lang('App.products') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('inventory') ?>"><i class="fas fa-warehouse"></i> <?= lang('App.inventory') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('invoices') ?>"><i class="fas fa-file-invoice"></i> <?= lang('App.invoices') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('purchases') ?>"><i class="fas fa-shopping-cart"></i> <?= lang('App.purchases') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('settings') ?>"><i class="fas fa-cog"></i> <?= lang('App.settings') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('transfers') ?>"><i class="fas fa-exchange-alt"></i> <?= lang('App.transfers') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('reports') ?>"><i class="fas fa-chart-bar"></i> <?= lang('App.reports') ?></a>
                        </li>
                        <?php if (session('role') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('users') ?>"><i class="fas fa-users"></i> <?= lang('App.users') ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="<?= site_url('settings') ?>"><i class="fas fa-cog"></i> <?= lang('App.settings') ?></a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Floating Sidebar Button (mobile only) -->
            <button id="openSidebarBtn" class="btn btn-primary rounded-circle shadow d-md-none" style="position:fixed;top:18px;left:18px;z-index:2000;width:48px;height:48px;display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-bars"></i>
            </button>
                        <li class="nav-item">
                            <a class="nav-link <?= uri_string() === 'dashboard' ? 'active' : '' ?>" href="<?= site_url('dashboard') ?>">
                                <i class="fas fa-tachometer-alt"></i> <?= lang('App.dashboard') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'pos') === 0 ? 'active' : '' ?>" href="<?= site_url('pos') ?>">
                                <i class="fas fa-cash-register"></i> <?= lang('App.pos') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'products') === 0 ? 'active' : '' ?>" href="<?= site_url('products') ?>">
                                <i class="fas fa-box"></i> <?= lang('App.products') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'inventory') === 0 ? 'active' : '' ?>" href="<?= site_url('inventory') ?>">
                                <i class="fas fa-warehouse"></i> <?= lang('App.inventory') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'invoices') === 0 ? 'active' : '' ?>" href="<?= site_url('invoices') ?>">
                                <i class="fas fa-file-invoice"></i> <?= lang('App.invoices') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'purchases') === 0 ? 'active' : '' ?>" href="<?= site_url('purchases') ?>">
                                <i class="fas fa-shopping-cart"></i> <?= lang('App.purchases') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'settings') === 0 ? 'active' : '' ?>" href="<?= site_url('settings') ?>">
                                <i class="fas fa-cog"></i> <?= lang('App.settings') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'transfers') === 0 ? 'active' : '' ?>" href="<?= site_url('transfers') ?>">
                                <i class="fas fa-exchange-alt"></i> <?= lang('App.transfers') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'reports') === 0 ? 'active' : '' ?>" href="<?= site_url('reports') ?>">
                                <i class="fas fa-chart-bar"></i> <?= lang('App.reports') ?>
                            </a>
                        </li>
                        <?php if (session('role') === 'admin'): ?>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'users') === 0 ? 'active' : '' ?>" href="<?= site_url('users') ?>">
                                <i class="fas fa-users"></i> <?= lang('App.users') ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= strpos(uri_string(), 'settings') === 0 ? 'active' : '' ?>" href="<?= site_url('settings') ?>">
                                <i class="fas fa-cog"></i> <?= lang('App.settings') ?>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <?= session()->getFlashdata('success') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show mt-3" role="alert">
                        <?= session()->getFlashdata('error') ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center text-lg-start mt-4">
        <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
            © <?= date('Y') ?> LineShop Africa - 
            <a href="<?= site_url('terms') ?>"><?= lang('App.terms') ?></a> | 
            <a href="<?= site_url('privacy') ?>"><?= lang('App.privacy') ?></a>
        </div>
    </footer>

    <script>
    // Mobile sidebar drawer logic
    (function() {
        const openSidebarBtn = document.getElementById('openSidebarBtn');
        const mobileSidebarDrawer = document.getElementById('mobileSidebarDrawer');
        let sidebarOpen = false;
        function openMobileSidebar() {
            mobileSidebarDrawer.style.transform = 'translateX(0)';
            mobileSidebarDrawer.style.boxShadow = '2px 0 8px rgba(0,0,0,0.15)';
            document.body.style.overflow = 'hidden';
            sidebarOpen = true;
        }
        function closeMobileSidebar() {
            mobileSidebarDrawer.style.transform = 'translateX(-100%)';
            document.body.style.overflow = '';
            sidebarOpen = false;
        }
        if (openSidebarBtn) {
            openSidebarBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                openMobileSidebar();
            });
        }
        // Close sidebar on outside click
        document.addEventListener('click', function(e) {
            if (sidebarOpen && mobileSidebarDrawer && !mobileSidebarDrawer.contains(e.target) && !openSidebarBtn.contains(e.target)) {
                closeMobileSidebar();
            }
        });
        // Prevent closing when clicking inside drawer
        if (mobileSidebarDrawer) {
            mobileSidebarDrawer.addEventListener('click', function(e) { e.stopPropagation(); });
        }
        // Expose closeMobileSidebar globally for close button
        window.closeMobileSidebar = closeMobileSidebar;
    })();
    </script>
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (for some plugins) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>