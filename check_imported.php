<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Legacy requests count: " . \App\Models\LegacyPickupRequest::count() . "\n";
foreach (\App\Models\LegacyPickupRequest::selectRaw('status, count(*) as c')->groupBy('status')->get() as $s) {
    echo "Legacy Status: '{$s->status}' -> {$s->c}\n";
}

echo "\nUnified requests with source='imported': " . \App\Models\Request::where('source', 'imported')->count() . "\n";
foreach (\App\Models\Request::where('source', 'imported')->get() as $r) {
    echo "ID: {$r->id}, ReqNum: {$r->request_number}, Status: {$r->status}, remarks: {$r->remarks}\n";
}
