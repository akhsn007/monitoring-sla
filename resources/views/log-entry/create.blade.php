<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Log Baru') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-4 mb-4 rounded">
                    <ul class="list-disc pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white p-6 rounded-xl shadow-md">
                <form method="POST" action="{{ route('log-entry.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Nama Klien</label>
                        <input type="text" name="client_name" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">IP Address</label>
                        <input type="text" name="ip_address" class="w-full border rounded px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Root Cause</label>
                        <select name="root_cause" class="w-full border rounded px-3 py-2" required>
                            <option value="">Pilih</option>
                            <option value="Koneksi Terputus">Koneksi Terputus</option>
                            <option value="Perangkat Mati">Perangkat Mati</option>
                            <option value="Masalah Listrik">Masalah Listrik</option>
                            <option value="Serangan DDoS">Serangan DDoS</option>
                            <option value="CPU Tinggi">CPU Tinggi</option>
                            <option value="Memori Penuh">Memori Penuh</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-600 mb-1">Status</label>
                        <select name="status" class="w-full border rounded px-3 py-2" required>
                            <option value="down">Down</option>
                            <option value="up">Up</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow">
                            💾 Simpan
                        </button>
                        <a href="{{ route('log-entry.index') }}" class="inline-block ml-2 px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">
                            ↩️ Kembali
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
