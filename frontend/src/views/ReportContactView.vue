<template>
    <div>
        <the-navbar/>
        <div style="position: relative; height: 40vh; width: 80vw;">
            <canvas id="myChart"></canvas>
        </div>
        <the-footer/>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';
import TheNavbar from '@/components/TheNavbar.vue';
import TheFooter from '@/components/TheFooter.vue';

export default {
  components: {
    'the-navbar': TheNavbar,
    'the-footer': TheFooter

  },
  mounted(){

    const data = {
        labels: ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho'],
            datasets:[{
                label: 'Meus contatos por mês',
                data: [65, 59, 80, 81, 56, 55, 40],
                backgroundColor: [ 
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(255, 159, 64, 0.2)',
                    'rgba(255, 205, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(201, 203, 207, 0.2)'
                ],
                borderColor: [ 
                    'rgb(255, 99, 132)',
                    'rgb(255, 159, 64)',
                    'rgb(255, 205, 86)',
                    'rgb(75, 192, 192)',
                    'rgb(54, 162, 235)',
                    'rgb(153, 102, 255)',
                    'rgb(201, 203, 207)'
                ],
                borderWidth: 1
            }]

    };

    const config = {
        type: 'line',
        data: data,
        options: {
            scales: { 
                y: {
                    beginAtZera: true
                }
            }
        },

    }



    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, config);
    myChart;
  }
}

</script>

<style>
</style>