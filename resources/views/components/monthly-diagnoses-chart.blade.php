{{-- resources/views/components/dashboard/monthly-diagnoses-chart.blade.php --}}
@props(['labels', 'values'])

<div class="bg-white p-6 rounded-lg shadow-md mb-8 border border-gray-200">
    <h3 class="text-xl font-semibold text-gray-800 mb-4">Diagnosa Bulanan (6 Bulan Terakhir)</h3>
    <canvas id="monthlyDiagnosesChart" class="w-full h-80"></canvas>
</div>

@push('scripts')
    {{-- Memuat Chart.js dari CDN (pastikan ini hanya sekali dimuat di keseluruhan layout) --}}
    {{-- Jika sudah di layouts/app.blade.php, Anda bisa hapus dari sini --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Data untuk Chart.js diteruskan sebagai props
            const chartLabels = @json($labels);
            const chartValues = @json($values);

            // Debugging logs (biarkan ini untuk memverifikasi data)
            console.log('Chart Component Labels:', chartLabels);
            console.log('Chart Component Values:', chartValues);

            const ctx = document.getElementById('monthlyDiagnosesChart').getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: chartLabels,
                        datasets: [{
                            label: 'Jumlah Diagnosa',
                            data: chartValues,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Diagnosa'
                                },
                                ticks: {
                                    callback: function(value) {
                                        if (Number.isInteger(value)) {
                                            return value;
                                        }
                                        return null;
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Bulan'
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            } else {
                console.error('Canvas context not found for monthlyDiagnosesChart in component.');
            }
        });
    </script>
@endpush