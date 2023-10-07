<template>
    <div>
      <v-card>
        <v-card-title>
          Contatos
        </v-card-title>
        <v-card-text>
          <v-data-table
            :items="contacts"
            :headers="headers"
          >
            <template v-slot:item="{ item }">
              <tr>
                <td>{{ item.firstName }}</td>
                <td>{{ item.lastName }}</td>
             
                <td>
                  <v-btn @click="verDetalhes(item)">Ver Detalhes</v-btn>
                  <v-btn @click="editarContato(item)">Editar</v-btn>
                </td>
              </tr>
            </template>
          </v-data-table>
        </v-card-text>
      </v-card>
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
  </style>
  