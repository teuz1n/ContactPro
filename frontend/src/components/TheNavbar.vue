<template>
  <v-app-bar app class="custom-app-bar" elevation="4" dark height="80">
    <template #prepend>
      <v-img class="imageLogo" src="@/assets/LogoContactPro2.svg" max-height="80" min-width="256px"></v-img>
    </template>
    <template #append>
      <v-btn class="custom-logout-button" @click="logout">
        <v-icon left>mdi-exit-to-app</v-icon> Sair
      </v-btn>
    </template>
  </v-app-bar>
</template>
<script>
import axios from "axios";

export default {
  methods: {
    async logout() {
      try {
        const token = localStorage.getItem("token");

        await axios.post("http://localhost:4080/api/auth/logout", null, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });

        localStorage.removeItem("token");

        delete axios.defaults.headers.common["Authorization"];

        this.$router.push({ name: "Login" });
      } catch (error) {
        console.error("Erro ao fazer logout:", error);
      }
    },
  },
};
</script>

<style scoped>
.custom-app-bar {
  background: linear-gradient(to right, #007bff, #48a7ff);
  padding: 0 60px;
}

.custom-logout-button {
  background-color: #ff9100;
  color: white;
  font-weight: bold;
  border-radius: 10px;
  padding: 10px 20px;
  transition: background-color 0.3s;
}

.custom-logout-button:hover {
  background-color: #ff8000;
}
</style>
