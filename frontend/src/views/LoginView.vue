<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="loginUser">
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" v-model="email" placeholder="Entrar com email" required />
      </div>
      <div class="form-group">
        <label for="password">Senha:</label>
        <input type="password" id="password" v-model="password" placeholder="Entrar com senha" required />
      </div>
      <button type="submit">Login</button>
      <a class="forgot-password" href="#">Esqueceu a senha?</a>
      <p class="register">Não possui uma conta? <a class="href" href="#">Criar conta</a></p>
    </form>
  </div>
</template>

<script>
import axios from 'axios';
export default {
  data() {
    return {
      email: "",
      password: "",
    };
  },
  methods: {
    loginUser() {
      axios
        .post("http://localhost:4080/auth/login", {
          email: this.email,
          password: this.password,
        })
      . then((response) => {
          console.log(response.data);
          console.log('Usuário fez login com sucesso:', response.data.loginUser);

      // Configuração de token no cabeçalho das solicitações
      axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;

    router.push({ name: 'ContactList' });
  })
  .catch((error) => {
    console.error('Erro ao fazer login:', error);
  });

    },
  },
};
</script>

<style scoped>
.login-container {
  max-width: 400px;
  margin: auto;
  margin-top: 250px;
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

form {
  display: flex;
  flex-direction: column;
}

.form-group {
  display: flex;
  flex-direction: column;
  margin-bottom: 20px;
}

label {
  margin-bottom: 8px;
  color: #555;
}

input {
  padding: 12px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  margin-bottom: 10px;
}

button {
  background-color: #38B6FF;
  color: white;
  padding: 15px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  font-size: 18px;
  font-weight: bold;
  width: 100%;
  transition: background-color 0.3s;
}

button:hover {
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
