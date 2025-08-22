<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📊 Rekap SLA Bulanan
        </h2>
    </x-slot>

    <div class="py-6 space-y-8">
        {{-- 1️⃣ Pareto Root Cause di bawah SLA --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">1️⃣ Pareto Root Cause di Bawah SLA</h3>
            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-slate-700 text-white">
                        <tr>
                            <th class="p-3">Nama PT</th>
                            <th class="p-3">Penyebab Terbanyak</th>
                            <th class="p-3">Jumlah Kejadian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($paretoRootCause as $pt => $data)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="p-3">{{ $pt }}</td>
                            <td class="p-3">{{ $data['root_cause'] }}</td>
                            <td class="p-3 text-center">{{ $data['jumlah'] }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="p-3 text-center text-gray-500">Tidak ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 2️⃣ SLA Bulan Terakhir --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">2️⃣ SLA Bulan {{ $months[$month] }} {{ $year }}</h3>
            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead class="bg-slate-700 text-white">
                        <tr>
                            <th class="p-3">Nama PT</th>
                            <th class="p-3">Bulan</th>
                            <th class="p-3">Jumlah Gangguan</th>
                            <th class="p-3">Total Menit Gangguan</th>
                            <th class="p-3">SLA (%)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekapSLA as $pt => $item)
                        <tr class="border-b hover:bg-slate-50">
                            <td class="p-3">{{ $pt }}</td>
                            <td class="p-3">{{ $item['bulan'] }}</td>
                            <td class="p-3 text-center">{{ $item['jumlah'] }}</td>
                            <td class="p-3 text-center">{{ $item['total_menit'] }}</td>
                            <td class="p-3 font-bold">{{ $item['sla'] }}%</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center text-gray-500">Tidak ada data SLA</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- 3️⃣ Diagram SLA per PT --}}
        <div class="bg-white rounded-xl shadow-md p-6">
            <h3 class="text-lg font-semibold mb-4">3️⃣ Diagram SLA per PT (Bulan {{ $months[$month] }} {{ $year }})</h3>
            <canvas id="slaChart" height="100"></canvas>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('slaChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!}, // daftar PT
                datasets: [{
                    label: 'SLA (%)',
                    data: {!! json_encode($values) !!}, // nilai SLA
                    backgroundColor: 'rgba(75, 192, 192, 0.7)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: true, text: 'SLA per Perusahaan' }
                },
                scales: {
                    y: { beginAtZero: true, max: 100 }
                }
            }
        });
    </script>
</x-app-layout>
