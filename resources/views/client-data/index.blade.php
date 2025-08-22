<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Gangguan per Klien') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Tabel --}}
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="p-4">Nama Klien</th>
                            <th class="p-4">Status Jaringan</th>
                            <th class="p-4">Total Gangguan</th>
                            <th class="p-4">Persentase Gangguan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($clients as $client)
                        <tr class="border-b">
                            <td class="p-4">{{ $client->client_name }}</td>
                            <td class="p-4 text-{{ $client->status === 'down' ? 'red' : 'green' }}-600 font-bold">
                                {{ ucfirst($client->status) }}
                            </td>
                            <td class="p-4">{{ $client->total_down }}</td>
                            <td class="p-4">{{ $client->percent }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="p-4 text-center text-gray-500">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pie Chart --}}
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold mb-4">Grafik Status Jaringan</h3>
                <canvas id="clientPieChart" height="100"></canvas>
            </div>

        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pieCtx = document.getElementById('clientPieChart');
        const pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($clients->pluck('client_name')) !!},
                datasets: [{
                    label: 'Persentase Gangguan',
                    data: {!! json_encode($clients->pluck('percent')) !!},
                    backgroundColor: [
                        '#ef4444', '#f97316', '#eab308',
                        '#10b981', '#3b82f6', '#6366f1',
                        '#8b5cf6', '#ec4899', '#f43f5e'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Persentase Gangguan per Klien'
                    }
                }
            }
        });
    </script>
</x-app-layout>
