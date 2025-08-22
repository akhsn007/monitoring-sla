<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            📊 Dashboard Monitoring SLA
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 space-y-6">
            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <p class="text-sm text-slate-500">Total Log Gangguan</p>
                    <p class="text-3xl font-bold">{{ $totalLogs }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <p class="text-sm text-slate-500">Total Klien</p>
                    <p class="text-3xl font-bold">{{ $totalClients }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <p class="text-sm text-slate-500">Jaringan Down</p>
                    <p class="text-3xl font-bold text-red-600">{{ $downCount }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <p class="text-sm text-slate-500">SLA Rata-rata</p>
                    <p class="text-3xl font-bold">{{ $avgSla }}%</p>
                </div>
            </div>

            {{-- Grafik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold mb-4">📈 Root Cause (Pie Chart)</h3>
                    <canvas id="pieChart"></canvas>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md">
                    <h3 class="text-lg font-semibold mb-4">🏢 Jumlah Tiket per Klien</h3>
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
