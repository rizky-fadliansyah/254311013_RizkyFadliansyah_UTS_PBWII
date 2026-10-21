<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return response()->json($kategoris);
    }
    public function store(Request $request)
    {
        request()->validate([
            'Nama_Kategori' => 'required|string|max:255',
            'Deskripsi_Kategori' => 'required|string|max:255',
        ], [
            'Nama_Kategori.required' => 'Nama Kategori harus diisi.',
            'Nama_Kategori.max' => 'Nama Kategori tidak boleh lebih dari 255 karakter.',
            'Deskripsi_Kategori.required' => 'Deskripsi Kategori harus diisi.',
            'Deskripsi_Kategori.max' => 'Deskripsi Kategori maksimalnya 255 karakter.',
        ]);

        kategori::create($request->all());
        return response()->json(['message' => 'Kategori berhasil ditambahkan.'], 201);
    }
}
