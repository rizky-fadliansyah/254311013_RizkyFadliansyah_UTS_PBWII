@extends('layouts.app')
@section('title', 'Edit Kategori')

@section('content')
<div class="max-w-4xl mx-auto my-8 p-6 bg-white rounded-2xl shadow-sm border border-[#dde1ea]">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Edit Kategori Toko</h1>
        <a href="{{ route('kategori.index') }}" class="text-sm text-[#2878eb] font-bold hover:underline">&larr; Kembali</a>
    </div>

    <!-- Form Edit Kategori -->
    <form action="{{ route('kategori.update', $kategori->Id_Kategori) }}" method="POST" class="p-4 bg-amber-50 rounded-xl border border-amber-200 mb-8">
        @csrf
        @method('PUT')
        <h2 class="text-lg font-bold mb-3 text-amber-900">Ubah Data Kategori</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-xs font-bold mb-1 text-gray-600">Nama Kategori</label>
                <input type="text" name="Nama_Kategori" value="{{ old('Nama_Kategori', $kategori->Nama_Kategori) }}" required
                       class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-[#2878eb] bg-white">
            </div>
            <div>
                <label class="block text-xs font-bold mb-1 text-gray-600">Deskripsi Kategori</label>
                <input type="text" name="Deskripsi_Kategori" value="{{ old('Deskripsi_Kategori', $kategori->Deskripsi_Kategori) }}"
                       class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-[#2878eb] bg-white">
            </div>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="px-4 py-2 bg-amber-500 text-white rounded-lg text-sm font-bold hover:bg-amber-600">
                Simpan Perubahan
            </button>
            <a href="{{ route('kategori.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg text-sm font-bold hover:bg-gray-300">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection