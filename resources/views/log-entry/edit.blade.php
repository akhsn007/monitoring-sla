{{-- resources/views/log-entry/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Log Gangguan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                    <ul class="pl-5 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('log-entry.update', $log_entry->id) }}"
                class="p-6 space-y-4 bg-white shadow-md rounded-xl">
                @csrf
                @method('PUT')

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-600">Nama Klien</label>
                    <input type="text" name="client_name" value="{{ old('client_name', $log_entry->client_name) }}"
                        class="w-full px-3 py-2 border rounded" required>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-600">IP Address</label>
                    <input type="text" name="ip_address" value="{{ old('ip_address', $log_entry->ip_address) }}"
                        class="w-full px-3 py-2 border rounded" required>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-600">Root Cause</label>
                    <select name="root_cause" class="w-full px-3 py-2 border rounded" required>
                        @foreach (['Koneksi Terputus', 'Perangkat Mati', 'Masalah Listrik', 'Serangan DDoS', 'CPU Tinggi', 'Memori Penuh', 'Lainnya'] as $cause)
                            <option value="{{ $cause }}"
                                {{ $log_entry->root_cause === $cause ? 'selected' : '' }}>{{ $cause }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block mb-1 text-sm font-medium text-slate-600">Status</label>
                    <select name="status" class="w-full px-3 py-2 border rounded" required>
                        <option value="Up" {{ $log_entry->status === 'Up' ? 'selected' : '' }}>Up</option>
                        <option value="Down" {{ $log_entry->status === 'Down' ? 'selected' : '' }}>Down</option>
                    </select>
                </div>

                <button type="submit" class="px-4 py-2 text-white bg-blue-600 rounded hover:bg-blue-700">
                    💾 Simpan Perubahan
                </button>
                <a href="{{ route('log-entry.index') }}"
                    class="inline-block px-4 py-2 ml-2 text-gray-800 bg-gray-200 rounded hover:bg-gray-300">
                    ↩️ Kembali
            </form>
        </div>
    </div>
</x-app-layout>
