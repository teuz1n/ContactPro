<template>
  <div>
    <the-navbar></the-navbar>
    <v-container fluid>
      <v-row>
        <v-col cols="3">
          <v-card class="elevation-2">
            <v-card-title class="text-h5">
              Categorias
            </v-card-title>
            <v-list>
              <v-list-item @click="filterContacts('Todas')">
                <v-list-item-title>Todas</v-list-item-title>
              </v-list-item>
              <v-divider></v-divider>
              <v-list-item
                v-for="(category, index) in categories"
                :key="index"
                @click="filterContacts(category)"
              >
                <v-list-item-title>{{ category }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-card>
        </v-col>
        <v-col cols="7">
          <v-btn @click="adicionarContato" class="custom-primary-button mr-4">Criar novo contato</v-btn>
          <v-btn @click="exibirRelatorio" class="custom-secondary-button mr-4">Relatório</v-btn>
          <div v-if="message">{{ message }}</div>
          <v-table>
            <thead>
              <tr>
                <th>Categoria</th>
                <th>Nome</th>
                <th>Sobrenome</th>
                <th>Ações</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="(item, index) in displayedContacts" :key="index">
                <td class="category-cell">{{ item.category }}</td>
                <td>{{ item.firstName }}</td>
                <td>{{ item.lastName }}</td>
                <td>
                  <v-btn @click="verDetalhes(item)" class="custom-secondary-button mr-4" small>
                    Ver Detalhes
                  </v-btn>
                  <v-btn @click="deletarContato(item)" class="custom-primary-button mr-4" small>
                    Deletar
                  </v-btn>
                </td>
              </tr>
            </tbody>
          </v-table>
        </v-col>
      </v-row>
    </v-container>
    <the-footer></the-footer>
  </div>
</template>


<script>
import TheNavbar from '@/components/TheNavbar.vue';
import TheFooter from '@/components/TheFooter.vue';

import axios from 'axios';
import { useRouter } from 'vue-router';


export default {
  components: {
    'the-navbar': TheNavbar,
    'the-footer': TheFooter

  },
  data() {
    return {
      contacts: [],
      categories: [], 
      selectedCategory: '',
      message: ''
    };
  },
  created() {
    this.fetchContacts();
  },
  methods: {
    fetchContacts() {
      axios.get('http://localhost:4080/api/contacts')
        .then((response) => {
          this.contacts = response.data.contacts;
          this.extractCategories(); 
        })
        .catch((error) => {
          console.error('Erro ao buscar contatos:', error);
        });
    },
    extractCategories() {
      this.categories = [...new Set(this.contacts.map((contact) => contact.category))];
    },
    filterContacts(category) {
    if (category === 'Todas') {
      this.selectedCategory = '';
    } else {
      this.selectedCategory = category;
    }
  },
  adicionarContato() {
    const router = this.$router;
    if (router) {
      router.push({ name: 'FormContact' });
    } else {
      console.error('Roteador não definido.');
    }
  },
    verDetalhes(contact) {
      this.$router.push({ name: 'DetailContact', params: { id: contact.id } });
    },
    deletarContato(contact) {
      const contactId = contact.id;

      axios
        .delete(`http://localhost:4080/api/contacts/${contactId}`)
        .then(() => {
          this.contacts = this.contacts.filter((c) => c.id !== contactId);
          this.message = 'Contato excluído com sucesso!';
        })
        .catch((error) => {
          console.error('Erro ao excluir o contato:', error);
          this.message = 'Erro ao excluir o contato. Tente novamente mais tarde.'; 
        });
    }
  },
  computed: {
    displayedContacts() {
      return this.selectedCategory
        ? this.contacts.filter((contact) => contact.category === this.selectedCategory)
        : this.contacts;
    },
  },
};
</script>

<style scoped>
.category-cell {
  background-color: #f0f0f0;
  font-weight: bold;
  padding: 8px 12px;
  border-radius: 4px;
  text-transform: uppercase;
}

.custom-primary-button {
  background-color: #FF9100;
  color: #fff;
}

.custom-secondary-button {
  background-color: #38B6FF;
  color: #fff;
}
</style>
