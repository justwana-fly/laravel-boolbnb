<!-- resources/views/partials/dashboard-card/analytics.blade.php -->

<div class="card mb-3">
    <div id="analytics-title"class="p-3" >Analytics</div>
    <div class="card-body">
        <canvas id="analyticsChart" width="400" height="200"></canvas>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('analyticsChart').getContext('2d');
        const data = {
            labels: ['Users', 'Visits', 'Sales'], // esempio di label
            datasets: [{
                label: 'Data',
                data: [100, 500, 200], // esempio di dati (da sostituire con dati reali)
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(75, 192, 192, 1)',
                ],
                borderWidth: 1
            }]
        };
        const options = {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        };
        const analyticsChart = new Chart(ctx, {
            type: 'bar',
            data: data,
            options: options
        });
    });
</script>
@endpush
