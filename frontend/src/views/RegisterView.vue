<template>
    <div class="register-container">
      <h2>Criar conta</h2>
      <form @submit.prevent="registerUser">
        <div class="form-group">
          <label for="name">Nome:</label>
          <input type="text" id="name" v-model="name" placeholder="Insira seu nome" required />
        </div>
        <div class="form-group">
          <label for="email">Email:</label>
          <input type="email" id="email" v-model="email" placeholder="Insira seu email" required />
        </div>
        <div class="form-group">
          <label for="password">Senha:</label>
          <input type="password" id="password" v-model="password" placeholder="Insira sua senha" required />
        </div>
        <button type="submit">Registrar</button>
        <p class="login">Já possui uma conta? <a class="href" href="/login">Login</a></p>
      </form>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  import router from '@/router/router';
  
  export default {
    data() {
      return {
        name: "",
        email: "",
        password: ""
      };
    },
    methods: {
      registerUser() {
        axios
          .post("http://localhost:4080/api/auth/register", {
            name: this.name,
            email: this.email,
            password: this.password
          })
          .then((response) => {
            console.log(response.data);
            console.log('Usuário registrado com sucesso:', response.data.registeredUser);
        
            router.push({ name: 'Login' });
          })
          .catch((error) => {
            console.error('Erro ao registrar usuário:', error);
          });
      }
    }
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
  
  .login {
    margin-top: 10px;
    font-size: 1rem;
    text-align: center;
  }
  
  .href {
  text-decoration: none;
  font-size: 1rem;
  font-weight: bold;
  color: #FF9100;
}
  </style>
  