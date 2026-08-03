<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kapal;
use App\Models\Logbook;
use App\Models\DetailPemakaian;
use App\Models\Verifikasi;
use App\Models\JadwalPerjalanan;
use App\Models\Pelabuhan;
use App\Models\User;
use App\Models\DokumenLogbook;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AwakController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        
        // Find latest vessel from logbooks, fallback to first ship or session
        $latestLog = Logbook::where('id_user', $user->id_user)
            ->orderBy('tanggal_pencatatan', 'desc')
            ->first();
        
        $vesselCode = session('active_vessel_code') ?? ($latestLog ? $latestLog->kode_vessel : null);
        $vessel = $vesselCode ? Kapal::find($vesselCode) : null;
        if (!$vessel) {
            $vessel = Kapal::first();
        }

        // Logbook terisi dari 1 Januari sampai hari ini
        $logbookYearCount = Logbook::where('id_user', $user->id_user)
            ->whereYear('tanggal_pencatatan', date('Y'))
            ->whereDate('tanggal_pencatatan', '<=', date('Y-m-d'))
            ->count();
        
        $startOfYear = \Carbon\Carbon::now()->startOfYear();
        $today = \Carbon\Carbon::today();
        $totalDaysSinceJan1 = $startOfYear->diffInDays($today);
        $todayFormatted = $today->translatedFormat('d F Y');

        $crewFilledPercentage = $totalDaysSinceJan1 > 0 ? round(($logbookYearCount / $totalDaysSinceJan1) * 100, 1) : 0;
        $crewFilledPercentage = min(100, $crewFilledPercentage);
        $crewStatusPercentages = [$crewFilledPercentage, max(0, 100 - $crewFilledPercentage)];

        // Check if logbook is filled today
        $hasLogbookToday = Logbook::where('id_user', $user->id_user)
            ->whereDate('tanggal_pencatatan', date('Y-m-d'))
            ->exists();
        $logbookTodayCount = $hasLogbookToday ? 1 : 0;
        
        // Find missing logbook range
        $missingRangeText = '';
        if (!$hasLogbookToday) {
            if ($latestLog) {
                $latestDate = \Carbon\Carbon::parse($latestLog->tanggal_pencatatan);
                $missingStart = $latestDate->copy()->addDay();
                $missingEnd = $today;
                if ($missingStart->gt($missingEnd)) {
                    $missingStart = $today;
                }
            } else {
                $missingStart = $startOfYear->copy();
                $missingEnd = $today;
            }

            if ($missingStart->equalTo($missingEnd)) {
                $missingRangeText = 'pada tanggal ' . $missingStart->translatedFormat('d F Y');
            } else {
                $missingRangeText = 'dari tanggal ' . $missingStart->translatedFormat('d F Y') . ' sampai ' . $missingEnd->translatedFormat('d F Y');
            }
        }

        // Total BBM consumption for the crew's ship
        $totalBBM = DetailPemakaian::whereHas('logbook', function($q) use ($user) {
            $q->where('id_user', $user->id_user);
        })->sum('total');

        // Latest logbook verification status
        $latestVerifStatus = 'No Logbook';
        if ($latestLog) {
            $latestVerifStatus = $latestLog->statusPengisian ? $latestLog->statusPengisian->nama_status : 'Pending';
        }

        // Active journey for the ship (no longer exists in DB, mocked to null)
        $activeJourney = null;

        // 5 latest logbooks
        $latestLogbooks = Logbook::with(['detailPemakaians', 'statusPengisian'])
            ->where('id_user', $user->id_user)
            ->orderBy('tanggal_pencatatan', 'desc')
            ->limit(5)
            ->get();

        return view('awak.dashboard', compact(
            'user', 'vessel', 'logbookYearCount', 'totalDaysSinceJan1', 'logbookTodayCount', 'totalBBM', 
            'latestVerifStatus', 'activeJourney', 'latestLogbooks', 'missingRangeText', 'todayFormatted',
            'crewStatusPercentages', 'crewFilledPercentage'
        ));
    }

    public function riwayat()
    {
        $user = Auth::user();
        
        // Fetch logbooks of this user with pagination (15 records per page)
        $logbooks = Logbook::with(['detailPemakaians', 'statusPengisian'])
            ->where('id_user', $user->id_user)
            ->orderBy('tanggal_pencatatan', 'desc')
            ->paginate(15);

        return view('awak.riwayat', compact('logbooks'));
    }

    public function createLogbook(Request $request)
    {
        $vessels = Kapal::with('perusahaan')->get();
        $companies = \App\Models\Perusahaan::orderBy('nama_perusahaan', 'asc')->get();
        $voyageId = $request->query('voyage_id');
        $selectedVoyage = null;
        
        return view('awak.logbook.create', compact('vessels', 'companies', 'selectedVoyage', 'voyageId'));
    }

    public function storeLogbook(Request $request)
    {
        $user = Auth::id();
        
        DB::transaction(function() use ($request, $user) {
            $logbook = Logbook::create([
                'id_user' => $user,
                'kode_vessel' => $request->kapal,
                'tanggal_pencatatan' => $request->tanggal,
                'catatan' => $request->catatan,
                'id_status' => 2, // 'Verified'
            ]);

            $ship = Kapal::where('kode_vessel', $request->kapal)->first();
            $idFtit = $ship ? $ship->id_ftit : 'FT01';

            $kemarin = $request->input('fo_sisa_kemarin') ?: 0;
            $induk = $request->input('fo_motor_induk') ?: 0;
            $bantu = $request->input('fo_motor_bantu') ?: 0;
            $lain = $request->input('fo_lain_lain') ?: 0;
            $tambah = $request->input('fo_ditambah') ?: 0;
            $sekarang = $request->input('fo_sisa_sekarang') ?: 0;
            $jumlahSekarang = $request->input('fo_jumlah_sekarang') ?: 0;

            $manual_total = $request->input('fo_total_penggunaan') ?: ($induk + $bantu + $lain);
            $sys_total_penggunaan = $induk + $bantu + $lain;
            $sys_sisa_sekarang = $kemarin - $sys_total_penggunaan;
            $sys_jumlah_sekarang = $sys_sisa_sekarang + $tambah;

            // Get previous logbook to find sisakemarin_seharusnya
            $latestLog = Logbook::where('kode_vessel', $request->kapal)
                ->where('id_logbook', '!=', $logbook->id_logbook)
                ->orderBy('tanggal_pencatatan', 'desc')
                ->first();
            $latestDetail = $latestLog ? DetailPemakaian::where('id_logbook', $latestLog->id_logbook)->first() : null;
            $sys_kemarin = $latestDetail ? $latestDetail->sisa_sekarang : $kemarin;

            DetailPemakaian::create([
                'id_logbook' => $logbook->id_logbook,
                'id_ftit' => $idFtit,
                'sisa_kemarin' => $kemarin,
                'mesin_induk' => $induk,
                'mesin_bantu' => $bantu,
                'lain_lain' => $lain,
                'total' => $manual_total,
                'sisa_sekarang' => $sekarang,
                'ditambah' => $tambah,
                'jumlah' => $jumlahSekarang,
                'sisakemarin_seharusnya' => $sys_kemarin,
                'total_seharusnya' => $sys_total_penggunaan,
                'sisasekarang_seharusnya' => $sys_sisa_sekarang,
                'ditambah_seharusnya' => $tambah,
                'jumlah_seharusnya' => $sys_jumlah_sekarang,
            ]);
        });

        session(['active_vessel_code' => $request->kapal]);

        return response()->json(['success' => true]);
    }

    public function updateLogbook(Request $request, $id)
    {
        DB::transaction(function() use ($request, $id) {
            $logbook = Logbook::findOrFail($id);
            $logbook->catatan = $request->catatan;
            $logbook->id_status = 2; // Verified
            $logbook->save();

            $detail = DetailPemakaian::where('id_logbook', $id)->first();
            if (!$detail) {
                $detail = new DetailPemakaian();
                $detail->id_logbook = $id;
                $ship = Kapal::where('kode_vessel', $logbook->kode_vessel)->first();
                $detail->id_ftit = $ship ? $ship->id_ftit : 'FT01';
            }

            $kemarin = $request->input('fo_kemarin') ?: 0;
            $induk = $request->input('fo_induk') ?: 0;
            $bantu = $request->input('fo_bantu') ?: 0;
            $lain = $request->input('fo_lain') ?: 0;
            $tambah = $request->input('fo_tambah') ?: 0;
            $sekarang = $request->input('fo_sekarang') ?: 0;
            $jumlahSekarang = $request->input('fo_jumlah') ?: 0;

            $manual_total = $request->input('fo_total') ?: ($induk + $bantu + $lain);
            $sys_total_penggunaan = $induk + $bantu + $lain;
            $sys_sisa_sekarang = $kemarin - $sys_total_penggunaan;
            $sys_jumlah_sekarang = $sys_sisa_sekarang + $tambah;

            // Get previous logbook to find sisakemarin_seharusnya
            $latestLog = Logbook::where('kode_vessel', $logbook->kode_vessel)
                ->where('id_logbook', '!=', $logbook->id_logbook)
                ->orderBy('tanggal_pencatatan', 'desc')
                ->first();
            $latestDetail = $latestLog ? DetailPemakaian::where('id_logbook', $latestLog->id_logbook)->first() : null;
            $sys_kemarin = $latestDetail ? $latestDetail->sisa_sekarang : $kemarin;

            $detail->sisa_kemarin = $kemarin;
            $detail->mesin_induk = $induk;
            $detail->mesin_bantu = $bantu;
            $detail->lain_lain = $lain;
            $detail->total = $manual_total;
            $detail->sisa_sekarang = $sekarang;
            $detail->ditambah = $tambah;
            $detail->jumlah = $jumlahSekarang;
            $detail->sisakemarin_seharusnya = $sys_kemarin;
            $detail->total_seharusnya = $sys_total_penggunaan;
            $detail->sisasekarang_seharusnya = $sys_sisa_sekarang;
            $detail->ditambah_seharusnya = $tambah;
            $detail->jumlah_seharusnya = $sys_jumlah_sekarang;
            $detail->save();
        });

        return response()->json(['success' => true]);
    }

    public function deleteLogbook($id)
    {
        DB::transaction(function() use ($id) {
            DetailPemakaian::where('id_logbook', $id)->delete();
            Logbook::where('id_logbook', $id)->delete();
        });

        return response()->json(['success' => true]);
    }

    public function profil()
    {
        $user = Auth::user();
        
        // Find crew's ship
        $latestLog = Logbook::with('detailPemakaians')
            ->where('id_user', $user->id_user)
            ->orderBy('tanggal_pencatatan', 'desc')
            ->first();
        $vesselCode = session('active_vessel_code') ?? ($latestLog ? $latestLog->kode_vessel : null);
        $vessel = $vesselCode ? Kapal::find($vesselCode) : null;
        if (!$vessel) {
            $vessel = Kapal::first();
        }

        return view('awak.profil', compact('user', 'vessel', 'latestLog'));
    }

    public function indexPdf()
    {
        $user = Auth::user();
        $dokumen = DokumenLogbook::with('kapal')
            ->where('id_user', $user->id_user)
            ->orderBy('tanggal_logbook', 'desc')
            ->get();
        $vessels = Kapal::orderBy('nama_kapal', 'asc')->get();
        return view('awak.upload-pdf', compact('dokumen', 'vessels'));
    }

    public function storePdf(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:20480',
            'kode_vessel' => 'required|exists:kapal,kode_vessel',
            'bulan_logbook' => 'required|integer|min:1|max:12',
            'tahun_logbook' => 'required|integer|min:2024|max:' . ((int)date('Y') + 1),
            'catatan' => 'nullable|string',
        ]);

        $dateStr = sprintf('%04d-%02d-01', $request->tahun_logbook, $request->bulan_logbook);

        $file = $request->file('pdf_file');
        $originalName = $file->getClientOriginalName();
        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $destPath = public_path('uploads/pdf_logbooks');
        if (!file_exists($destPath)) {
            mkdir($destPath, 0755, true);
        }

        $file->move($destPath, $fileName);
        $filePath = 'uploads/pdf_logbooks/' . $fileName;

        // Check if a record already exists for this ship and month/year
        $existing = DokumenLogbook::where('kode_vessel', $request->kode_vessel)
            ->where('tanggal_logbook', $dateStr)
            ->first();

        if ($existing) {
            // Delete the old physical file if it exists
            if (!empty($existing->file_path)) {
                $oldFilePath = public_path($existing->file_path);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
            }

            // Update the existing record and clear the Pertamina note
            $existing->update([
                'id_user' => Auth::id(),
                'file_path' => $filePath,
                'nama_file_original' => $originalName,
                'catatan' => $request->catatan,
                'catatan_pertamina' => null,
            ]);
        } else {
            // Create a new record
            DokumenLogbook::create([
                'id_user' => Auth::id(),
                'kode_vessel' => $request->kode_vessel,
                'tanggal_logbook' => $dateStr,
                'file_path' => $filePath,
                'nama_file_original' => $originalName,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->back()->with('success', 'File PDF Logbook berhasil diunggah!');
    }

    public function deletePdf($id)
    {
        $dokumen = DokumenLogbook::where('id_dokumen', $id)
            ->where('id_user', Auth::id())
            ->firstOrFail();

        $filePath = public_path($dokumen->file_path);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $dokumen->delete();

        return redirect()->back()->with('success', 'File PDF Logbook berhasil dihapus!');
    }
}
