<canvas id="salesChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
var ctx = document.getElementById('salesChart').getContext('2d');
var chart = new Chart(ctx, {
type: 'line',
data: {
labels: @json($sales->pluck('product_id')),
datasets: [{
label: 'Ventes passées',
data: @json($sales->pluck('total_sales')),
borderColor: 'blue',
fill: false
}, {
label: 'Prédiction',
data: @json($predictions->pluck('predicted_sales')),
borderColor: 'red',
fill: false
}]
}
});
</script>