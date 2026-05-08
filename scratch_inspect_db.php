<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    $results = DB::select('DESCRIBE test');
    foreach ($results as $row) {
        echo "{$row->Field} | {$row->Type} | {$row->Null} | {$row->Key} | {$row->Default}\n";
    }
} catch (\Exception $e) {
    echo 'Error: '.$e->getMessage();
}
