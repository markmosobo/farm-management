<template>
    <div class="container">
        <div>
            <canvas id="profit-chart"></canvas>
        </div>
    </div>
</template>

<script>
    import Chart from 'chart.js'
    import profitChartData from '../Profitdata.js'
    export default {
        name: 'Profit-Chart',
        data() {
         return {
          profitChartData: profitChartData
         }
        },        
        mounted() {
            const ctx = document.getElementById('profit-chart');
            new Chart(ctx, this.profitChartData);
        }
    }
</script>
