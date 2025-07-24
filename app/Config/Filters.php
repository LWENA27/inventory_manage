<?php

namespace Config;

use CodeIgniter\Config\Filters as BaseFilters;
use CodeIgniter\Filters\Cors;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\ForceHTTPS;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\PageCache;
use CodeIgniter\Filters\PerformanceMetrics;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseFilters
{
    /**
     * Aliases for Filter classes for cleaner usage.
     *
     * @var array<string, class-string|list<class-string>>
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'cors'          => Cors::class,
        'forcehttps'    => ForceHTTPS::class,
        'pagecache'     => PageCache::class,
        'performance'   => PerformanceMetrics::class,

        // Custom filters (optional for auth)
        'auth'          => \App\Filters\AuthFilter::class,   // Add if you implement auth filter
        'guest'         => \App\Filters\GuestFilter::class,  // Add if you want guest-only pages
        'authGuard'     => \App\Filters\AuthGuard::class,    // AuthGuard filter for protected routes
    ];

    /**
     * Filters that are required by CodeIgniter, applied globally.
     *
     * @var array{before: list<string>, after: list<string>}
     */
    public array $required = [
        'before' => [
            // Optional: 'forcehttps', // Uncomment in production (HTTPS required)
            // Optional: 'pagecache',
        ],
        'after' => [
            'performance',
            'toolbar',
            // Optional: 'pagecache',
        ],
    ];

    /**
     * Filters to be applied before and after every request.
     *
     * @var array<string, list<string>>
     */
    public array $globals = [
        'before' => [
            'csrf' => ['except' => [
                'pos/checkout',
            ]],
            // 'honeypot',
            // 'invalidchars',
        ],
        'after' => [
            // 'honeypot',
            // 'secureheaders',
        ],
    ];

    /**
     * HTTP method-based filters (optional)
     *
     * @var array<string, list<string>>
     */
    public array $methods = [
        // 'post' => ['csrf'], // Already handled by globals
    ];

    /**
     * URI pattern-based filters (example usage shown)
     *
     * @var array<string, array<string, list<string>>>
     */
    public array $filters = [
        // Example of using custom 'auth' filter to protect dashboard
        // 'auth' => ['before' => ['dashboard', 'dashboard/*', 'logout']],
        // 'guest' => ['before' => ['login', 'register']],
    ];
}
