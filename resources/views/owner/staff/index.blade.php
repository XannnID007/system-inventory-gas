@extends('layouts.app')

@section('title', 'Kelola Staff')
@section('page-title', 'Kelola Staff/Pegawai')
@section('page-subtitle', 'Manajemen akun staff dan pegawai')

@section('content')
    <div class="space-y-6">

        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-2xl font-bold text-gray-900 mb-1">Daftar Staff</h3>
                <p class="text-gray-600 text-sm">Total {{ $staff->total() }} staff terdaftar</p>
            </div>
            <a href="{{ route('owner.staff.create') }}"
                class="px-6 py-3 gradient-purple text-white font-bold rounded-xl hover:shadow-lg hover:shadow-purple-500/50 transition-all flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Tambah Staff
            </a>
        </div>

        <!-- Staff List -->
        <div class="glass-white rounded-2xl shadow-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gradient-to-r from-purple-50 to-pink-50">
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Staff
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Email
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Telepon
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">
                                Bergabung</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($staff as $item)
                            <tr class="hover:bg-purple-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($item->foto)
                                            <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}"
                                                class="w-12 h-12 rounded-full object-cover border-2 border-purple-200">
                                        @else
                                            <div
                                                class="w-12 h-12 gradient-cyan rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                                {{ strtoupper(substr($item->nama, 0, 2)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-bold text-gray-900">{{ $item->nama }}</p>
                                            <span
                                                class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">Staff</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-900 font-semibold">{{ $item->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-700">{{ $item->telepon ?? '-' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-gray-900">{{ $item->created_at->format('d/m/Y') }}</p>
                                    <p class="text-xs text-gray-500">{{ $item->created_at->diffForHumans() }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('owner.staff.edit', $item->id) }}"
                                            class="p-2 bg-blue-100 hover:bg-blue-200 text-blue-600 rounded-lg transition-colors"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('owner.staff.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus staff ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg transition-colors"
                                                title="Hapus">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-gray-500 font-semibold text-lg mb-2">Belum ada staff</p>
                                    <p class="text-gray-400 mb-4">Tambahkan staff pertama Anda</p>
                                    <a href="{{ route('owner.staff.create') }}"
                                        class="inline-flex items-center gap-2 px-6 py-3 gradient-purple text-white font-semibold rounded-xl hover:shadow-lg transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                        Tambah Staff
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($staff->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $staff->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection
