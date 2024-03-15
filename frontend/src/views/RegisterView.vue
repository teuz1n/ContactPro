<template>
  <v-container fluid class="register-container">
    <h2>Criar conta</h2>
    <v-form @submit.prevent="registerUser">
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="name"
            label="Nome"
            placeholder="Insira seu nome"
            :rules="[
              (v) => !!v || 'Campo Nome é obrigatório',
              (v) =>
                (v && v.length <= 20) ||
                'Nome deve ter no máximo 20 caracteres',
            ]"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="email"
            label="Email"
            placeholder="Insira seu email"
            :rules="[
              (v) => !!v || 'Campo Email é obrigatório',
              (v) => /.+@.+/.test(v) || 'Email deve ser válido',
            ]"
          ></v-text-field>
        </v-col>
      </v-row>
      <v-row>
        <v-col cols="12">
          <v-text-field
            v-model="password"
            label="Senha"
            placeholder="Insira sua senha"
            type="password"
            required
          ></v-text-field>
        </v-col>
      </v-row>
      <v-btn type="submit" class="custom-register-button" block
        >Registrar</v-btn
      >
    </v-form>
    <p class="login">Já possui uma conta? <a href="/login">Login</a></p>
  </v-container>
</template>

<script>
import axios from "axios";
import router from "@/router/router";

export default {
  data() {
    return {
      name: "",
      email: "",
      password: "",
    };
  },
  methods: {
    async registerUser() {
      try {
        const response = await axios.post(
          "http://localhost:4080/api/auth/register",
          {
            name: this.name,
            email: this.email,
            password: this.password,
          }
        );

        console.log(response.data);
        console.log(
          "Usuário registrado com sucesso:",
          response.data.registeredUser
        );

        router.push({ name: "Login" });
      } catch (error) {
        console.error("Erro ao registrar usuário:", error);
      }
    },
  },
};
</script>

<style scoped>
.register-container {
  max-width: 400px;
  margin: auto;
  margin-top: 200px;
  padding: 30px;
  border: 1px solid #ddd;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  background-color: #fff;
}

h2 {
  text-align: center;
  color: #333;
  font-size: 2rem;
  margin-bottom: 10px;
}

.login {
  text-align: center;
  margin-top: 20px;
}

.login a {
  color: #ff9100;
  text-decoration: none;
  font-weight: bold;
}

.custom-register-button {
  background-color: #38b6ff;
  color: white;
  border-radius: 5px;
  font-size: 18px;
  font-weight: bold;
  width: 100%;
  margin-bottom: 5px;
}

.custom-register-button:hover {
  background-color: #269add;
}
</style>
