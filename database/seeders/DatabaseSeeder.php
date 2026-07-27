<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Perusahaan;
use App\Models\Ftit;
use App\Models\StatusPengisian;
use App\Models\Kapal;
use App\Models\Logbook;
use App\Models\DetailPemakaian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // ONLY clear perusahaan and ftit as requested
        Perusahaan::truncate();
        Ftit::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // 1. Seed Perusahaan (90 Real Records with formatted P001 - P090 keys)
        $companies = [
            [1, 'PT. AGUNG TAMA RAYA'],
            [2, 'PT. ASDP (PERSERO) C.KAYANGAN'],
            [3, 'PT. ASDP INDONESIA FERRY (PERSERO)'],
            [4, 'PT. ATOSIM LAMPUNG PELAYARAN'],
            [5, 'PT. BAHTERA SAMUDERA INDONESIA'],
            [6, 'PT. DHARMA LAUTAN UTAMA'],
            [7, 'PT. DUTA BAHARI MENARA LINE'],
            [8, 'PT. GARDA MARITIM NUSATAMA'],
            [9, 'PT. JEMBATAN NUSANTARA'],
            [10, 'PT. JEMLA FERRY'],
            [11, 'PT. MULTI GUNA MARITIM'],
            [12, 'PT. NUSA WANGI MANDIRI'],
            [13, 'PT. PELAYARAN SURYA TIMUR LINE'],
            [14, 'PT. PEWETE BAHTERA KENCANA'],
            [15, 'PT. PUTERA MASTER SARANA PENYEBERAN'],
            [16, 'PT. RAPUTRA JAYA'],
            [17, 'PT. TRI SAKTI LAUTAN MAS'],
            [18, 'PT. TRIMITRA SAMUDRA'],
            [19, 'PT. FLOBAMOR'],
            [20, 'PERUSAHAAN PELAYARAN RAKYAT'],
            [21, 'PT. ARMADA LAUTAN MULIA'],
            [22, 'PT. ASDP (PERSERO) CAB. SAPE'],
            [23, 'PT. BUKTI BANAWA BARU'],
            [24, 'PT. CITRA ENAM BERSAUDARA'],
            [25, 'PT. CITRA MAKMUR'],
            [26, 'PT. DUTA BAHTERA PERMAI'],
            [27, 'PT. DUTA RAMADHANI PERMAI'],
            [28, 'PT. FAJAR BHAKTI NEGERI'],
            [29, 'PT. KARUNIA UTAMA ASIA TIMUR'],
            [30, 'PT. MULIA LAUTAN MAKMUR'],
            [31, 'PT. PANTAI SAMUDRA SEJATI'],
            [32, 'PT. PELAYARAN NASIONAL INDONESIA'],
            [33, 'PT. PELRA TELUK BIMA'],
            [34, 'PT. SINAR SARITAMA MANDIRI'],
            [35, 'PT. TANJUNG BIMA SAMUDRA'],
            [36, 'PT. TUNAS SAMUDRA BIMA'],
            [37, 'PT. SELVI TRANS INDO'],
            [38, 'PT. SUBSEA LINTAS GLOBALINDO'],
            [39, 'PT. BERLIAN LAUTAN SEJAHTERA'],
            [40, 'PT. DHARMA LAUTAN UTAMA'],
            [41, 'PT. TIMUR MILA UTAMA'],
            [42, 'PT. ASDP (PERSERO) CAB.UTAMA KUPANG'],
            [43, 'PT. BAHTERA LOGISTIK NUSANTARA'],
            [44, 'PT. DHARMA LAUTAN UTAMA'],
            [45, 'PT. FLOBAMOR'],
            [46, 'PT. MULTI GUNA MARITIM'],
            [47, 'PT. PELAYARAN DHARMA INDAH'],
            [48, 'PT. PELAYARAN NASIONAL INDONESIA'],
            [49, 'PT. PELAYARAN SAKTI INTI MAKMUR'],
            [50, 'PT. PELAYARAN WIRAYUDA MARITIM'],
            [51, 'PT. SELVI TRANS INDO'],
            [52, 'PT. SUBSEA LINTAS GLOBALINDO'],
            [53, 'PT. ASDP (PERSERO) CABANG KUPANG'],
            [54, 'PT. ASDP INDOBESIA FERRY'],
            [55, 'PT. CITRABARU ADINUSANTARA'],
            [56, 'PT. DHARMA LAUTAN UTAMA'],
            [57, 'PT. PELAYARAN NASIONAL INDONESIA'],
            [58, 'PT. SINAR SARITAMA MANDIRI'],
            [59, 'PT. ASDP (PERSERO) CAB. SAPE'],
            [60, 'PT. BADAN JAVA SHIPPING LINES'],
            [61, 'PT. PELAYARAN NASIONAL INDONESIA'],
            [62, 'PT. ATOSIM LAMPUNG PELAYARAN'],
            [63, 'PT. PELAYARAN NASIONAL INDONESIA'],
            [64, 'PT. PELAYARAN SAKTI INTI MAKMUR'],
            [65, 'PT. DHARMA LAUTAN UTAMA'],
            [66, 'PT. PELAYARAN MANDALA SEJAHTERA ABA'],
            [67, 'PT. SINAR SARITAMA MANDIRI'],
            [68, 'PT. ASDP CAB. PEL. PENYEBRANGAN KLA'],
            [69, 'PT. ATOSIM LAMPUNG PELAYARAN'],
            [70, 'PT. BERLIAN LAUTAN SEJAHTERA'],
            [71, 'PT. DAMAI LAUTAN NUSANTARA'],
            [72, 'PT. DAMAI MILA UTAMA'],
            [73, 'PT. DHARMA DWIPA UTAMA'],
            [74, 'PT. DJAKARTA LLOYD (PERSERO)'],
            [75, 'PT. DUTA BAHARI MENARA LINE'],
            [76, 'PT. LINTAS SAMUDERA GLOBALINDO'],
            [77, 'PT. LUAS LINE'],
            [78, 'PT. MUTIARA FERINDO INTERNUSA'],
            [79, 'PT. PELAYARAN NASIONAL INDONESIA'],
            [80, 'PT. SUBSEA LINTAS GLOBALINDO'],
            [81, 'PT. TIMUR MILA UTAMA'],
            [82, 'PT. ASDP CAB. PEL. PENYEBRANGAN KLA'],
            [83, 'PT. BALI EKA JAYA'],
            [84, 'PT. GERBANGSAMUDRA SARANA'],
            [85, 'PT. JEMBATAN NUSANTARA'],
            [86, 'PT. MUNIC LINE'],
            [87, 'PT. SEMAYA RESTUJAYA SAMUDRA'],
            [88, 'PT. BUDIMAN INDAH PERKASA'],
            [89, 'PT. SAMOEDRA JAYA GIRI NUSA'],
            [90, 'PT. SEMAYA RESTUJAYA SAMUDRA'],
        ];
        foreach ($companies as $c) {
            Perusahaan::create([
                'id_perusahaan' => 'P' . sprintf('%03d', $c[0]),
                'nama_perusahaan' => $c[1]
            ]);
        }

        // 2. Seed FTIT (13 Real Depots with formatted FT01 - FT13 keys)
        $depots = [
            [1, 'Depot Reo'],
            [2, 'Depot Waingapu'],
            [3, 'Depot Benoa/Sanggaran'],
            [4, 'Depot Tanjung Wangi'],
            [5, 'Depot Maumere'],
            [6, 'Depot Camplong'],
            [7, 'IT TENAU Kupang'],
            [8, 'Depot Kalabahi'],
            [9, 'TT Manggis'],
            [10, 'Depot Bima'],
            [11, 'Depot Ende'],
            [12, 'Depot Ampenan'],
            [13, 'Inst. Surabaya'],
        ];
        foreach ($depots as $d) {
            Ftit::create([
                'id_ftit' => 'FT' . sprintf('%02d', $d[0]),
                'nama_ftit' => $d[1]
            ]);
        }

        // 3. Seed Status Pengisian (First or Create)
        $statuses = [
            ['id_status' => 1, 'nama_status' => 'Pending'],
            ['id_status' => 2, 'nama_status' => 'Verified'],
            ['id_status' => 3, 'nama_status' => 'Rejected'],
        ];
        foreach ($statuses as $s) {
            StatusPengisian::firstOrCreate(['id_status' => $s['id_status']], ['nama_status' => $s['nama_status']]);
        }

        // 4. Seed Users (First or Create)
        $admin = User::find('PR001');
        if ($admin) {
            $admin->update(['nama_user' => 'Budi Santoso']);
        } else {
            User::create([
                'id_user' => 'PR001',
                'nama_user' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]);
        }

        $crew = User::find('AK001');
        if ($crew) {
            $crew->update(['nama_user' => 'Ahmad Wijaya']);
        } else {
            User::create([
                'id_user' => 'AK001',
                'nama_user' => 'Ahmad Wijaya',
                'password' => Hash::make('password'),
                'role' => 'awak_kapal',
            ]);
        }

        $randomNames = [
            3 => 'Dedi Hermawan',
            4 => 'Rian Saputra',
            5 => 'Hendra Gunawan',
            6 => 'Eko Prasetyo',
            7 => 'Taufik Hidayat',
            8 => 'Bambang Susilo',
            9 => 'Agus Rahardjo',
        ];

        for ($i = 3; $i <= 9; $i++) {
            $userId = 'AK00' . ($i - 1);
            $randomName = $randomNames[$i] ?? 'Crew Member';
            $otherCrew = User::find($userId);
            if ($otherCrew) {
                $otherCrew->update(['nama_user' => $randomName]);
            } else {
                User::create([
                    'id_user' => $userId,
                    'nama_user' => $randomName,
                    'password' => Hash::make('password'),
                    'role' => 'awak_kapal',
                ]);
            }
        }

        // 5. Seed Kapal (Only if the table is completely empty, to preserve your real ship database)
        if (Kapal::count() == 0) {
            $ships = [
                ['kode_vessel' => 'VSL-001', 'nama_kapal' => 'KM Nusantara Jaya', 'kelompok_kapal' => 'Kuota A', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P001'],
                ['kode_vessel' => 'VSL-002', 'nama_kapal' => 'KM Samudra Indah', 'kelompok_kapal' => 'Kuota A', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P002'],
                ['kode_vessel' => 'VSL-003', 'nama_kapal' => 'KM Pelangi Nusantara', 'kelompok_kapal' => 'Kuota B', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P003'],
                ['kode_vessel' => 'VSL-004', 'nama_kapal' => 'KM Bahari Sejahtera', 'kelompok_kapal' => 'Kuota B', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P004'],
                ['kode_vessel' => 'VSL-005', 'nama_kapal' => 'KM Citra Lautan', 'kelompok_kapal' => 'Kuota A', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P005'],
                ['kode_vessel' => 'VSL-006', 'nama_kapal' => 'KM Lautan Biru', 'kelompok_kapal' => 'Kuota C', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P006'],
                ['kode_vessel' => 'VSL-007', 'nama_kapal' => 'KM Samudera Makmur', 'kelompok_kapal' => 'Kuota B', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P007'],
                ['kode_vessel' => 'VSL-008', 'nama_kapal' => 'KM Pelayaran Rakyat', 'kelompok_kapal' => 'Kuota A', 'sektor_kapal' => 'Kapal Penumpang', 'id_perusahaan' => 'P008'],
            ];
            foreach ($ships as $ship) {
                Kapal::create($ship);
            }
        }

        // 6. Seed Logbooks & Detail Pemakaian (Only if the table is completely empty)
        if (Logbook::count() == 0) {
            $ships = Kapal::limit(8)->get();
            $idLogbook = 1;
            $idDetail = 1;

            $vesselFtitMap = [
                'VSL-001' => 'FT01', 'VSL-002' => 'FT02', 'VSL-003' => 'FT03', 'VSL-004' => 'FT04',
                'VSL-005' => 'FT05', 'VSL-006' => 'FT06', 'VSL-007' => 'FT07', 'VSL-008' => 'FT08',
            ];

            foreach ($ships as $index => $ship) {
                $userAssigned = ($index === 0) ? 2 : (($index + 2 <= 9) ? $index + 2 : 2);
                $ftitId = $vesselFtitMap[$ship->kode_vessel] ?? 'FT01';

                $sisaFO = 120000.00;
                $sys_kemarin = 120000.00;

                for ($m = 1; $m <= 7; $m++) {
                    $days = ($m == 7) ? 20 : cal_days_in_month(CAL_GREGORIAN, $m, 2026);
                    for ($d = 1; $d <= $days; $d++) {
                        $dateStr = sprintf('2026-%02d-%02d', $m, $d);

                        $induk = (float) rand(2800, 3400);
                        $bantu = (float) rand(600, 780);
                        $lain = (float) rand(120, 180);
                        $usage = $induk + $bantu + $lain;

                        $ditambah = 0.00;
                        if ($sisaFO < 40000.00) {
                            $ditambah = 100000.00;
                        }

                        $sisaSekarang = $sisaFO - $usage;
                        $jumlah = $sisaSekarang + $ditambah;

                        // System calculations
                        $sys_total_penggunaan = $usage;
                        $sys_sisa_sekarang = $sys_kemarin - $sys_total_penggunaan;
                        $sys_jumlah_sekarang = $sys_sisa_sekarang + $ditambah;

                        // Occasional manual inputs discrepancies
                        $discrepancy = 0.00;
                        if (($d + $m * 5) % 12 === 0) {
                            $discrepancy = (float) rand(150, 450);
                        }

                        $manual_sisa_sekarang = $sisaSekarang + $discrepancy;
                        $manual_jumlah = $jumlah + $discrepancy;

                        Logbook::create([
                            'id_logbook' => $idLogbook,
                            'id_user' => $userAssigned,
                            'kode_vessel' => $ship->kode_vessel,
                            'id_status' => 2, // 'Verified'
                            'tanggal_pencatatan' => $dateStr,
                            'catatan' => 'Operasional kapal berjalan lancar dan aman.',
                        ]);

                        DetailPemakaian::create([
                            'id_detail' => $idDetail,
                            'id_logbook' => $idLogbook,
                            'id_ftit' => $ftitId,
                            'sisa_kemarin' => $sisaFO,
                            'mesin_induk' => $induk,
                            'mesin_bantu' => $bantu,
                            'lain_lain' => $lain,
                            'total' => $usage,
                            'sisa_sekarang' => $manual_sisa_sekarang,
                            'ditambah' => $ditambah,
                            'jumlah' => $manual_jumlah,
                            'sisakemarin_seharusnya' => $sys_kemarin,
                            'total_seharusnya' => $sys_total_penggunaan,
                            'sisasekarang_seharusnya' => $sys_sisa_sekarang,
                            'ditambah_seharusnya' => $ditambah,
                            'jumlah_seharusnya' => $sys_jumlah_sekarang,
                        ]);

                        $sisaFO = $manual_jumlah;
                        $sys_kemarin = $sys_jumlah_sekarang;

                        $idLogbook++;
                        $idDetail++;
                    }
                }
            }
        }
    }
}
