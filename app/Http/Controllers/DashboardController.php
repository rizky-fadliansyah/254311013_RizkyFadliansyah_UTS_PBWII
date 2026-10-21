<?php

namespace App\Http\Controllers;

use App\Models\penjual;
use App\Models\Kategori;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = penjual::with(['ulasan', 'kategori']);

        if ($request->filled('cari')) {
            $search = $request->input('cari');
            $query->where(function ($q) use ($search) {
                $q->where('Nama_Penjual', 'like', "%{$search}%")
                  ->orWhere('Alamat_Penjual', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('Id_Kategori', $request->input('kategori'));
        }

        $penjualList = $query->get();
        $kategoriList = Kategori::all();

        return view('dashboard', compact('penjualList', 'kategoriList'));
    }
}