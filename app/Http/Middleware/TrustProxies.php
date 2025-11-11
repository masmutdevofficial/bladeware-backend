<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Middleware\TrustProxies as Middleware;

class TrustProxies extends Middleware
{
    /**
     * Daftar proxy tepercaya untuk aplikasi ini.
     *
     * Gunakan '*' jika aplikasi berada di belakang reverse proxy (Cloudflare/Traefik/Nginx Proxy)
     * dan Anda ingin mempercayai semua proxy di chain.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies = '*';

    /**
     * Header yang digunakan untuk mendeteksi informasi dari proxy.
     *
     * Pastikan reverse proxy mengirimkan X-Forwarded-Proto agar skema https terdeteksi.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO;
        // Jika menggunakan AWS ELB, tambahkan baris berikut:
        // | Request::HEADER_X_FORWARDED_AWS_ELB;
}
