    </div> <!-- End main-content -->
    </div> <!-- End wrapper -->

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Auto hide alerts after 3 seconds
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                }, 3000);
            });

            const chartElement = document.getElementById('borrowingsChart');
            if (chartElement) {
                const ctx = chartElement.getContext('2d');
                const labels = JSON.parse(chartElement.dataset.labels || '[]');
                const data = JSON.parse(chartElement.dataset.values || '[]');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels.length ? labels : ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                        datasets: [{
                            label: 'Peminjaman',
                            data: data.length ? data : [12, 18, 15, 22, 20, 26],
                            backgroundColor: 'rgba(59, 130, 246, 0.15)',
                            borderColor: '#3b82f6',
                            borderWidth: 3,
                            pointBackgroundColor: '#1d4ed8',
                            pointBorderColor: '#ffffff',
                            pointRadius: 5,
                            pointHoverRadius: 7,
                            fill: true,
                            tension: 0.35,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            x: {
                                ticks: { color: '#495057' },
                                grid: { display: false }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: { color: '#495057' },
                                grid: { color: 'rgba(15, 23, 42, 0.08)' }
                            }
                        },
                        plugins: {
                            legend: {
                                display: true,
                                labels: {
                                    color: '#1a1a2e',
                                    font: { weight: '600' }
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(15, 23, 42, 0.95)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(255,255,255,0.15)',
                                borderWidth: 1
                            }
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>
