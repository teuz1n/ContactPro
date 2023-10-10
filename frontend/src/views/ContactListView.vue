<template>
    <div>
      <v-card>
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
  import axios from 'axios';
  
  export default {
    components: {
      'contact-list': ContactList
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
  