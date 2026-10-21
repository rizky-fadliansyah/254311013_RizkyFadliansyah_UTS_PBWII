@extends('layouts.app')
@section('title', 'Kelola Kategori')

@section('content')
<div class="max-w-4xl mx-auto my-8 p-6 bg-white rounded-2xl shadow-sm border border-[#dde1ea]">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">Kelola Kategori Toko</h1>

        <form action="{{ route('auth.logout') }}" method="POST">
            @csrf
            <button type="submit" class="px-4 py-2 bg-red-500 text-white text-sm font-bold rounded-lg hover:bg-red-600 transition-colors">
                Logout &rarr;
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Form Tambah Kategori -->
    <form action="{{ route('kategori.store') }}" method="POST" class="mb-8 p-4 bg-gray-50 rounded-xl border border-gray-200">
        @csrf
        <h2 class="text-lg font-bold mb-3">Tambah Kategori Baru</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
            <div>
                <input type="text" name="Nama_Kategori" placeholder="Nama Kategori" required
                       class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-[#2878eb]">
            </div>
            <div>
                <input type="text" name="Deskripsi_Kategori" placeholder="Deskripsi Singkat"
                       class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-[#2878eb]">
            </div>
            <div>
                <input type="number" name="jumlah_produk" placeholder="Jumlah Produk"
                       class="w-full px-3 py-2 border rounded-lg text-sm outline-none focus:border-[#2878eb]">
            </div>
        </div>
        <button type="submit" class="px-4 py-2 bg-[#2878eb] text-white rounded-lg text-sm font-bold hover:bg-blue-600">
            + Tambah Kategori
        </button>
    </form>

    <!-- Tabel Daftar Kategori -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-100 border-b">
                <tr>
                    <th class="p-3">ID</th>
                    <th class="p-3">Nama Kategori</th>
                    <th class="p-3">Deskripsi</th>
                    <th class="p-3">Jumlah Produk</th>
                    <th class="p-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoriList as $k)
                    <tr class="border-b">
                        <td class="p-3 font-semibold">{{ $k->Id_Kategori }}</td>
                        <td class="p-3 font-bold text-[#2878eb]">{{ $k->Nama_Kategori }}</td>
                        <td class="p-3 text-gray-500">{{ $k->Deskripsi_Kategori ?? '-' }}</td>
                        <td class="p-3 text-gray-500">{{ $k->jumlah_produk ?? 0 }}</td>
                        <td class="p-3 text-center flex justify-center gap-2">
                            <!-- Tombol Edit -->
                            <a href="{{ route('kategori.edit', $k->Id_Kategori) }}" 
                               class="px-3 py-1 bg-amber-500 text-white rounded-md text-xs font-bold hover:bg-amber-600">
                                Edit
                            </a>

                            <!-- Tombol Hapus -->
                            <form action="{{ route('kategori.destroy', $k->Id_Kategori) }}" method="POST" 
                                  onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded-md text-xs font-bold hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="p-4 text-center text-gray-400">Belum ada kategori.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection