<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\Http;

$url = env('URL_API') . '/usuarios';

echo "Fetching: $url\n";

$t0 = microtime(true);
try {
    // Mismo llamado que el controlador, pero con timeout explícito para no colgar
    $response = Http::timeout(30)->get($url);
    $elapsed = microtime(true) - $t0;
    $body = $response->json();
    echo "STATUS: " . $response->status() . "\n";
    echo "TIEMPO: " . round($elapsed, 2) . "s\n";
    echo "REGISTROS: " . (is_countable($body) ? count($body) : 'n/a') . "\n";
    if (is_array($body) && isset($body[0])) {
        echo "PRIMERO: " . json_encode($body[0], JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (\Throwable $e) {
    echo "ERROR tras " . round(microtime(true) - $t0, 2) . "s: " . $e->getMessage() . "\n";
}
