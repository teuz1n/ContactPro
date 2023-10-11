<template>
    <div>
      <the-navbar></the-navbar>
      <v-card class="mt-5">
        <v-card-title>
        </v-card-title>
        <v-card-text>
          <contact-list :contacts="contacts"></contact-list>
        </v-card-text>
      </v-card>
    </div>
  </template>
  
  <script>
  import ContactList from '@/components/ContactList.vue';
  import TheNavbar from '@/components/TheNavbar.vue';
  import axios from 'axios';
  
  export default {
    components: {
      'contact-list': ContactList,
      'the-navbar': TheNavbar
    },
    data() {
      return {
        contacts: [] 
      };
    },
    created() {
      this.fetchContacts(); 
    },
    methods: {
      fetchContacts() {
        axios.get('http://localhost:8000/api/contacts')
          .then((response) => {
            this.contacts = response.data.contacts;
          })
          .catch((error) => {
            console.error('Erro ao buscar contatos:', error);
          });
      }
    }
  };
  </script>
  