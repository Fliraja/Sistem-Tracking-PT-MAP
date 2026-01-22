<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Mobil;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\View\View;

use function Symfony\Component\Clock\now;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('mobil', 'user');

        switch ($request->filter_type) {
            case 'harian':
                if ($request->date) {
                    $query->whereDate('tanggal_berangkat', $request->date);
                }
                break;

            case 'bulanan':
                if ($request->month) {
                    $month = \Carbon\Carbon::parse($request->month);
                    $query->whereMonth('tanggal_berangkat', $month->month)
                        ->whereYear('tanggal_berangkat', $month->year);
                }
                break;

            case 'mobil':
                if ($request->mobil_id) {
                    $query->where('mobil_id', $request->mobil_id);
                }
                break;

            case 'supplier':
                if ($request->supplier) {
                    $query->where('supplier', 'like', '%' . $request->supplier . '%');
                }
                break;
        }

        $attendances = $query->latest('created_at')->paginate(100);
        $mobils = Mobil::all();
        $users = User::where('role', 'supir')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('attendances.index', compact('attendances', 'mobils', 'users'));
    }

    public function show($id)
    {
        $attendance = Attendance::with('mobil', 'user')->findOrFail($id);
        return view('attendances.show', compact('attendance'));
    }

    public function print($id)
    {
        $attendance = Attendance::with('mobil', 'user')->findOrFail($id);

        $pdf = Pdf::loadView('attendances.print', compact('attendance'))
            ->setPaper([0, 0, 226.77, 600], 'portrait');
        // 226.77pt ≈ 8 cm lebar (thermal)

        return $pdf->stream('surat_jalan_' . $attendance->id . '.pdf');
    }

    public function create()
    {
        $mobils = Mobil::all();
        $users = User::where('role', 'supir')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();

        return view('attendances.create', compact('mobils', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_berangkat' => 'nullable|date',
            'supplier' => 'required|string',
            'tujuan' => 'required|string',
            'panjang' => 'nullable|numeric',
            'lebar' => 'nullable|numeric',
            'tinggi' => 'nullable|numeric',
            'plus' => 'nullable|numeric',
            'volume' => 'nullable|numeric',
            'foto_berangkat' => 'nullable|image|max:2048',
            'foto_sampai' => 'nullable|image|max:2048',
            'status' => 'in:proses,perjalanan,selesai',
        ]);

        // dd($validated); // 🧠 tambahkan ini dulu

        if ($request->hasFile('foto_berangkat')) {
            $validated['foto_berangkat'] = $request->file('foto_berangkat')->store('uploads/foto_berangkat', 'public');
        }
        if ($request->hasFile('foto_sampai')) {
            $validated['foto_sampai'] = $request->file('foto_sampai')->store('uploads/foto_sampai', 'public');
        }

        Attendance::create($validated);

        return redirect()->route('attendances.index')->with('success', 'Data absensi berhasil disimpan!');
    }

    public function edit(Attendance $attendance)
    {
        $mobils = Mobil::all();
        $users = User::where('role', 'supir')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        return view('attendances.edit', compact('attendance', 'mobils', 'users'));
    }


    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'mobil_id' => 'required|exists:mobils,id',
            'user_id' => 'required|exists:users,id',
            'tanggal_berangkat' => 'nullable|date',
            'supplier' => 'required|string',
            'tujuan' => 'required|string',
            'panjang' => 'nullable|numeric',
            'lebar' => 'nullable|numeric',
            'tinggi' => 'nullable|numeric',
            'plus' => 'nullable|numeric',
            'volume' => 'nullable|numeric',
            'status' => 'required|in:proses,perjalanan,selesai',
            'foto_berangkat' => 'nullable|image|max:2048',
            'foto_sampai' => 'nullable|image|max:2048',
        ]);

        // 🖼️ Update foto kalau ada yang baru
        if ($request->hasFile('foto_berangkat')) {
            $path = $request->file('foto_berangkat')->store('uploads/foto_berangkat', 'public');
            $validated['foto_berangkat'] = $path;
        }

        if ($request->hasFile('foto_sampai')) {
            $path = $request->file('foto_sampai')->store('uploads/foto_sampai', 'public');
            $validated['foto_sampai'] = $path;
        }

        $attendance->update($validated);

        return redirect()->route('attendances.index')->with('success', 'Data attendance berhasil diperbarui!');
    }

    public function destroy(Attendance $attendance)
    {
        // // Hapus foto dari storage jika ada
        // if ($attendance->foto_berangkat) {
        //     \Storage::disk('public')->delete($attendance->foto_berangkat);
        // }
        // if ($attendance->foto_sampai) {
        //     \Storage::disk('public')->delete($attendance->foto_sampai);
        // }

        $attendance->delete();

        return redirect()->route('attendances.index')->with('success', 'Data attendance berhasil dihapus!');
    }

    public function exportPdf(Request $request)
    {
        $query = Attendance::with('mobil', 'user');

        switch ($request->filter_type) {
            case 'harian':
                if ($request->date) {
                    $query->whereDate('tanggal_berangkat', $request->date);
                }
                break;

            case 'bulanan':
                if ($request->month) {
                    $month = Carbon::parse($request->month);
                    $query->whereMonth('tanggal_berangkat', $month->month)
                        ->whereYear('tanggal_berangkat', $month->year);
                }
                break;

            case 'mobil':
                if ($request->mobil_id) {
                    $query->where('mobil_id', $request->mobil_id);
                }
                break;

            case 'supplier':
                if ($request->supplier) {
                    $query->where('supplier', 'like', '%' . $request->supplier . '%');
                }
                break;
        }

        $attendances = $query->latest('tanggal_berangkat')->get();

        // Judul laporan dinamis
        $title = 'Laporan Data Absensi';
        if ($request->filter_type) {
            $title .= ' (' . ucfirst($request->filter_type) . ')';
        }

        $pdf = Pdf::loadView('attendances.report', compact('attendances', 'title'))
            ->setPaper('A4', 'portrait');

        return $pdf->stream('laporan_absensi.pdf');
    }

    public function supirDashboard(Request $request): View
    {
        $userId = auth()->id();

        $attendances = Attendance::where('user_id', auth()->id())->orderBy('created_at', 'desc')->take(5)->get();

        $now = Carbon::now();

        $totalTugas = Attendance::where('user_id', $userId)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->count();

        $tugasProses = Attendance::where('user_id', $userId)
            ->where('status', 'proses')
            ->count();

        $tugasPerjalanan = Attendance::where('user_id', $userId)
            ->where('status', 'perjalanan')
            ->count();

        $tugasSelesai = Attendance::where('user_id', $userId)
            ->where('status', 'selesai')
            ->count();

        return view('supir.dashboard', compact(
            'totalTugas',
            'tugasProses',
            'tugasPerjalanan',
            'tugasSelesai',
            'attendances'
        ));
    }

    public function supirIndex(Request $request)
    {
        $query = Attendance::with('mobil')->where('user_id', auth()->id());

        switch ($request->filter_type) {
            case 'harian':
                if ($request->date) {
                    $query->whereDate('tanggal_berangkat', $request->date);
                }
                break;

            case 'bulanan':
                if ($request->month) {
                    $month = \Carbon\Carbon::parse($request->month);
                    $query->whereMonth('tanggal_berangkat', $month->month)
                        ->whereYear('tanggal_berangkat', $month->year);
                }
                break;

            case 'mobil':
                if ($request->mobil_id) {
                    $query->where('mobil_id', $request->mobil_id);
                }
                break;

            case 'supplier':
                if ($request->supplier) {
                    $query->where('supplier', 'like', '%' . $request->supplier . '%');
                }
                break;
        }

        $attendances = $query->latest('created_at')->paginate(100);
        $mobils = Mobil::all();
        return view('attendances.supir.index', compact('attendances', 'mobils'));
    }

    public function supirEdit(Attendance $attendance)
    {
        $mobils = Mobil::all();
        $users = User::where('role', 'supir')
            ->select('id', 'name')
            ->orderBy('name')
            ->get();
        abort_if($attendance->user_id !== auth()->id(), 403);
        return view('attendances.supir.edit', compact('attendance', 'mobils', 'users'));
    }

    public function supirUpdate(Request $request, Attendance $attendance)
    {
        abort_if($attendance->user_id !== auth()->id(), 403);

        if ($attendance->status === 'proses') {
            $request->validate([
                'tanggal_berangkat' => 'required|date',
                'foto_berangkat' => 'required|image',
            ]);

            $attendance->update([
                'tanggal_berangkat' => $request->tanggal_berangkat,
                'foto_berangkat' => $request->file('foto_berangkat')->store('uploads/foto_berangkat', 'public'),
                'status' => 'perjalanan',
            ]);
        } elseif ($attendance->status === 'perjalanan') {
            $request->validate([
                'foto_sampai' => 'required|image',
            ]);

            $attendance->update([
                'foto_sampai' => $request->file('foto_sampai')->store('uploads/foto_sampai', 'public'),
                'status' => 'selesai',
            ]);
        }

        return redirect()->route('supir.attendances.index')->with('success', 'Berhasil diperbarui');
    }
}
