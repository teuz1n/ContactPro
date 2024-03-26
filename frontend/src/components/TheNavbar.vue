<template>
  <v-app-bar app class="custom-app-bar" elevation="4" dark height="80">
    <v-img
      class="imageLogo"
      src="@/assets/LogoContactPro2.svg"
      max-height="64"
      min-width="192px"
    ></v-img>
    <v-spacer></v-spacer>
    <v-btn class="custom-logout-button" @click="logout">
      <v-icon left>mdi-exit-to-app</v-icon> Sair
    </v-btn>
  </v-app-bar>
</template>

<script>
import axios from "axios";

export default {
  data() {
    return {
      drawer: false,
    };
  },
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
  padding: 0 24px;
}

.custom-logout-button {
  background-color: #ff9100;
  color: white;
  font-weight: bold;
  border-radius: 10px;
  padding: 10px 16px;
  transition: background-color 0.3s;
}

.custom-logout-button:hover {
  background-color: #ff8000;
}

.menu-button {
  margin-left: 8px;
}

@media only screen and (max-width: 375px) {
  .custom-app-bar {
    padding: 0 8px;
  }

  .custom-logout-button {
    padding: 10px;
    font-size: 12px;
  }
}
</style>
