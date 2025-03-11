@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-5xl mx-auto">
        <div class="bg-white rounded-lg shadow-md">
            <div class="p-6">
                <h2 class="text-2xl font-bold mb-6">Riwayat Peminjaman Buku</h2>

                @if($peminjaman->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500">Belum ada riwayat peminjaman buku.</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Buku
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Pinjam
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Tanggal Kembali
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status
                                    </th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Catatan
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($peminjaman as $pinjam)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                @if($pinjam->book->thumbnail_path)
                                                    <img src="{{ $pinjam->book->thumbnail_url }}" 
                                                         alt="{{ $pinjam->book->judul }}" 
                                                         class="w-10 h-14 object-cover rounded mr-3">
                                                @endif
                                                <div class="text-sm">
                                                    <p class="font-medium text-gray-900">{{ $pinjam->book->judul }}</p>
                                                    <p class="text-gray-500">Tahun: {{ $pinjam->book->tahun_terbit }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pinjam->tanggal_pinjam->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $pinjam->tanggal_kembali->format('d M Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                {{ $pinjam->status === 'menunggu' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $pinjam->status === 'disetujui' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $pinjam->status === 'dipinjam' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $pinjam->status === 'dikembalikan' ? 'bg-gray-100 text-gray-800' : '' }}
                                                {{ $pinjam->status === 'ditolak' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $pinjam->status === 'terlambat' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ ucfirst($pinjam->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $pinjam->catatan ?? '-' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="mt-4">
                        {{ $peminjaman->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
