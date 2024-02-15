<template>
  <v-container fluid class="login-container">
    <h2>Login</h2>
    <v-form @submit.prevent="loginUser">
      <v-text-field
        v-model="email"
        label="Email"
        placeholder="Entrar com email"
        :rules="[
        v => !!v || 'Campo Email é obrigatório',
        v => /.+@.+/.test(v) || 'Email deve ser válido']"
      ></v-text-field>

      <v-text-field
        v-model="password"
        label="Senha"
        placeholder="Entrar com senha"
        type="password"
        required
      ></v-text-field>

      <v-btn type="submit" class="custom-login-button" block>Login</v-btn>
      <a class="forgot-password" href="#">Esqueceu a senha?</a>
      <p class="register">Não possui uma conta? <router-link class="href" to="/register">Criar conta</router-link></p>
    </v-form>
  </v-container>
</template>

<script>
import axios from 'axios';
import router from '@/router/router';

export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    async loginUser() {
      try {
        const response = await axios.post("http://localhost:4080/api/auth/login", {
          email: this.email,
          password: this.password,
        });
        
        const token = response.data.token;
       
        localStorage.setItem('token', token);
     
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;

        
        this.$router.push({ name: 'ContactList' });
      } catch (error) {
        console.error('Erro ao fazer login:', error);
      }
    },
  },
};
</script>

<style scoped>
.login-container {
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

.custom-login-button {
  background-color: #38B6FF;
  color: white;
  border-radius: 5px;
  font-size: 18px;
  font-weight: bold;
  width: 100%;
  margin-bottom: 5px;
}

.custom-login-button:hover {
  background-color: #269add;
}

.register {
  margin-top: 10px;
  font-size: 1rem;
}

.href {
  text-decoration: none;
  font-size: 1rem;
  font-weight: bold;
  color: #FF9100;
}

.forgot-password {
  font-size: 0.9rem;
  margin-top: 5px;
  text-align: end;
  text-decoration: none;
  color: #333;
}
</style>
