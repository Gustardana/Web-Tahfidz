<?php
namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Konfigurasi Global Penanganan Kesalahan (Global Exception Handler)
 */
class Exceptions extends BaseConfig
{
    // Catat seluruh error ke file server (system.log)
    public $log = true;

    // Hindari mencatat error 404 agar log tidak penuh dengan scan bots
    public $ignoreCodes = [404];

    // Direktori letak file view error kustom yang disamarkan (Menyembunyikan Stack Trace)
    public $errorViewPath = APPPATH . 'Views/errors';

    // Masking data sensitif pada file log (Mencegah password bocor di log server)
    public $sensitiveDataInTrace = ['password', 'pwd', 'token', 'api_key', 'server_key'];
}
