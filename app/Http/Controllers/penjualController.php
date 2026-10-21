<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\penjual;

class penjualController extends Controller
{
        public function store(Request $request) {
        // Validasi input
        $request->validate([
            'Id_Kategori' => 'required|exists:kategoris,Id_Kategori',
            'Nama_Penjual' => 'required|string|max:255',
            'Deskripsi' => 'nullable|string',
            'Alamat_Penjual' => 'required|string|max:255',
            'No_Telp_Penjual' => 'required|string|max:15',
        ], ['id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
            'id_kategori.required' => 'Kategori harus dipilih.',
            'Nama_Penjual.required' => 'Nama Penjual harus diisi.',
            'Deskripsi.required' => 'Deskripsi harus diisi.',
            'Alamat_Penjual.required' => 'Alamat Penjual harus diisi.',
            'No_Telp_Penjual.required' => 'Nomor Telepon Penjual harus diisi.',
        ]);

        // Simpan data penjual ke database
        Penjual::updateOrCreate(
            ['Id_Penjual' => Auth::id()], // Gunakan Id_Penjual dari pengguna yang sedang login
            [
                'Id_Kategori' => $request->Id_Kategori,
                'Nama_Penjual' => $request->Nama_Penjual,
                'Deskripsi' => $request->Deskripsi,
                'Alamat_Penjual' => $request->Alamat_Penjual,
                'No_Telp_Penjual' => $request->No_Telp_Penjual,
            ]
        );

        // Redirect ke halaman home setelah berhasil menyimpan penjual
        return redirect()->route('homePenjual')->with('success', 'Toko berhasil disimpan!');
    }
}
