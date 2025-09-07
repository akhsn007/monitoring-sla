<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Tambah Log Baru') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
                <div class="p-4 mb-4 text-red-700 bg-red-100 rounded">
                    <ul class="pl-5 list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="p-6 bg-white shadow-md rounded-xl">
                <form method="POST" action="{{ route('log-entry.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-600">Nama Klien</label>
                        <input type="text" name="client_name" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-600">IP Address</label>
                        <input type="text" name="ip_address" class="w-full px-3 py-2 border rounded" required>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-slate-600">Root Cause</label>
                        <select name="root_cause" class="w-full px-3 py-2 border rounded" required>
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
                        <label class="block mb-1 text-sm font-medium text-slate-600">Status</label>
                        <select name="status" class="w-full px-3 py-2 border rounded" required>
                            <option value="Down">Down</option>
                            <option value="Up">Up</option>
                        </select>
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                            class="px-6 py-2 font-semibold text-white bg-blue-600 rounded shadow hover:bg-blue-700">
                            💾 Simpan
                        </button>
                        <a href="{{ route('log-entry.index') }}"
                            class="inline-block px-4 py-2 ml-2 text-gray-800 bg-gray-200 rounded hover:bg-gray-300">
                            ↩️ Kembali
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
