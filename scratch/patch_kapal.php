<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    echo "Checking columns of table 'kapal'...\n";
    $columns = DB::select("SHOW COLUMNS FROM kapal");
    $columnNames = array_map(function($col) {
        return $col->Field;
    }, $columns);

    if (!in_array('stok_bbm', $columnNames)) {
        echo "Adding 'stok_bbm' column to 'kapal' table...\n";
        DB::statement("ALTER TABLE kapal ADD COLUMN stok_bbm INT DEFAULT 0");
    } else {
        echo "'stok_bbm' column already exists.\n";
    }

    if (!in_array('status', $columnNames)) {
        echo "Adding 'status' column to 'kapal' table...\n";
        DB::statement("ALTER TABLE kapal ADD COLUMN status VARCHAR(50) DEFAULT 'Aktif'");
    } else {
        echo "'status' column already exists.\n";
    }

    echo "Kapal table patched successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
