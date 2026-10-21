@extends('layouts.app')
@section('title', 'Beranda')

@section('content')
<section class="bg-[linear-gradient(180deg,#82b4ff,#cfc4ff)] rounded-[40px] mx-4 md:mx-10 my-6 px-6 md:px-11 py-12">
    <h1 class="font-['Anton',sans-serif] font-normal text-4xl md:text-[44px] leading-tight">Temukan Penjual<br>Terbaik dari Ulasan Pembeli</h1>
    <p class="text-[#6b7385] mt-2.5 mb-4">Bantu pembeli lain dengan memberikan ulasan jujur.</p>
    
    <!-- Form Pencarian Langsung Mengirim Request GET -->
    <form action="{{ route('dashboard') }}" method="GET" class="flex max-w-[470px]">
        @if(request('kategori'))
            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
        @endif
        <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama penjual atau alamat..."
               class="flex-1 min-w-0 px-4 py-3.5 border border-[#dde1ea] rounded-l-[10px] outline-none bg-white text-sm">
        <button type="submit" class="w-12 bg-[#2878eb] text-white rounded-r-[10px]">⌕</button>
    </form>
</section>

<section id="daftar-penjual" class="px-5 md:px-[55px] pb-12">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-5">
        <div>
            <h2 class="text-[26px] font-bold">Daftar Penjual</h2>
            <p class="text-sm text-[#6b7385]">Pilih penjual lalu isi ulasan tanpa login.</p>
        </div>

        <!-- Filter Kategori dengan Form Submit Otomatis via HTML (Tanpa JS) -->
        <form action="{{ route('dashboard') }}" method="GET" class="flex items-center gap-2">
            @if(request('cari'))
                <input type="hidden" name="cari" value="{{ request('cari') }}">
            @endif
            <label for="filterKategori" class="text-sm font-bold text-[#6b7385]">Kategori:</label>
            <select name="kategori" id="filterKategori" onchange="this.form.submit()" 
                    class="px-3 py-2 border border-[#dde1ea] rounded-xl text-sm outline-none bg-white focus:border-[#2878eb]">
                <option value="">Semua Kategori</option>
                @foreach($kategoriList ?? [] as $k)
                    <option value="{{ $k->Id_Kategori }}" {{ request('kategori') == $k->Id_Kategori ? 'selected' : '' }}>
                        {{ $k->Nama_Kategori }}
                    </option>
                @endforeach
            </select>
            <noscript>
                <button type="submit" class="px-3 py-1.5 bg-[#2878eb] text-white text-xs rounded-lg">Filter</button>
            </noscript>
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10">
        @forelse($penjualList as $i => $p)
            @php $rata = $p->ulasan->avg('Rating') ?? 0; @endphp
            <div class="border border-[#dde1ea] rounded-[40px] p-3 bg-white">
                 
                <!-- Badge Kategori -->
                <div class="mb-2">
                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full bg-[#e8f1ff] text-[#2878eb]">
                        {{ $p->kategori->Nama_Kategori ?? 'Umum' }}
                    </span>
                </div>

                <h3 class="text-base font-bold mt-2 mx-1 mb-2">{{ $p->Nama_Penjual }}</h3>
                <small class="block text-sm text-[#6b7385] mx-1 mb-3.5 line-clamp-1">{{ $p->Alamat_Penjual }}</small>
                <p class="text-[#f5a623] font-['Libre_Baskerville',serif] text-sm mx-1 mb-2.5">
                    ★ {{ number_format($rata, 1) }} ({{ $p->ulasan->count() }} ulasan)
                </p>
                <a href="{{ route('penjual.detail', $p->Id_Penjual) }}"
                   class="block w-full text-center py-2.5 rounded-lg font-bold border border-[#2878eb] text-[#2878eb] bg-white hover:bg-[#2878eb] hover:text-white transition-colors">Lihat Detail</a>
            </div>
        @empty
            <p class="col-span-full py-8 text-center text-[#6b7385]">Penjual tidak ditemukan.</p>
        @endforelse
    </div>
</section>
@endsection