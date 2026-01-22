<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Mobil;
use Illuminate\View\View;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function dashboard(Request $request): View
    {
        $now = Carbon::now();

        $totalMobil = Mobil::count();
        $absensiHariIni = Attendance::whereDate('created_at', today())->count();
        $totalSupplier = User::count();
        $suratBulanIni = Attendance::whereMonth('tanggal_berangkat', $now->month)
            ->whereYear('tanggal_berangkat', $now->year)
            ->count();

        $recentAttendances = Attendance::with('mobil')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // 🔹 Data grafik absensi bulanan
        $chartData = Attendance::select(
            DB::raw('DAY(tanggal_berangkat) as day'),
            DB::raw('count(*) as total')
        )
            ->whereMonth('tanggal_berangkat', now()->month)
            ->whereYear('tanggal_berangkat', now()->year)
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $labels = $chartData->pluck('day');
        $data = $chartData->pluck('total');

        return view('admin.dashboard', compact(
            'totalMobil',
            'absensiHariIni',
            'totalSupplier',
            'suratBulanIni',
            'recentAttendances',
            'labels',
            'data'
        ));
    }
}
