<template>
    <v-app-bar app class="white--text" elevation="2" color="white" dark height="80">
      <v-img src="../assets/LogoContactPro.svg" max-height="86" ></v-img>
      <v-spacer></v-spacer>
      <v-btn class="custom-logout-button" @click="logout">
        <v-icon left>mdi-exit-to-app</v-icon> Sair
      </v-btn>
    </v-app-bar>
  </template>
  
  
  
  <script>
  export default {
    methods: {
      logout() {
      },
    },
  };
  </script>

<style scoped>
.custom-logout-button {
  background-color: #FF9100;
  color: white;
}

.custom-logout-button:hover {
  background-color: #FF8000; 
}
</style>
  