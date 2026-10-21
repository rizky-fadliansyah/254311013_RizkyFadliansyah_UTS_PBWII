<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Penjual;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PenjualController extends Controller
{
    /**
     * Menampilkan dashboard profil penjual.
     */
    public function dashboard(): View
    {
        $penjual = Penjual::find(Auth::id());

        return view('homePenjual', compact('penjual'));
    }

    /**
     * Menampilkan form edit data penjual.
     */
    public function edit(): View
    {
        $penjual = Penjual::find(Auth::id());
        $kategoriList = Kategori::all();

        return view('editPenjual', compact('penjual', 'kategoriList'));
    }

    /**
     * Menampilkan daftar ulasan untuk penjual yang sedang login.
     */
    public function ulasan(): View
    {
        $penjual = Penjual::find(Auth::id());

        return view('ViewUlasan', compact('penjual'));
    }

    /**
     * Menampilkan detail toko penjual berdasarkan ID (Public View).
     */
    public function show(int $id): View
    {
        $penjual = Penjual::findOrFail($id);

        return view('detail', compact('penjual'));
    }

    /**
     * Menyimpan atau memperbarui data profil penjual.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'Id_Kategori'     => ['required', 'exists:kategori,Id_Kategori'],
            'Nama_Penjual'    => ['required', 'string', 'max:255'],
            'Deskripsi'       => ['nullable', 'string'],
            'Alamat_Penjual'  => ['required', 'string', 'max:255'],
            'No_Telp_Penjual' => ['required', 'string', 'max:15'],
        ], [
            'Id_Kategori.required'     => 'Kategori harus dipilih.',
            'Id_Kategori.exists'       => 'Kategori yang dipilih tidak valid.',
            'Nama_Penjual.required'    => 'Nama Penjual harus diisi.',
            'Alamat_Penjual.required'  => 'Alamat Penjual harus diisi.',
            'No_Telp_Penjual.required' => 'Nomor Telepon Penjual harus diisi.',
        ]);

        Penjual::updateOrCreate(
            ['Id_Penjual' => Auth::id()],
            $validatedData
        );

        return redirect()
            ->route('homePenjual')
            ->with('success', 'Toko berhasil disimpan!');
    }
}