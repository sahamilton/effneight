<!-- https://www.chartjs.org/ -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.5.1/dist/chart.min.js"></script>

<div x-data="{
    labels: ['{!! implode("','",$labels) !!}'],
    values: ['{!! implode("','",$values) !!}'],

    init() {
        let chart = new Chart(this.$refs.canvas.getContext('2d'), {
            type: 'line',
            data: {
                labels: this.labels,
                datasets: [{
                    data: this.values,
                    backgroundColor: '#77C1D2',
                    borderColor: '#77C1D2',
                }],
            },
            options: {
                interaction: { intersect: false },
                scales: { y: { beginAtZero: true }},
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        displayColors: false,
                        callbacks: {
                            label(point) {
                                return 'Sales: $'+point.raw
                            }
                        }
                    }
                }
            }
        })
        
        this.$watch('values', () => {
            chart.data.labels = this.labels
            chart.data.datasets[0].data = this.values
            chart.update()
        })
    }
}">
    <canvas x-ref="canvas"></canvas>
</div>