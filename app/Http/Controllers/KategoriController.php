<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriController extends Controller
{
    public function index()
    {

        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses khusus Admin.');
        }

        $kategoriList = Kategori::all();

        return view('admin.kategori', compact('kategoriList'));
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'Nama_Kategori' => 'required|string|max:255',
            'Deskripsi_Kategori' => 'nullable|string',
        ]);

        Kategori::create([
            'Nama_Kategori' => $request->Nama_Kategori,
            'Deskripsi_Kategori' => $request->Deskripsi_Kategori,
        ]);

        return back()->with('success', 'Kategori berhasil ditambahkan!');
    }
    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $kategori = Kategori::findOrFail($id);
        $kategoriList = Kategori::all();

        return view('admin.editKategori', compact('kategori', 'kategoriList'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'Nama_Kategori' => 'required|string|max:255',
            'Deskripsi_Kategori' => 'nullable|string',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'Nama_Kategori' => $request->Nama_Kategori,
            'Deskripsi_Kategori' => $request->Deskripsi_Kategori,
        ]);

        return back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403);
        }

        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}