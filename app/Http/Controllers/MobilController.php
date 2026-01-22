<?php

namespace App\Http\Controllers;

use App\Models\Mobil;
use Illuminate\Http\Request;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::latest()->paginate(25);
        return view('mobils.index', compact('mobils'));
    }

    public function create()
    {
        return view('mobils.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'plat' => 'required|unique:mobils,plat',
            'jenis' => 'required',
        ]);

        Mobil::create($request->all());

        return redirect()->route('mobils.index')->with('success', 'Data mobil berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $mobil = Mobil::findOrFail($id);
        return view('mobils.edit', compact('mobil'));
    }

    public function update(Request $request, $id)
    {
        $mobil = Mobil::findOrFail($id);

        $request->validate([
            'plat' => 'required|unique:mobils,plat',
            'jenis' => 'required',
        ]);

        $mobil->update([
            'plat' => $request->plat,
            'jenis' => $request->jenis,
        ]);

        return redirect()->route('mobils.index')->with('success', 'Data mobil berhasil diperbarui!');
    }


    public function destroy(Mobil $mobil)
    {
        $mobil->delete();
        return back()->with('success', 'Data mobil berhasil dihapus!');
    }
}
