<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Registrasi Global Security Filters
 */
class Filters extends BaseConfig
{
    public $aliases = [
        'csrf'      => \CodeIgniter\Filters\CSRF::class,
        'toolbar'   => \CodeIgniter\Filters\DebugToolbar::class,
        'honeypot'  => \CodeIgniter\Filters\Honeypot::class,
        'role'      => \App\Filters\RoleFilter::class,
        'rateLimit' => \App\Filters\RateLimitFilter::class,
    ];

    public $globals = [
        'before' => [
            // MENGAKTIFKAN PERLINDUNGAN CSRF SECARA GLOBAL PADA SEMUA METODE (POST/PUT/DELETE)
            // (Mencegah serangan pemalsuan request lintas situs)
            'csrf' => ['except' => ['api/*']], // Kecualikan API jika API menggunakan JWT/Bearer Token
        ],
        'after'  => [
            'toolbar' => ['except' => ['api/*']],
        ],
    ];

    public $methods = [];

    public $filters = [
        // Menerapkan Rate Limiting secara spesifik pada halaman otentikasi (Cegah Brute Force)
        'rateLimit' => ['before' => ['login', 'auth/loginProcess']],
        
        // Contoh penerapan pemblokiran level Middleware berbasis RBAC:
        // 'role:admin' => ['before' => ['master-data/*', 'users/*']],
        // 'role:keuangan,admin' => ['before' => ['donasi/*', 'laporan-keuangan/*']]
    ];
}
