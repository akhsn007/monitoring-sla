{{-- resources/views/log-entry/index.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Log Gangguan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Notifikasi sukses --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

{{-- Tombol Aksi --}}
<div class="mb-4 flex flex-wrap gap-2 items-center">
    {{-- Tombol Tambah Log --}}
    <a href="{{ route('log-entry.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
        ➕ Tambah Log
    </a>

    {{-- Tombol Import dari PRTG --}}
    <form action="{{ route('log-entry.import-prtg') }}" method="POST">
        @csrf
        <button type="submit" 
            class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            🔄 Import dari PRTG
        </button>
    </form>

    {{-- Tombol Hapus Semua --}}
    <form action="{{ route('log-entry.delete-all') }}" method="POST">
    @csrf
    <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
        🗑 Hapus Semua
    </button>
</form>
</div>


            {{-- Tabel Log --}}
            <div class="bg-white overflow-hidden shadow-md rounded-lg">
                <table class="w-full text-sm text-left border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3">Nama Klien</th>
                            <th class="p-3">IP Address</th>
                            <th class="p-3">Root Cause</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                        <tr class="border-t">
                            <td class="p-3">{{ $log->client_name }}</td>
                            <td class="p-3">{{ $log->ip_address }}</td>
                            <td class="p-3">{{ $log->root_cause }}</td>
                            <td class="p-3 text-{{ $log->status === 'down' ? 'red' : 'green' }}-600 font-bold">
                                {{ ucfirst($log->status) }}
                            </td>
                            <td class="p-3 flex flex-wrap gap-2">
                                <a href="{{ route('log-entry.edit', $log->id) }}"
                                   class="inline-block px-3 py-1 text-blue-600 bg-blue-50 rounded hover:bg-blue-100">
                                    ✏️ Edit
                                </a>
                                <form action="{{ route('log-entry.destroy', $log->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin ingin menghapus log ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-block px-3 py-1 text-red-600 bg-red-50 rounded hover:bg-red-100">
                                        🗑️ Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">Belum ada data log.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
