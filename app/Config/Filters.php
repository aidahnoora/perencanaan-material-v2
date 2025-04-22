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
        'filterppc' => \App\Filters\FilterPPC::class,
        'filtergudang' => \App\Filters\FilterGudang::class,
        'filtercs' => \App\Filters\FilterCS::class,
        'filterspv' => \App\Filters\FilterSPV::class,
        'filterqc' => \App\Filters\FilterQC::class,
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
            'filterppc' => [
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
                    'ProcessStep', 'ProcessStep/*',
                    'Supplier', 'Supplier/*',
                    'User', 'User/*',
                    'Bom', 'Bom/*',
                    'Order', 'Order/*',
                    'Eksekusi', 'Eksekusi/*',
                    'Approval', 'Approval/*',
                    'Laporan', 'Laporan/*',
                ]
            ],
            'filtermanajer' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Laporan', 'Laporan/*',
                ]
            ],
            'filtercs' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Produksi', 'Produksi/*',
                    'Order', 'Order/*',
                ]
            ],
            'filtergudang' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Laporan', 'Laporan/*',
                ]
            ],
            'filterppc' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Bom', 'Bom/*',
                    'Order', 'Order/*',
                ]
            ],
            'filterspv' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Order', 'Order/*',
                    'Eksekusi', 'Eksekusi/*',
                ]
            ],
            'filterqc' => [
                'except' => [
                    'Home', 'Home/*',
                    '/',
                    'Admin', 'Admin/*',
                    'Approval', 'Approval/*',
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
