<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kapal;
use App\Models\Logbook;
use App\Models\DetailPemakaian;
use App\Models\Verifikasi;
use App\Models\JadwalPerjalanan;
use App\Models\Perusahaan;
use App\Models\Ftit;
use App\Models\User;
use App\Models\DokumenLogbook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PertaminaController extends Controller
{
    public function dashboard(Request $request)
    {
        $c1_year = $request->input('c1_year', date('Y'));
        $c2_month = $request->input('c2_month', date('m'));
        $c2_year = $request->input('c2_year', date('Y'));
        $c3_month = $request->input('c3_month', date('m'));
        $c3_year = $request->input('c3_year', date('Y'));
        $c4_month = $request->input('c4_month', date('m'));
        $c4_year = $request->input('c4_year', date('Y'));

        $totalKapal = Kapal::count();
        
        // Calculations for C2 (Consumption Trend/Stats/Table)
        $c2_days = cal_days_in_month(CAL_GREGORIAN, (int)$c2_month, (int)$c2_year);
        $totalTargetBulanIni = $totalKapal * $c2_days;
        
        // Logbook Bulan Ini (C2)
        $logbookBulanIni = Logbook::whereMonth('tanggal_pencatatan', $c2_month)
            ->whereYear('tanggal_pencatatan', $c2_year)
            ->count();
        
        // Total konsumsi FO keseluruhan di bulan terpilih (C2)
        $totalKonsumsiFO = DetailPemakaian::whereHas('logbook', function($q) use ($c2_month, $c2_year) {
                $q->whereMonth('tanggal_pencatatan', $c2_month)->whereYear('tanggal_pencatatan', $c2_year);
            })->sum('total');

        // PT mapping helper
        $ptMapping = [
            'VSL-001' => 'PT. AGUNG TAMA RAYA',
            'VSL-002' => 'PT. ASDP (PERSERO) C.KAYANGAN',
            'VSL-003' => 'PT. ASDP INDONESIA FERRY (PERSERO)',
            'VSL-004' => 'PT. ATOSIM LAMPUNG PELAYARAN',
            'VSL-005' => 'PT. BAHTERA SAMUDERA INDONESIA',
            'VSL-006' => 'PT. DHARMA LAUTAN UTAMA',
            'VSL-007' => 'PT. DUTA BAHARI MENARA LINE',
            'VSL-008' => 'PT. GARDA MARITIM NUSATAMA',
        ];

        // Depot mapping helper
        $depotMapping = [
            'VSL-001' => 'Depot Reo',
            'VSL-002' => 'Depot Waingapu',
            'VSL-003' => 'Depot Benoa/Sanggaran',
            'VSL-004' => 'Depot Tanjung Wangi',
            'VSL-005' => 'Depot Maumere',
            'VSL-006' => 'Depot Camplong',
            'VSL-007' => 'IT TENAU Kupang',
            'VSL-008' => 'Depot Kalabahi',
        ];

        $ships = Kapal::with(['perusahaan', 'ftit', 'depots'])->get();
        $vesselCodes = $ships->pluck('kode_vessel')->toArray();
        $kapalSelisihCount = 0;

        foreach ($ships as $ship) {
            $ship->pt_name = $ship->perusahaan->nama_perusahaan ?? 'PT Pelayaran Nasional';
            
            $monthlyLog = Logbook::where('kode_vessel', $ship->kode_vessel)
                ->whereMonth('tanggal_pencatatan', $c2_month)
                ->whereYear('tanggal_pencatatan', $c2_year)
                ->orderBy('tanggal_pencatatan', 'desc')
                ->first();
            $monthlyDetail = $monthlyLog ? $monthlyLog->detailPemakaians()->first() : null;
            if ($ship->depots && $ship->depots->isNotEmpty()) {
                $ship->depot_name = $ship->depots->pluck('nama_ftit')->implode(', ');
            } elseif ($monthlyDetail && $monthlyDetail->ftit) {
                $ship->depot_name = $monthlyDetail->ftit->nama_ftit;
            } else {
                $latestLog = $ship->logbooks()->orderBy('tanggal_pencatatan', 'desc')->first();
                $latestDetail = $latestLog ? $latestLog->detailPemakaians()->first() : null;
                $ship->depot_name = ($latestDetail && $latestDetail->ftit) ? $latestDetail->ftit->nama_ftit : 'Depot Surabaya';
            }

            $logbooks = Logbook::with('detailPemakaians')
                ->where('kode_vessel', $ship->kode_vessel)
                ->whereMonth('tanggal_pencatatan', $c2_month)
                ->whereYear('tanggal_pencatatan', $c2_year)
                ->get();

            $ship->logbooks_count = $logbooks->count();
            if ($ship->logbooks_count == 0) {
                $ship->status_pengisian = 'Belum Mengisi';
            } elseif ($ship->logbooks_count < $c2_days) {
                $ship->status_pengisian = 'Belum Lengkap';
            } else {
                $ship->status_pengisian = 'Selesai';
            }

            $totalDiscrepancy = 0;
            foreach ($logbooks as $log) {
                $fo = $log->detailPemakaians->first();
                if ($fo) {
                    $input_sisa_kemarin = $fo->sisa_kemarin ?: 0;
                    $input_induk = $fo->motor_induk ?: 0;
                    $input_bantu = $fo->motor_bantu ?: 0;
                    $input_lain = $fo->lain_lain ?: 0;
                    $input_tambah = $fo->ditambah ?: 0;
                    $input_sekarang = $fo->sisa_sekarang ?: 0;
                    $input_jumlah = $fo->jumlah_sekarang ?: 0;

                    $sys_total_penggunaan = $input_induk + $input_bantu + $input_lain;
                    $sys_sisa_sekarang = $input_sisa_kemarin - $sys_total_penggunaan;
                    $sys_jumlah_sekarang = $sys_sisa_sekarang + $input_tambah;

                    $diff_sisa = abs($input_sekarang - $sys_sisa_sekarang);
                    $diff_jumlah = abs($input_jumlah - $sys_jumlah_sekarang);

                    $totalDiscrepancy += ($diff_sisa + $diff_jumlah);
                }
            }
            $ship->total_discrepancy = $totalDiscrepancy;
            if ($totalDiscrepancy > 0) {
                $kapalSelisihCount++;
            }
        }

        // Chart 1: Jumlah pengisian logbook tiap bulannya di tahun terpilih (Horizontal Bar Chart)
        $monthlyInputs = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyInputs[] = Logbook::whereYear('tanggal_pencatatan', $c1_year)
                ->whereMonth('tanggal_pencatatan', $m)
                ->count();
        }

        // Chart 2: Tren Harian FO untuk bulan terpilih (c2_month, c2_year)
        $trendLabels = [];
        $trendFO = [];
        for ($d = 1; $d <= $c2_days; $d++) {
            $dateStr = sprintf('%04d-%02d-%02d', $c2_year, $c2_month, $d);
            $trendLabels[] = $d;
            $trendFO[] = (float) DetailPemakaian::whereHas('logbook', function($q) use ($dateStr) {
                $q->whereDate('tanggal_pencatatan', $dateStr);
            })->sum('total');
        }

        // Chart 3: Persentase Pengisian Logbook Bulan Ini (c3_month, c3_year)
        $c3_days = cal_days_in_month(CAL_GREGORIAN, (int)$c3_month, (int)$c3_year);
        $totalTargetC3 = $totalKapal * $c3_days;
        $logbookC3Count = Logbook::whereMonth('tanggal_pencatatan', $c3_month)
            ->whereYear('tanggal_pencatatan', $c3_year)
            ->count();
        $statusPercentages = [
            $totalTargetC3 > 0 ? round(($logbookC3Count / $totalTargetC3) * 100) : 0,
            $totalTargetC3 > 0 ? round((max(0, $totalTargetC3 - $logbookC3Count) / $totalTargetC3) * 100) : 0
        ];

        // Chart 4: Perangkingan perusahaan paling rajin mengisi logbook pada bulan terpilih (c4_month, c4_year)
        $c4_days = cal_days_in_month(CAL_GREGORIAN, (int)$c4_month, (int)$c4_year);
        $companies = \App\Models\Perusahaan::with('kapals')->get();
        $companyRankings = [];

        foreach ($companies as $company) {
            $shipCodes = $company->kapals->pluck('kode_vessel')->toArray();
            $shipCount = count($shipCodes);
            if ($shipCount === 0) {
                continue;
            }

            $targetLogs = $shipCount * $c4_days;
            $actualLogs = Logbook::whereIn('kode_vessel', $shipCodes)
                ->whereMonth('tanggal_pencatatan', $c4_month)
                ->whereYear('tanggal_pencatatan', $c4_year)
                ->count();

            $percentage = $targetLogs > 0 ? round(($actualLogs / $targetLogs) * 100, 1) : 0;

            $companyRankings[] = [
                'nama_perusahaan' => $company->nama_perusahaan,
                'percentage' => $percentage
            ];
        }

        // Sort descending by percentage
        usort($companyRankings, function($a, $b) {
            return $b['percentage'] <=> $a['percentage'];
        });

        // Pluck data for chart (limit to top 15 or all)
        $rankingLabels = array_column($companyRankings, 'nama_perusahaan');
        $rankingPercentages = array_column($companyRankings, 'percentage');

        return view('pertamina.dashboard', compact(
            'totalKapal', 'logbookBulanIni', 'totalTargetBulanIni', 'totalKonsumsiFO', 'kapalSelisihCount',
            'vesselCodes', 'monthlyInputs', 'trendLabels', 'trendFO', 'statusPercentages',
            'rankingLabels', 'rankingPercentages', 'ships', 
            'c1_year', 'c2_month', 'c2_year', 'c3_month', 'c3_year', 'c4_month', 'c4_year', 'c2_days'
        ));
    }

    public function monitoring(Request $request)
    {
        $month = $request->input('month', date('m'));
        $year = $request->input('year', date('Y'));
        $ft_it = $request->input('ft_it');
        $id_perusahaan = $request->input('id_perusahaan');
        $search_kapal = $request->input('search_kapal');

        $depots = \App\Models\Ftit::orderBy('nama_ftit', 'asc')->get();
        $companies = \App\Models\Perusahaan::orderBy('nama_perusahaan', 'asc')->get();

        $query = Kapal::with(['perusahaan', 'ftit', 'depots']);
        
        if ($ft_it) {
            $query->whereHas('depots', function($q) use ($ft_it) {
                $q->where('ftit.id_ftit', $ft_it);
            });
        }

        if ($id_perusahaan) {
            $query->where('id_perusahaan', $id_perusahaan);
        }

        if ($search_kapal) {
            $query->where(function($q) use ($search_kapal) {
                $q->where('nama_kapal', 'LIKE', '%' . $search_kapal . '%')
                  ->orWhere('kode_vessel', 'LIKE', '%' . $search_kapal . '%');
            });
        }

        $ships = $query->paginate(15)->withQueryString();

        // Gather statistics for each ship
        foreach ($ships as $ship) {
            $ship->pt_name = $ship->perusahaan->nama_perusahaan ?? 'PT Pelayaran Nasional';
            
            // Find PDF for this ship, month, and year
            $dateStr = sprintf('%04d-%02d-01', $year, $month);
            $ship->pdf_document = DokumenLogbook::where('kode_vessel', $ship->kode_vessel)
                ->where('tanggal_logbook', $dateStr)
                ->first();
            
            $monthlyLog = Logbook::where('kode_vessel', $ship->kode_vessel)
                ->whereMonth('tanggal_pencatatan', $month)
                ->whereYear('tanggal_pencatatan', $year)
                ->orderBy('tanggal_pencatatan', 'desc')
                ->first();
            $monthlyDetail = $monthlyLog ? $monthlyLog->detailPemakaians()->first() : null;
            if ($ship->depots && $ship->depots->isNotEmpty()) {
                $ship->depot_name = $ship->depots->pluck('nama_ftit')->implode(', ');
            } elseif ($monthlyDetail && $monthlyDetail->ftit) {
                $ship->depot_name = $monthlyDetail->ftit->nama_ftit;
            } else {
                $latestLog = $ship->logbooks()->orderBy('tanggal_pencatatan', 'desc')->first();
                $latestDetail = $latestLog ? $latestLog->detailPemakaians()->first() : null;
                $ship->depot_name = ($latestDetail && $latestDetail->ftit) ? $latestDetail->ftit->nama_ftit : 'Depot Surabaya';
            }

            // Get logbooks for this ship in the selected month & year
            $logbooks = Logbook::with('detailPemakaians')
                ->where('kode_vessel', $ship->kode_vessel)
                ->whereMonth('tanggal_pencatatan', $month)
                ->whereYear('tanggal_pencatatan', $year)
                ->orderBy('tanggal_pencatatan', 'asc')
                ->get();

            $days_in_month = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
            $ship->logbooks_count = $logbooks->count();
            if ($ship->logbooks_count == 0) {
                $ship->status_pengisian = 'Belum Mengisi';
            } elseif ($ship->logbooks_count < $days_in_month) {
                $ship->status_pengisian = 'Belum Lengkap';
            } else {
                $ship->status_pengisian = 'Selesai';
            }

            // Calculate monthly discrepancy (selisih)
            $totalDiscrepancy = 0;
            foreach ($logbooks as $log) {
                $fo = $log->detailPemakaians->first();
                if ($fo) {
                    $input_sisa_kemarin = $fo->sisa_kemarin ?: 0;
                    $input_induk = $fo->motor_induk ?: 0;
                    $input_bantu = $fo->motor_bantu ?: 0;
                    $input_lain = $fo->lain_lain ?: 0;
                    $input_tambah = $fo->ditambah ?: 0;
                    $input_sekarang = $fo->sisa_sekarang ?: 0;
                    $input_jumlah = $fo->jumlah_sekarang ?: 0;

                    // System calculation
                    $sys_total_penggunaan = $input_induk + $input_bantu + $input_lain;
                    $sys_sisa_sekarang = $input_sisa_kemarin - $sys_total_penggunaan;
                    $sys_jumlah_sekarang = $sys_sisa_sekarang + $input_tambah;

                    // Discrepancy
                    $diff_sisa = abs($input_sekarang - $sys_sisa_sekarang);
                    $diff_jumlah = abs($input_jumlah - $sys_jumlah_sekarang);

                    $totalDiscrepancy += ($diff_sisa + $diff_jumlah);
                }
            }
            $ship->total_discrepancy = $totalDiscrepancy;
            $ship->logbooks = $logbooks; // Keep logbooks collection for grid view
        }

        $days_in_month = cal_days_in_month(CAL_GREGORIAN, (int)$month, (int)$year);
        return view('pertamina.monitoring', compact('ships', 'month', 'year', 'days_in_month', 'depots', 'ft_it', 'companies', 'id_perusahaan', 'search_kapal'));
    }







    public function laporan(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');
        $id_perusahaan = $request->input('id_perusahaan');
        $search_kapal = $request->input('search_kapal');
        $ft_it = $request->input('ft_it');

        $companies = \App\Models\Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        $depots = \App\Models\Ftit::orderBy('nama_ftit', 'asc')->get();

        // PT mapping helper
        $ptMapping = [
            'VSL-001' => 'PT. AGUNG TAMA RAYA',
            'VSL-002' => 'PT. ASDP (PERSERO) C.KAYANGAN',
            'VSL-003' => 'PT. ASDP INDONESIA FERRY (PERSERO)',
            'VSL-004' => 'PT. ATOSIM LAMPUNG PELAYARAN',
            'VSL-005' => 'PT. BAHTERA SAMUDERA INDONESIA',
            'VSL-006' => 'PT. DHARMA LAUTAN UTAMA',
            'VSL-007' => 'PT. DUTA BAHARI MENARA LINE',
            'VSL-008' => 'PT. GARDA MARITIM NUSATAMA',
        ];

        // Depot mapping helper
        $depotMapping = [
            'VSL-001' => 'Depot Reo',
            'VSL-002' => 'Depot Waingapu',
            'VSL-003' => 'Depot Benoa/Sanggaran',
            'VSL-004' => 'Depot Tanjung Wangi',
            'VSL-005' => 'Depot Maumere',
            'VSL-006' => 'Depot Camplong',
            'VSL-007' => 'IT TENAU Kupang',
            'VSL-008' => 'Depot Kalabahi',
        ];

        $query = Kapal::with(['perusahaan', 'ftit', 'depots']);

        if ($id_perusahaan) {
            $query->where('id_perusahaan', $id_perusahaan);
        }

        if ($search_kapal) {
            $query->where(function($q) use ($search_kapal) {
                $q->where('nama_kapal', 'LIKE', '%' . $search_kapal . '%')
                  ->orWhere('kode_vessel', 'LIKE', '%' . $search_kapal . '%');
            });
        }

        if ($ft_it) {
            $query->whereHas('depots', function($q) use ($ft_it) {
                $q->where('ftit.id_ftit', $ft_it);
            });
        }

        $ships = $query->get();
        $totalKonsumsi = 0;
        
        $dailyLogsData = [];
        $vesselLabels = [];
        $laporanChartData = [
            'fo' => []
        ];

        foreach ($ships as $ship) {
            $ship->pt_name = $ship->perusahaan->nama_perusahaan ?? 'PT Pelayaran Nasional';

            $monthlyLog = Logbook::where('kode_vessel', $ship->kode_vessel)
                ->whereYear('tanggal_pencatatan', $year)
                ->orderBy('tanggal_pencatatan', 'desc')
                ->first();
            $monthlyDetail = $monthlyLog ? $monthlyLog->detailPemakaians()->first() : null;
            if ($ship->depots && $ship->depots->isNotEmpty()) {
                $ship->depot_name = $ship->depots->pluck('nama_ftit')->implode(', ');
            } elseif ($monthlyDetail && $monthlyDetail->ftit) {
                $ship->depot_name = $monthlyDetail->ftit->nama_ftit;
            } else {
                $latestLog = $ship->logbooks()->orderBy('tanggal_pencatatan', 'desc')->first();
                $latestDetail = $latestLog ? $latestLog->detailPemakaians()->first() : null;
                $ship->depot_name = ($latestDetail && $latestDetail->ftit) ? $latestDetail->ftit->nama_ftit : 'Depot Surabaya';
            }

            $logbooks = Logbook::with('detailPemakaians')
                ->where('kode_vessel', $ship->kode_vessel)
                ->whereYear('tanggal_pencatatan', $year)
                ->orderBy('tanggal_pencatatan', 'asc')
                ->get();

            $ship->logbooks_count = $logbooks->count();
            
            $foTotal = 0;
            $logs = [];

            $sys_kemarin = null;
            foreach ($logbooks as $log) {
                $do = $log->detailPemakaians->where('id_jenis', 1)->first();
                $fo = $log->detailPemakaians->where('id_jenis', 2)->first();
                $lube = $log->detailPemakaians->where('id_jenis', 3)->first();
                $cyl = $log->detailPemakaians->where('id_jenis', 4)->first();

                $doSum = $do ? ($do->motor_induk + $do->motor_bantu + $do->lain_lain) : 0;
                $foSum = $fo ? ($fo->motor_induk + $fo->motor_bantu + $fo->lain_lain) : 0;
                $lubeSum = $lube ? ($lube->motor_induk + $lube->motor_bantu + $lube->lain_lain) : 0;
                $cylSum = $cyl ? ($cyl->motor_induk + $cyl->motor_bantu + $cyl->lain_lain) : 0;

                $foTotal += $foSum;

                if ($fo) {
                    if ($sys_kemarin === null) {
                        $sys_kemarin = $fo->sisa_kemarin ?: 0;
                    }
                    $manual_kemarin = $fo->sisa_kemarin ?: 0;
                    $manual_induk = $fo->motor_induk ?: 0;
                    $manual_bantu = $fo->motor_bantu ?: 0;
                    $manual_lain = $fo->lain_lain ?: 0;
                    $manual_total_penggunaan = $foSum;
                    $manual_sekarang = $fo->sisa_sekarang ?: 0;
                    $manual_tambah = $fo->ditambah ?: 0;
                    $manual_jumlah = $fo->jumlah_sekarang ?: 0;

                    $sys_total_penggunaan = $manual_total_penggunaan;
                    $sys_sisa_sekarang = $sys_kemarin - $sys_total_penggunaan;
                    $sys_jumlah_sekarang = $sys_sisa_sekarang + $manual_tambah;

                    $has_discrepancy_kemarin = abs($manual_kemarin - $sys_kemarin) > 0;
                    $has_discrepancy_sisa = abs($manual_sekarang - $sys_sisa_sekarang) > 0;
                    $has_discrepancy_jumlah = abs($manual_jumlah - $sys_jumlah_sekarang) > 0;
                    $row_selisih = abs($manual_sekarang - $sys_sisa_sekarang) + abs($manual_jumlah - $sys_jumlah_sekarang);

                    $logs[] = [
                        'tanggal' => $log->tanggal_pencataan->format('d/m/Y'),
                        'do' => $doSum,
                        'fo' => $foSum,
                        'lube' => $lubeSum,
                        'cyl' => $cylSum,
                        'status' => 'Verified',
                        'catatan' => $log->catatan ?: 'Operasional normal.',
                        
                        // Detailed comparison fields (Manual vs System)
                        'manual_kemarin' => $manual_kemarin,
                        'manual_induk' => $manual_induk,
                        'manual_bantu' => $manual_bantu,
                        'manual_lain' => $manual_lain,
                        'manual_total_penggunaan' => $manual_total_penggunaan,
                        'manual_sekarang' => $manual_sekarang,
                        'manual_tambah' => $manual_tambah,
                        'manual_jumlah' => $manual_jumlah,
                        
                        'sys_kemarin' => $sys_kemarin,
                        'sys_total_penggunaan' => $sys_total_penggunaan,
                        'sys_sisa_sekarang' => $sys_sisa_sekarang,
                        'sys_tambah' => $manual_tambah,
                        'sys_jumlah_sekarang' => $sys_jumlah_sekarang,
                        
                        'has_discrepancy_kemarin' => $has_discrepancy_kemarin,
                        'has_discrepancy_sisa' => $has_discrepancy_sisa,
                        'has_discrepancy_jumlah' => $has_discrepancy_jumlah,
                        'row_selisih' => $row_selisih,
                    ];

                    $sys_kemarin = $sys_jumlah_sekarang; // Update system kemarin for next entry
                }
            }

            $ship->fo_total = $foTotal;
            $totalKonsumsi += $foTotal;
            $dailyLogsData[$ship->kode_vessel] = $logs;
            
            $vesselLabels[] = $ship->kode_vessel;
            $laporanChartData['fo'][] = $foTotal;
        }

        // Kapal paling banyak konsumsi FO di tahun ini
        $topVessel = DetailPemakaian::select('logbook.kode_vessel', DB::raw('SUM(detail_pemakaian.total) as total'))
            ->join('logbook', 'detail_pemakaian.id_logbook', '=', 'logbook.id_logbook')
            ->whereYear('logbook.tanggal_pencatatan', $year)
            ->groupBy('logbook.kode_vessel')
            ->orderBy('total', 'desc')
            ->first();

        $topVesselName = $topVessel ? (Kapal::find($topVessel->kode_vessel)->nama_kapal ?? '-') : '-';
        $topVesselTotal = $topVessel ? $topVessel->total : 0;

        $vesselsCount = $ships->count();
        $averageCons = $vesselsCount > 0 ? round($totalKonsumsi / $vesselsCount, 2) : 0;

        // Fetch monthly logs and sum FO consumption
        $monthlyCons = DB::table('detail_pemakaian')
            ->join('logbook', 'detail_pemakaian.id_logbook', '=', 'logbook.id_logbook')
            ->select(
                'logbook.kode_vessel',
                DB::raw('MONTH(logbook.tanggal_pencatatan) as month'),
                DB::raw('SUM(detail_pemakaian.total) as total')
            )
            ->whereYear('logbook.tanggal_pencatatan', $year)
            ->groupBy('logbook.kode_vessel', 'month')
            ->get();

        // Fetch PDF uploads for this year
        $pdfs = DokumenLogbook::whereYear('tanggal_logbook', $year)->get();
        $pdfMap = [];
        foreach ($pdfs as $p) {
            $monthNum = (int) date('m', strtotime($p->tanggal_logbook));
            $pdfMap[$p->kode_vessel][$monthNum] = $p;
        }

        // Build monthly records list
        $monthlyReportData = [];
        $monthsName = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        foreach ($ships as $ship) {
            $startMonth = $month ? (int)$month : 1;
            $endMonth = $month ? (int)$month : 12;
            for ($m = $startMonth; $m <= $endMonth; $m++) {
                $foRecord = $monthlyCons->where('kode_vessel', $ship->kode_vessel)->where('month', $m)->first();
                $totalFo = $foRecord ? $foRecord->total : 0;
                $pdf = $pdfMap[$ship->kode_vessel][$m] ?? null;

                if ($totalFo > 0 || $pdf) {
                    $monthlyReportData[] = [
                        'vessel_code' => $ship->kode_vessel,
                        'nama_kapal' => $ship->nama_kapal,
                        'pt_name' => $ship->pt_name,
                        'depot_name' => $ship->depot_name,
                        'month_num' => $m,
                        'month_name' => $monthsName[$m],
                        'total_fo' => $totalFo,
                        'pdf' => $pdf,
                    ];
                }
            }
        }

        return view('pertamina.laporan', compact(
            'ships', 'totalKonsumsi', 'topVesselName', 'topVesselTotal', 
            'averageCons', 'vesselsCount', 'vesselLabels', 'laporanChartData', 'dailyLogsData', 'year',
            'monthlyReportData', 'companies', 'depots', 'month', 'id_perusahaan', 'search_kapal', 'ft_it'
        ));
    }

    public function profil()
    {
        return view('pertamina.profil');
    }

    public function kapal()
    {
        $kapal = Kapal::with(['ftit', 'depots'])->orderBy('kode_vessel', 'desc')->get();
        $companies = \App\Models\Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        $ftits = \App\Models\Ftit::orderBy('nama_ftit', 'asc')->get();
        return view('pertamina.kapal', compact('kapal', 'companies', 'ftits'));
    }

    public function storeKapal(Request $request)
    {
        $rules = [
            'kode_vessel' => 'required|string|max:50|unique:kapal,kode_vessel',
            'nama_kapal' => 'required|string|max:100',
            'id_perusahaan' => 'required|string|max:10',
            'id_ftit' => 'required|array',
            'id_ftit.*' => 'string|exists:ftit,id_ftit',
        ];

        if ($request->id_perusahaan !== 'lainnya') {
            $rules['id_perusahaan'] .= '|exists:perusahaan,id_perusahaan';
        } else {
            $rules['nama_perusahaan_baru'] = 'required|string|max:100';
        }

        $validated = $request->validate($rules);

        $idPerusahaan = $validated['id_perusahaan'];

        if ($idPerusahaan === 'lainnya') {
            $lastCompany = \App\Models\Perusahaan::where('id_perusahaan', 'LIKE', 'P%')
                ->orderBy('id_perusahaan', 'desc')
                ->first();
            $lastNum = $lastCompany ? (int) substr($lastCompany->id_perusahaan, 1) : 0;
            $newCompanyId = 'P' . sprintf('%03d', $lastNum + 1);

            $perusahaan = \App\Models\Perusahaan::create([
                'id_perusahaan' => $newCompanyId,
                'nama_perusahaan' => $validated['nama_perusahaan_baru'],
            ]);
            $idPerusahaan = $newCompanyId;
        }

        $kapal = Kapal::create([
            'kode_vessel' => $validated['kode_vessel'],
            'nama_kapal' => $validated['nama_kapal'],
            'id_perusahaan' => $idPerusahaan,
            'id_ftit' => $validated['id_ftit'][0] ?? null,
        ]);

        $kapal->depots()->sync($validated['id_ftit']);

        $kapal->load(['perusahaan', 'ftit', 'depots']);

        return response()->json(['success' => true, 'data' => $kapal]);
    }

    public function perusahaan()
    {
        $perusahaan = Perusahaan::orderBy('id_perusahaan', 'desc')->get();
        return view('pertamina.perusahaan', compact('perusahaan'));
    }

    public function storePerusahaan(Request $request)
    {
        $validated = $request->validate([
            'nama_perusahaan' => 'required|string|max:255',
        ]);

        $perusahaan = Perusahaan::create([
            'nama_perusahaan' => $validated['nama_perusahaan'],
        ]);

        // Mock additional properties for AJAX response compatibility
        $perusahaan->kode_perusahaan = 'PRSH-' . sprintf('%03d', $perusahaan->id_perusahaan);
        $perusahaan->status = 'Aktif';

        return response()->json(['success' => true, 'data' => $perusahaan]);
    }

    public function ftit()
    {
        $ftit = Ftit::orderBy('id_ftit', 'desc')->get();
        return view('pertamina.ftit', compact('ftit'));
    }

    public function storeFtit(Request $request)
    {
        $validated = $request->validate([
            'nama_ftit' => 'required|string|max:255',
        ]);

        $ftit = Ftit::create([
            'nama_ftit' => $validated['nama_ftit'],
        ]);

        // Mock additional properties for AJAX response compatibility
        $ftit->kode_ftit = 'FTIT-' . sprintf('%03d', $ftit->id_ftit);
        $ftit->lokasi = 'Indonesia';
        $ftit->status = 'Aktif';

        return response()->json(['success' => true, 'data' => $ftit]);
    }

    public function user()
    {
        $users = User::with('perusahaan')->orderBy('id_user', 'desc')->get();
        $companies = \App\Models\Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        return view('pertamina.user', compact('users', 'companies'));
    }

    public function storeUser(Request $request)
    {
        $rules = [
            'nama_user' => 'required|string|max:100',
            'role' => 'required|in:admin,awak_kapal',
            'password' => 'required|string|min:6',
            'id_perusahaan' => 'required_if:role,awak_kapal|nullable|string|max:10',
        ];

        if ($request->id_perusahaan === 'lainnya') {
            $rules['nama_perusahaan_baru'] = 'required|string|max:100';
        } elseif ($request->role === 'awak_kapal') {
            $rules['id_perusahaan'] .= '|exists:perusahaan,id_perusahaan';
        }

        $validated = $request->validate($rules);

        $prefix = $validated['role'] === 'admin' ? 'PR' : 'AK';
        
        $lastUser = User::where('id_user', 'LIKE', $prefix . '%')
            ->orderBy('id_user', 'desc')
            ->first();
            
        $lastNum = $lastUser ? (int) substr($lastUser->id_user, 2) : 0;
        $newId = $prefix . sprintf('%03d', $lastNum + 1);

        $idPerusahaan = $validated['role'] === 'awak_kapal' ? ($validated['id_perusahaan'] ?? null) : null;

        if ($idPerusahaan === 'lainnya') {
            $lastCompany = \App\Models\Perusahaan::where('id_perusahaan', 'LIKE', 'P%')
                ->orderBy('id_perusahaan', 'desc')
                ->first();
            $lastNum = $lastCompany ? (int) substr($lastCompany->id_perusahaan, 1) : 0;
            $newCompanyId = 'P' . sprintf('%03d', $lastNum + 1);

            $perusahaan = \App\Models\Perusahaan::create([
                'id_perusahaan' => $newCompanyId,
                'nama_perusahaan' => $validated['nama_perusahaan_baru'],
            ]);
            $idPerusahaan = $newCompanyId;
        }

        $user = User::create([
            'id_user' => $newId,
            'nama_user' => $validated['nama_user'],
            'role' => $validated['role'],
            'password' => bcrypt($validated['password']),
            'id_perusahaan' => $idPerusahaan,
        ]);

        $user->load('perusahaan');

        return response()->json(['success' => true, 'data' => $user]);
    }

    public function indexPdf()
    {
        $dokumen = DokumenLogbook::with(['user', 'kapal.perusahaan'])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('pertamina.dokumen-pdf', compact('dokumen'));
    }

    public function downloadPdf($id)
    {
        $dokumen = DokumenLogbook::findOrFail($id);
        $filePath = public_path($dokumen->file_path);

        if (!file_exists($filePath)) {
            abort(404, 'File logbook PDF tidak ditemukan di server.');
        }

        return response()->file($filePath);
    }

    public function updateKapal(Request $request, $kode_vessel)
    {
        $rules = [
            'kode_vessel' => 'required|string|max:50|unique:kapal,kode_vessel,' . $kode_vessel . ',kode_vessel',
            'nama_kapal' => 'required|string|max:100',
            'id_perusahaan' => 'required|string|max:10',
            'id_ftit' => 'required|array',
            'id_ftit.*' => 'string|exists:ftit,id_ftit',
        ];

        if ($request->id_perusahaan !== 'lainnya') {
            $rules['id_perusahaan'] .= '|exists:perusahaan,id_perusahaan';
        } else {
            $rules['nama_perusahaan_baru'] = 'required|string|max:100';
        }

        $validated = $request->validate($rules);

        $idPerusahaan = $validated['id_perusahaan'];

        if ($idPerusahaan === 'lainnya') {
            $lastCompany = \App\Models\Perusahaan::where('id_perusahaan', 'LIKE', 'P%')
                ->orderBy('id_perusahaan', 'desc')
                ->first();
            $lastNum = $lastCompany ? (int) substr($lastCompany->id_perusahaan, 1) : 0;
            $newCompanyId = 'P' . sprintf('%03d', $lastNum + 1);

            $perusahaan = \App\Models\Perusahaan::create([
                'id_perusahaan' => $newCompanyId,
                'nama_perusahaan' => $validated['nama_perusahaan_baru'],
            ]);
            $idPerusahaan = $newCompanyId;
        }

        $kapal = Kapal::findOrFail($kode_vessel);
        $old_kode_vessel = $kapal->kode_vessel;
        $new_kode_vessel = $validated['kode_vessel'];

        DB::transaction(function() use ($kapal, $old_kode_vessel, $new_kode_vessel, $validated, $idPerusahaan) {
            if ($old_kode_vessel !== $new_kode_vessel) {
                if (DB::getDriverName() === 'sqlite') {
                    DB::statement('PRAGMA foreign_keys = OFF;');
                } else {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                }

                // Update related tables: logbook, dokumen_logbook, jadwal_perjalanan
                DB::table('logbook')->where('kode_vessel', $old_kode_vessel)->update(['kode_vessel' => $new_kode_vessel]);
                DB::table('dokumen_logbook')->where('kode_vessel', $old_kode_vessel)->update(['kode_vessel' => $new_kode_vessel]);
                if (\Illuminate\Support\Facades\Schema::hasTable('jadwal_perjalanan')) {
                    DB::table('jadwal_perjalanan')->where('kode_vessel', $old_kode_vessel)->update(['kode_vessel' => $new_kode_vessel]);
                }

                // Update the kapal table itself
                DB::table('kapal')->where('kode_vessel', $old_kode_vessel)->update([
                    'kode_vessel' => $new_kode_vessel,
                    'nama_kapal' => $validated['nama_kapal'],
                    'id_perusahaan' => $idPerusahaan,
                    'id_ftit' => $validated['id_ftit'][0] ?? null,
                ]);

                if (DB::getDriverName() === 'sqlite') {
                    DB::statement('PRAGMA foreign_keys = ON;');
                } else {
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                }

                $kapal->kode_vessel = $new_kode_vessel;
            } else {
                $kapal->update([
                    'nama_kapal' => $validated['nama_kapal'],
                    'id_perusahaan' => $idPerusahaan,
                    'id_ftit' => $validated['id_ftit'][0] ?? null,
                ]);
            }

            // Sync depots
            $kapal->depots()->sync($validated['id_ftit']);
        });

        $kapal->load(['perusahaan', 'ftit', 'depots']);

        return response()->json(['success' => true, 'data' => $kapal]);
    }

    public function deleteKapal($kode_vessel)
    {
        $kapal = Kapal::findOrFail($kode_vessel);
        $perusahaanId = $kapal->id_perusahaan;
        
        // Delete related PDF files physically from server and delete record explicitly
        $documents = DokumenLogbook::where('kode_vessel', $kode_vessel)->get();
        foreach ($documents as $doc) {
            if (!empty($doc->file_path)) {
                $filePath = public_path($doc->file_path);
                if (file_exists($oldFilePath = $filePath)) {
                    unlink($oldFilePath);
                }
            }
            $doc->delete();
        }

        // Cascade delete logbooks and detail pemakaians
        foreach ($kapal->logbooks as $log) {
            $log->detailPemakaians()->delete();
            $log->delete();
        }

        $kapal->delete();

        // Clean up company if it no longer has any vessels or users associated with it
        if ($perusahaanId) {
            $otherShipsCount = Kapal::where('id_perusahaan', $perusahaanId)->count();
            $usersCount = User::where('id_perusahaan', $perusahaanId)->count();
            if ($otherShipsCount === 0 && $usersCount === 0) {
                Perusahaan::where('id_perusahaan', $perusahaanId)->delete();
            }
        }

        return response()->json(['success' => true]);
    }

    public function updateUser(Request $request, $id_user)
    {
        $rules = [
            'id_user' => 'required|string|max:50|unique:user,id_user,' . $id_user . ',id_user',
            'nama_user' => 'required|string|max:100',
            'role' => 'required|in:admin,awak_kapal',
            'password' => 'nullable|string|min:6',
            'id_perusahaan' => 'required_if:role,awak_kapal|nullable|string|max:10',
        ];

        if ($request->id_perusahaan === 'lainnya') {
            $rules['nama_perusahaan_baru'] = 'required|string|max:100';
        } elseif ($request->role === 'awak_kapal') {
            $rules['id_perusahaan'] .= '|exists:perusahaan,id_perusahaan';
        }

        $validated = $request->validate($rules);

        $idPerusahaan = $validated['role'] === 'awak_kapal' ? ($validated['id_perusahaan'] ?? null) : null;

        if ($idPerusahaan === 'lainnya') {
            $lastCompany = \App\Models\Perusahaan::where('id_perusahaan', 'LIKE', 'P%')
                ->orderBy('id_perusahaan', 'desc')
                ->first();
            $lastNum = $lastCompany ? (int) substr($lastCompany->id_perusahaan, 1) : 0;
            $newCompanyId = 'P' . sprintf('%03d', $lastNum + 1);

            $perusahaan = \App\Models\Perusahaan::create([
                'id_perusahaan' => $newCompanyId,
                'nama_perusahaan' => $validated['nama_perusahaan_baru'],
            ]);
            $idPerusahaan = $newCompanyId;
        }

        $user = User::findOrFail($id_user);
        $old_id_user = $user->id_user;
        $new_id_user = $validated['id_user'];
        
        $updateData = [
            'nama_user' => $validated['nama_user'],
            'role' => $validated['role'],
            'id_perusahaan' => $idPerusahaan,
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        DB::transaction(function() use ($user, $old_id_user, $new_id_user, $updateData) {
            if ($old_id_user !== $new_id_user) {
                if (DB::getDriverName() === 'sqlite') {
                    DB::statement('PRAGMA foreign_keys = OFF;');
                } else {
                    DB::statement('SET FOREIGN_KEY_CHECKS=0;');
                }

                // Update related tables: logbook, dokumen_logbook, verifikasi
                DB::table('logbook')->where('id_user', $old_id_user)->update(['id_user' => $new_id_user]);
                DB::table('dokumen_logbook')->where('id_user', $old_id_user)->update(['id_user' => $new_id_user]);
                if (\Illuminate\Support\Facades\Schema::hasTable('verifikasi')) {
                    DB::table('verifikasi')->where('id_user', $old_id_user)->update(['id_user' => $new_id_user]);
                }

                // Update user table
                $updateData['id_user'] = $new_id_user;
                DB::table('user')->where('id_user', $old_id_user)->update($updateData);

                if (DB::getDriverName() === 'sqlite') {
                    DB::statement('PRAGMA foreign_keys = ON;');
                } else {
                    DB::statement('SET FOREIGN_KEY_CHECKS=1;');
                }

                $user->id_user = $new_id_user;
            } else {
                $user->update($updateData);
            }
        });

        $user->load('perusahaan');

        return response()->json(['success' => true, 'data' => $user]);
    }

    public function deleteUser($id_user)
    {
        $user = User::findOrFail($id_user);
        $perusahaanId = $user->id_perusahaan;

        // Delete related PDF files physically from server and delete record explicitly
        $documents = DokumenLogbook::where('id_user', $id_user)->get();
        foreach ($documents as $doc) {
            if (!empty($doc->file_path)) {
                $filePath = public_path($doc->file_path);
                if (file_exists($oldFilePath = $filePath)) {
                    unlink($oldFilePath);
                }
            }
            $doc->delete();
        }

        // Delete verifications and logbooks
        if (\Illuminate\Support\Facades\Schema::hasTable('verifikasi')) {
            $user->verifications()->delete();
        }
        foreach ($user->logbooks as $log) {
            $log->detailPemakaians()->delete();
            $log->delete();
        }

        $user->delete();

        // Clean up company if it no longer has any vessels or users associated with it
        if ($perusahaanId) {
            $otherShipsCount = Kapal::where('id_perusahaan', $perusahaanId)->count();
            $usersCount = User::where('id_perusahaan', $perusahaanId)->count();
            if ($otherShipsCount === 0 && $usersCount === 0) {
                Perusahaan::where('id_perusahaan', $perusahaanId)->delete();
            }
        }

        return response()->json(['success' => true]);
    }

    public function storeOrUpdateCatatanPdf(Request $request)
    {
        $validated = $request->validate([
            'id_dokumen' => 'nullable|integer',
            'kode_vessel' => 'required|string|exists:kapal,kode_vessel',
            'month' => 'required|integer|min:1|max:12',
            'year' => 'required|integer|min:2024|max:2030',
            'catatan_pertamina' => 'nullable|string',
        ]);

        $dateStr = sprintf('%04d-%02d-01', $validated['year'], $validated['month']);

        if (!empty($validated['id_dokumen'])) {
            $dokumen = DokumenLogbook::findOrFail($validated['id_dokumen']);
        } else {
            // Find if there is an existing document for this vessel and period
            $dokumen = DokumenLogbook::where('kode_vessel', $validated['kode_vessel'])
                ->where('tanggal_logbook', $dateStr)
                ->first();
            
            if (!$dokumen) {
                // Find crew user from logbook
                $latestLog = Logbook::where('kode_vessel', $validated['kode_vessel'])
                    ->orderBy('tanggal_pencatatan', 'desc')
                    ->first();
                $crewUserId = $latestLog ? $latestLog->id_user : null;

                if (!$crewUserId) {
                    // Fallback to first awak kapal user
                    $fallbackUser = User::where('role', 'awak_kapal')->first();
                    $crewUserId = $fallbackUser ? $fallbackUser->id_user : 'AK001';
                }

                $dokumen = new DokumenLogbook();
                $dokumen->kode_vessel = $validated['kode_vessel'];
                $dokumen->tanggal_logbook = $dateStr;
                $dokumen->id_user = $crewUserId;
                $dokumen->file_path = ''; // Empty since file is not uploaded yet
                $dokumen->nama_file_original = ''; // Empty
            }
        }

        $dokumen->catatan_pertamina = $validated['catatan_pertamina'];
        $dokumen->save();

        return response()->json([
            'success' => true,
            'message' => 'Catatan berhasil dikirim ke awak kapal.',
            'data' => $dokumen
        ]);
    }
}
