<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Configures aliases for Filter classes to
     * make reading things nicer and simpler.
     */
    public array $aliases = [
        'csrf'          => CSRF::class,
        'toolbar'       => DebugToolbar::class,
        'honeypot'      => Honeypot::class,
        'invalidchars'  => InvalidChars::class,
        'secureheaders' => SecureHeaders::class,
        'filteradmin' => \App\Filters\FilterAdmin::class,
        'filtermanajer' => \App\Filters\FilterManajer::class,
        'filterperencana' => \App\Filters\FilterPerencana::class,
        'filtergudang' => \App\Filters\FilterGudang::class,
    ];

    /**
     * List of filter aliases that are always
     * applied before and after every request.
     */
    public array $globals = [
        'before' => [
            'filteradmin' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                ]
            ],
            'filtermanajer' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                ]
            ],
            'filterperencana' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                ]
            ],
            'filtergudang' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                ]
            ]
        ],
        'after' => [
            'toolbar',
            'filteradmin' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Produksi', 'Produksi/*',
                    'Produk', 'Produk/*',
                    'Struktur', 'Struktur/*',
                    'Material', 'Material/*',
                    'Pembelian', 'Pembelian/*',
                    'Supplier', 'Supplier/*',
                    'User', 'User/*',
                    'Bom', 'Bom/*',
                ]
            ],
            'filtermanajer' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Manajer', 'Manajer/*',
                    'Bom', 'Bom/*',
                    'Material', 'Material/*',
                ]
            ],
            'filterperencana' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Perencana', 'Perencana/*',
                    'Bom', 'Bom/*',
                    'Material', 'Material/*',
                    'Produksi', 'Produksi/*',
                ]
            ],
            'filtergudang' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Gudang', 'Gudang/*',
                    'Material', 'Material/*',
                ]
            ],
        ],
    ];

    /**
     * List of filter aliases that works on a
     * particular HTTP method (GET, POST, etc.).
     *
     * Example:
     * 'post' => ['foo', 'bar']
     *
     * If you use this, you should disable auto-routing because auto-routing
     * permits any HTTP method to access a controller. Accessing the controller
     * with a method you don’t expect could bypass the filter.
     */
    public array $methods = [];

    /**
     * List of filter aliases that should run on any
     * before or after URI patterns.
     *
     * Example:
     * 'isLoggedIn' => ['before' => ['account/*', 'profiles/*']]
     */
    public array $filters = [];
}
