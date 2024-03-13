<template>
  <div>
    <the-navbar></the-navbar>
    <v-container fluid>
      <v-row>
        <v-col cols="12" md="6">
          <v-card class="dashboard-card graph-card">
            <v-card-title class="dashboard-title">Relatório gerado</v-card-title>
            <v-card-text>
              <div class="chart-container">
                <canvas id="myChart" class="chart-canvas"></canvas>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
        <v-col cols="12" md="6">
          <v-card class="dashboard-card contact-card">
            <v-card-title class="dashboard-title">Informações de Contatos</v-card-title>
            <v-card-text>
              <div class="contact-info">
                <div class="large-card">
                  <div class="card-header">
                    <span class="icon"><i class="fas fa-history"></i></span>
                    <p>Últimos Contatos</p>
                  </div>
                  <div class="card-body">
                    <strong>{{ totalContatos }}</strong>
                  </div>
                </div>
                <div class="large-card">
                  <div class="card-header">
                    <span class="icon"><i class="fas fa-users"></i></span>
                    <p>Total de Contatos</p>
                  </div>
                  <div class="card-body">
                    <strong>{{ totalContatos }}</strong>
                  </div>
                </div>
                <table class="region-table">
                  <thead>
                    <tr>
                      <th>Região</th>
                      <th>Contatos</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(localizacao, index) in localizacoes" :key="index">
                      <td>{{ localizacao.localizacao }}</td>
                      <td>{{ localizacao.count }} contatos</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <the-footer></the-footer>
  </div>
</template>

<script>
import TheNavbar from '@/components/TheNavbar.vue';
import TheFooter from '@/components/TheFooter.vue';
import axios from 'axios';
import Chart from 'chart.js/auto';

export default {
  components: {
    'the-navbar': TheNavbar,
    'the-footer': TheFooter
  },
  data() {
    return {
      totalContatos: 0,
      localizacoes: [],
      regioes: [],
    };
  },
  mounted() {
    this.fetchRelatorioEstatistico();
    this.generateChart();
  },
  methods: {
    fetchRelatorioEstatistico() {
      const token = localStorage.getItem('token');
      const config = { headers: { 'Authorization': `Bearer ${token}` } };

      axios.get('http://localhost:4080/api/report', config)
        .then(response => {
          this.totalContatos = response.data.totalContatos;
          this.localizacoes = response.data.localizacoes;
          this.regioes = response.data.regioes;
        })
        .catch(error => {
          console.error('Erro ao obter relatório:', error);
        });
    },
    generateChart() {
      const ctx = document.getElementById('myChart');
      const myChart = new Chart(ctx, {
        type: 'line',
        data: {
          labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Outubro', 'Novembro', 'Dezembro'],
          datasets: [{
            label: 'Meus contatos por mês',
            data: [65, 59, 80, 81, 56, 55, 40, 25, 42, 48, 76],
            fill: true,
            backgroundColor: 'rgba(220, 220, 220, 0.5)',
            borderColor: 'rgba(75, 192, 192, 0.8)',
            pointStyle: 'circle',
            pointRadius: 5, 
            tension: 0.1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          },
          plugins: {
            legend: {
              display: true,
              position: 'top',
              labels: {
                color: '#333',
                font: { size: 14 },
                usePointStyle: true, 
                padding: 30 
              },
              title: {
                display: true,
                color: '#333',
                font: { size: 16, weight: 'bold' }
              }
            }
          }
        }
      });
    }
  }
};
</script>
  
  <style scoped>
  .dashboard-card {
    border-radius: 15px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
    margin-top: 20px;
    transition: all 0.3s ease;
  }
  
  .dashboard-card:hover {
    transform: translateY(-5px);
  }
  
  .dashboard-title {
    text-align: center;
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 20px;
    color: #333;
  }
  
  .chart-container {
    margin-bottom: 20px;
  }
  
  .contact-info {
    display: flex;
    flex-direction: column;
  }
  
  .large-card {
    background-color: #f9f9f9;
    border-radius: 15px;
    margin-bottom: 15px;
    padding: 15px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
  }
  
  .large-card:hover {
    transform: translateY(-5px);
  }
  
  .card-header {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
  }
  
  .card-header .icon {
    margin-right: 10px;
  }
  
  .card-header .icon i {
    color: #007bff;
  }
  
  .card-body {
    font-size: 20px;
    font-weight: bold;
  }
  
  table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ccc;
  }
  
  th,
  td {
    text-align: left;
    padding: 8px;
    color: #333
  }
  
  th {
    background-color: #f2f2f2;
    color: #333;
    font-weight: bold;
  }
  
  .graph-card {
    background-color: #f8f8f8;
  }
  
  .contact-card {
    background-color: #f5f5f5;
  }
  
  .region-table th {
    background-color: #007bff;
    color: #fff;
  }
  
  .chart-canvas {
    height: 400px; 
  }
  </style>
  