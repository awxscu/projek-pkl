<?php
require __DIR__.'/../vendor/autoload.php';
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

try {
    echo "Creating 'perusahaan' table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS perusahaan (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kode_perusahaan VARCHAR(50) NOT NULL UNIQUE,
            nama_perusahaan VARCHAR(255) NOT NULL,
            status VARCHAR(50) DEFAULT 'Aktif',
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )
    ");
    
    echo "Creating 'ftit' table...\n";
    DB::statement("
        CREATE TABLE IF NOT EXISTS ftit (
            id INT AUTO_INCREMENT PRIMARY KEY,
            kode_ftit VARCHAR(50) NOT NULL UNIQUE,
            nama_ftit VARCHAR(255) NOT NULL,
            lokasi VARCHAR(255) NULL,
            status VARCHAR(50) DEFAULT 'Aktif',
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL
        )
    ");

    // Seed perusahaan
    $companies = [
        ['kode_perusahaan' => 'PT-01', 'nama_perusahaan' => 'PT Pelayaran Nasional Indonesia (PELNI)', 'status' => 'Aktif'],
        ['kode_perusahaan' => 'PT-02', 'nama_perusahaan' => 'PT Samudera Indonesia Tbk', 'status' => 'Aktif'],
        ['kode_perusahaan' => 'PT-03', 'nama_perusahaan' => 'PT Meratus Line', 'status' => 'Aktif'],
        ['kode_perusahaan' => 'PT-04', 'nama_perusahaan' => 'PT Dharma Lautan Utama', 'status' => 'Aktif'],
        ['kode_perusahaan' => 'PT-05', 'nama_perusahaan' => 'PT Temas Tbk', 'status' => 'Aktif'],
        ['kode_perusahaan' => 'PT-06', 'nama_perusahaan' => 'PT Spil', 'status' => 'Aktif'],
        ['kode_perusahaan' => 'PT-07', 'nama_perusahaan' => 'PT Salam Pacific Indonesia Lines (SPIL)', 'status' => 'Aktif'],
        ['kode_perusahaan' => 'PT-08', 'nama_perusahaan' => 'PT Pelayaran Rakyat', 'status' => 'Aktif'],
    ];

    foreach ($companies as $comp) {
        DB::table('perusahaan')->updateOrInsert(
            ['kode_perusahaan' => $comp['kode_perusahaan']],
            [
                'nama_perusahaan' => $comp['nama_perusahaan'],
                'status' => $comp['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
    echo "Seeded 'perusahaan' successfully.\n";

    // Seed ftit
    $depots = [
        ['kode_ftit' => 'FTIT-01', 'nama_ftit' => 'Depot Tanjung Perak', 'lokasi' => 'Surabaya', 'status' => 'Aktif'],
        ['kode_ftit' => 'FTIT-02', 'nama_ftit' => 'Depot Tanjung Priok', 'lokasi' => 'Jakarta', 'status' => 'Aktif'],
        ['kode_ftit' => 'FTIT-03', 'nama_ftit' => 'Depot Teluk Bayur', 'lokasi' => 'Padang', 'status' => 'Aktif'],
        ['kode_ftit' => 'FTIT-04', 'nama_ftit' => 'Depot Makassar', 'lokasi' => 'Makassar', 'status' => 'Aktif'],
        ['kode_ftit' => 'FTIT-05', 'nama_ftit' => 'Depot Balikpapan', 'lokasi' => 'Balikpapan', 'status' => 'Aktif'],
        ['kode_ftit' => 'FTIT-06', 'nama_ftit' => 'Depot Bitung', 'lokasi' => 'Bitung', 'status' => 'Aktif'],
        ['kode_ftit' => 'FTIT-07', 'nama_ftit' => 'Depot Ambon', 'lokasi' => 'Ambon', 'status' => 'Aktif'],
        ['kode_ftit' => 'FTIT-08', 'nama_ftit' => 'Depot Kupang', 'lokasi' => 'Kupang', 'status' => 'Aktif'],
    ];

    foreach ($depots as $dep) {
        DB::table('ftit')->updateOrInsert(
            ['kode_ftit' => $dep['kode_ftit']],
            [
                'nama_ftit' => $dep['nama_ftit'],
                'lokasi' => $dep['lokasi'],
                'status' => $dep['status'],
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
    }
    echo "Seeded 'ftit' successfully.\n";

    echo "Database setup completed successfully!\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
