{{-- resources/views/log-entry/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Log Gangguan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('log-entry.update', $log_entry->id) }}" class="bg-white p-6 rounded-xl shadow-md space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Nama Klien</label>
                    <input type="text" name="client_name" value="{{ old('client_name', $log_entry->client_name) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">IP Address</label>
                    <input type="text" name="ip_address" value="{{ old('ip_address', $log_entry->ip_address) }}" class="w-full border rounded px-3 py-2" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Root Cause</label>
                    <select name="root_cause" class="w-full border rounded px-3 py-2" required>
                        @foreach(['Koneksi Terputus', 'Perangkat Mati', 'Masalah Listrik', 'Serangan DDoS', 'CPU Tinggi', 'Memori Penuh', 'Lainnya'] as $cause)
                            <option value="{{ $cause }}" {{ $log_entry->root_cause === $cause ? 'selected' : '' }}>{{ $cause }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                    <select name="status" class="w-full border rounded px-3 py-2" required>
                        <option value="up" {{ $log_entry->status === 'up' ? 'selected' : '' }}>Up</option>
                        <option value="down" {{ $log_entry->status === 'down' ? 'selected' : '' }}>Down</option>
                    </select>
                </div>

                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    💾 Simpan Perubahan
                </button>
                <a href="{{ route('log-entry.index') }}" class="inline-block ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                    ↩️ Kembali
            </form>
        </div>
    </div>
</x-app-layout>
