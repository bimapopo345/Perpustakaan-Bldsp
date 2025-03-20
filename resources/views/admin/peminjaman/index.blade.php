@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold">Daftar Peminjaman</h2>
                <div>
                    <label class="text-sm text-gray-600">Filter Status:</label>
                    <select onchange="window.location.href=this.value" class="ml-2 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'all']) }}" {{ request('status') === 'all' ? 'selected' : '' }}>Semua</option>
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'menunggu']) }}" {{ request('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'disetujui']) }}" {{ request('status') === 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'dipinjam']) }}" {{ request('status') === 'dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'menunggu_konfirmasi_kembali']) }}" {{ request('status') === 'menunggu_konfirmasi_kembali' ? 'selected' : '' }}>Menunggu Konfirmasi Kembali</option>
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'dikembalikan']) }}" {{ request('status') === 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'ditolak']) }}" {{ request('status') === 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                        <option value="{{ route('admin.peminjaman.index', ['status' => 'terlambat']) }}" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            @if($peminjaman->isEmpty())
                <div class="text-center py-8">
                    <p class="text-gray-500">Tidak ada data peminjaman.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Member
                                </th>
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
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($peminjaman as $pinjam)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm">
                                            <p class="font-medium text-gray-900">{{ $pinjam->user->name }}</p>
                                            <p class="text-gray-500">{{ $pinjam->user->email }}</p>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($pinjam->book->thumbnail_path)
                                                <img src="{{ asset('storage/' . $pinjam->book->thumbnail_path) }}" 
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
                                            {{ $pinjam->status === 'menunggu_konfirmasi_kembali' ? 'bg-purple-100 text-purple-800' : '' }}
                                            {{ $pinjam->status === 'dikembalikan' ? 'bg-gray-100 text-gray-800' : '' }}
                                            {{ $pinjam->status === 'ditolak' ? 'bg-red-100 text-red-800' : '' }}
                                            {{ $pinjam->status === 'terlambat' ? 'bg-red-100 text-red-800' : '' }}">
                                            {{ str_replace('_', ' ', ucfirst($pinjam->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <div class="flex items-center space-x-2">
                                            @if($pinjam->status === 'menunggu')
                                                <form action="{{ route('admin.peminjaman.approve', $pinjam->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="text-blue-600 hover:text-blue-900">
                                                        Setujui
                                                    </button>
                                                </form>
                                                <span class="text-gray-300">|</span>
                                                <button onclick="showRejectModal({{ $pinjam->id }})" 
                                                        class="text-red-600 hover:text-red-900">
                                                    Tolak
                                                </button>
                                            @endif

                                            @if($pinjam->status === 'menunggu_konfirmasi_kembali')
                                                <form action="{{ route('admin.peminjaman.confirm-return', $pinjam->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="text-green-600 hover:text-green-900"
                                                            onclick="return confirm('Konfirmasi pengembalian buku ini?')">
                                                        Konfirmasi Pengembalian
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
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

<!-- Modal Tolak Peminjaman -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center">
    <div class="bg-white rounded-lg p-6 w-96">
        <h3 class="text-lg font-bold mb-4">Konfirmasi Penolakan</h3>
        <p class="text-gray-600 mb-4">Apakah Anda yakin ingin menolak peminjaman ini?</p>
        <form id="rejectForm" action="" method="POST" class="flex justify-end space-x-2">
            @csrf
            <button type="button" 
                    onclick="hideRejectModal()"
                    class="inline-flex justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Batal
            </button>
            <button type="submit"
                    class="inline-flex justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Ya, Tolak
            </button>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function showRejectModal(id) {
        const modal = document.getElementById('rejectModal');
        const form = document.getElementById('rejectForm');
        form.action = "/admin/peminjaman/" + id + "/reject";
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideRejectModal() {
        const modal = document.getElementById('rejectModal');
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }

    // Close modal when clicking outside
    document.getElementById('rejectModal').addEventListener('click', function(e) {
        if (e.target === this) {
            hideRejectModal();
        }
    });
</script>
@endpush
@endsection
