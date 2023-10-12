<template>
    <div>
    <the-navbar></the-navbar>
      <v-container>
        <v-row>
          <v-col cols="6" offset="3">
            <v-card class="elevation-2">
              <v-card-title class="text-h5">Novo Contato</v-card-title>
              <v-card-text>
                <v-form @submit.prevent="criarNovoContato">
                  <v-text-field v-model="novoContato.nome" label="Nome"></v-text-field>
                  <v-text-field v-model="novoContato.sobrenome" label="Sobrenome"></v-text-field>
                  <v-text-field v-model="novoContato.email" label="Email"></v-text-field>
                  <v-text-field v-model="novoContato.telefone" label="Telefone"></v-text-field>
                  <v-text-field v-model="novoContato.categoria" label="Categoria"></v-text-field>
                  <v-btn type="submit" class="custom-primary-button mt-4">Criar Contato</v-btn>
                </v-form>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </div>
  </template>
    
  <script>
  import axios from 'axios';
  import { ref } from 'vue';
  import { useRouter } from 'vue-router';
  import TheNavbar from '@/components/TheNavbar.vue';
  
  export default {
    components: {
    'the-navbar': TheNavbar 
  },
    setup() {
      const novoContato = ref({
        nome: '',
        sobrenome: '',
        email: '',
        telefone: '',
        categoria: '',
      });
  
      const router = useRouter();
  
      const criarNovoContato = () => {
        const data = {
          firstName: novoContato.value.nome,
          lastName: novoContato.value.sobrenome,
          email: novoContato.value.email,
          telephone: novoContato.value.telefone,
          category: novoContato.value.categoria,
        };
  
        axios.post('http://localhost:8000/api/contacts', data)
          .then((response) => {
            console.log('Novo Contato criado:', response.data.contact);
            router.push({ name: 'ContactList' });
          })
          .catch((error) => {
            console.error('Erro ao criar um novo contato:', error);
          });
      };
  
      return {
        novoContato,
        criarNovoContato,
      };
    },
  };
  </script>
  