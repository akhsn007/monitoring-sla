<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            📊 Dashboard Monitoring SLA
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="px-4 mx-auto space-y-6 max-w-7xl">
            {{-- Statistik --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-4">
                <div class="p-6 bg-white shadow-md rounded-xl">
                    <p class="text-sm text-slate-500">Total Log Gangguan</p>
                    <p class="text-3xl font-bold">{{ $totalLogs }}</p>
                </div>
                <div class="p-6 bg-white shadow-md rounded-xl">
                    <p class="text-sm text-slate-500">Total Klien</p>
                    <p class="text-3xl font-bold">{{ $totalClients }}</p>
                </div>
                <div class="p-6 bg-white shadow-md rounded-xl">
                    <p class="text-sm text-slate-500">Jaringan Down</p>
                    <p class="text-3xl font-bold text-red-600">{{ $downCount }}</p>
                </div>
                <div class="p-6 bg-white shadow-md rounded-xl">
                    <p class="text-sm text-slate-500">Down Rata-rata</p>
                    <p class="text-3xl font-bold">{{ $avgSla }}%</p>
                </div>
            </div>

            {{-- Grafik --}}
            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div class="p-6 bg-white shadow-md rounded-xl">
                    <h3 class="mb-4 text-lg font-semibold">📈 Root Cause (Pie Chart)</h3>
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="p-6 bg-white shadow-md rounded-xl">
                    <h3 class="mb-4 text-lg font-semibold">🏢 Jumlah Tiket per Klien</h3>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const pieCtx = document.getElementById('pieChart');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($rootCauseLabels) !!},
                datasets: [{
                    data: {!! json_encode($rootCauseCounts) !!},
                    backgroundColor: ['#3b82f6', '#10b981', '#ef4444', '#facc15', '#6366f1']
                }]
            }
        });

        const barCtx = document.getElementById('barChart');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($siteLabels) !!},
                datasets: [{
                    label: 'Jumlah Tiket',
                    data: {!! json_encode($siteCounts) !!},
                    backgroundColor: '#3b82f6',
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</x-app-layout>
