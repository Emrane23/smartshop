<canvas id="pointsChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx = document.getElementById('pointsChart').getContext('2d');
    var chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: @json($customers->pluck('name')),
            datasets: [{
                label: 'Points de fidélité',
                data: @json($customers->pluck('points')),
                backgroundColor: 'green'
            }]
        }
    });
</script>
