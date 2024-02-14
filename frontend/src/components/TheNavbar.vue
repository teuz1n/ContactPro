<template>
  <v-app-bar app class="custom-app-bar" elevation="4" dark color="#1976D2" height="80">
    <v-container class="d-flex justify-between align-center">
      <v-img src="@/assets/LogoContactPro2.svg" max-height="70"></v-img>
      <v-btn class="custom-logout-button" @click="logout">
        <v-icon left>mdi-exit-to-app</v-icon> Sair
      </v-btn>
    </v-container>
  </v-app-bar>
</template>

<script>
import axios from 'axios';
import router from '@/router/router';

export default {
  methods: {
    async logout() {
      try {
        const token = localStorage.getItem('token');

        await axios.post('http://localhost:4080/api/auth/logout', null, {
          headers: {
            Authorization: `Bearer ${token}`
          }
        });

        localStorage.removeItem('token');
        
        delete axios.defaults.headers.common['Authorization'];

        this.$router.push({ name: 'Login' });
      } catch (error) {
        console.error('Erro ao fazer logout:', error);
      }
    },
  },
};
</script>

<style scoped>
.custom-app-bar {
  background: linear-gradient(45deg, #3A9DDB, #3B82F6);
}

.custom-logout-button {
  background-color: #FF9100;
  color: white;
  font-weight: bold;
}

.custom-logout-button:hover {
  background-color: #FF8000;
}
</style>
