<template>
    <v-footer app class="custom-footer" dark color="#1976D2">
      <v-container>
        <div>
          &copy; {{ new Date().getFullYear() }} Contact Pro
        </div>
      </v-container>
    </v-footer>
  </template>
  
  <script>
  export default {
    // Você pode adicionar métodos ou lógica relacionados ao rodapé, se necessário.
  };
  </script>
  
  <style scoped>
  .custom-footer {
    background: linear-gradient(45deg, #3A9DDB, #3B82F6);
    color: white;
    text-align: center;
    padding: 10px 0;
  }
  </style>