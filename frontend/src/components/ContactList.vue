<template>
    <div>
          <v-table>
            <tr>
              <th v-for="(item, index) in headers" :key="index">{{item.text}}</th>
            </tr>
            <tr v-for="(item, index) in contacts" :key="index">
              <td>{{ item.firstName }}</td>
              <td>{{ item.lastName }}</td>
            
              <td>
                <v-btn @click="verDetalhes(item)">Ver Detalhes</v-btn>
                <v-btn @click="editarContato(item)">Editar</v-btn>
              </td>
            </tr>
          </v-table>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      contacts: Array, 
    },
    data() {
      return {
        headers: [
          {
            text: 'Nome',
            value: 'firstName',
          },
          {
            text: 'Sobrenome',
            value: 'lastName',
          },
          {
            text: 'Ações',
            sortable: false,
          },
        ],
      };
    },
    methods: {
      verDetalhes(contact) {
        console.log("Ver detalhes de", contact.firstName, contact.lastName);
      },
      editarContato(contact) {
        console.log("Editar contato", contact.firstName, contact.lastName);
      },
    },
  };
  </script>
  
  <style scoped>
  th {
    text-align: left;
  }
  </style>
  