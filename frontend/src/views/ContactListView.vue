<template>
  <div class="contacts-container">
    <the-navbar></the-navbar>
    <v-container fluid>
      <v-row>
        <v-col cols="12" md="4" lg="3">
          <v-card class="categories-card elevation-2">
            <v-card-title class="text-h5"> Categorias </v-card-title>
            <v-list>
              <v-list-item
                v-for="(category, index) in categories"
                :key="index"
                @click="filterContacts(category)"
                :class="{ 'category-cell': selectedCategory === category }"
              >
                <v-list-item-title>{{ category }}</v-list-item-title>
              </v-list-item>
            </v-list>
          </v-card>
        </v-col>
        <v-col cols="12" md="8" lg="9">
          <v-row align="center" class="mb-4">
            <v-col cols="12" md="auto" class="mb-2">
              <v-btn @click="adicionarContato" class="custom-primary-button"
                >Criar novo contato</v-btn
              >
            </v-col>
            <v-col cols="12" md="auto" class="mb-2">
              <v-btn @click="exibirRelatorio" class="custom-secondary-button"
                >Relatório</v-btn
              >
            </v-col>
          </v-row>
          <div v-if="message" class="mb-4">{{ message }}</div>
          <v-simple-table
            v-if="displayedContacts.length"
            class="contacts-table"
          >
            <template v-slot:default>
              <thead>
                <tr>
                  <th style="width: 40%">Nome</th>
                  <th style="width: 40%">Sobrenome</th>
                  <th style="width: 20%">Ações</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in displayedContacts" :key="index">
                  <td>{{ item.firstName }}</td>
                  <td>{{ item.lastName }}</td>
                  <td>
                    <v-row align="center" justify="center">
                      <v-col cols="auto">
                        <v-btn
                          @click="verDetalhes(item)"
                          class="ver-detalhes-button"
                          icon
                        >
                          <v-icon>mdi-eye</v-icon>
                        </v-btn>
                      </v-col>
                      <v-col cols="auto">
                        <v-btn
                          @click="deletarContato(item)"
                          class="deletar-button"
                          icon
                        >
                          <v-icon>mdi-delete</v-icon>
                        </v-btn>
                      </v-col>
                    </v-row>
                  </td>
                </tr>
              </tbody>
            </template>
          </v-simple-table>
          <div v-else>Nenhum contato disponível.</div>
        </v-col>
      </v-row>
    </v-container>
    <the-footer></the-footer>
  </div>
</template>

<script>
import TheNavbar from "@/components/TheNavbar.vue";
import TheFooter from "@/components/TheFooter.vue";

import axios from "axios";
import { useRouter } from "vue-router";

export default {
  components: {
    "the-navbar": TheNavbar,
    "the-footer": TheFooter,
  },
  data() {
    return {
      contacts: [],
      categories: [],
      selectedCategory: "",
      message: "",
    };
  },
  created() {
    this.fetchContacts();
  },
  methods: {
    fetchContacts() {
      const token = localStorage.getItem("token");
      axios
        .get("http://localhost:4080/api/contacts", {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          this.contacts = response.data.contacts;
          this.extractCategories();
        })
        .catch((error) => {
          console.error("Erro ao buscar contatos:", error);
        });
    },
    extractCategories() {
      this.categories = [
        ...new Set(this.contacts.map((contact) => contact.category)),
      ];
    },
    filterContacts(category) {
      this.selectedCategory = category;
    },
    adicionarContato() {
      const router = this.$router;
      if (router) {
        router.push({ name: "FormContact" });
      } else {
        console.error("Roteador não definido.");
      }
    },
    exibirRelatorio() {
      this.$router.push({ name: "ReportContact" });
    },
    verDetalhes(contact) {
      this.$router.push({ name: "DetailContact", params: { id: contact.id } });
    },
    deletarContato(contact) {
      const token = localStorage.getItem("token");
      axios
        .delete(`http://localhost:4080/api/contacts/${contact.id}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then(() => {
          this.contacts = this.contacts.filter((c) => c.id !== contact.id);
          this.message = "Contato excluído com sucesso!";
        })
        .catch((error) => {
          console.error("Erro ao excluir o contato:", error);
          this.message =
            "Erro ao excluir o contato. Tente novamente mais tarde.";
        });
    },
  },
  computed: {
    displayedContacts() {
      return this.selectedCategory
        ? this.contacts.filter(
            (contact) => contact.category === this.selectedCategory
          )
        : this.contacts;
    },
  },
};
</script>

<style scoped>
.contacts-container {
  background-color: #f9f9f9;
  padding: 20px;
}

.categories-card {
  background-color: #fff;
  box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
}

.category-cell {
  background-color: #f0f0f0;
  font-weight: bold;
  padding: 8px 12px;
  border-radius: 4px;
  text-transform: uppercase;
}

.custom-primary-button {
  background-color: #ff9100;
  color: #fff;
}

.custom-secondary-button {
  background-color: #38b6ff;
  color: #fff;
}

.ver-detalhes-button {
  background-color: #38b6ff !important;
  color: #fff;
}

.deletar-button {
  background-color: #ff4f4f !important;
  color: #fff;
}

.contacts-table {
  width: 100%;
  border-collapse: collapse;
}

.contacts-table th,
.contacts-table td {
  border: 1px solid #dee2e6;
  padding: 8px;
}

.contacts-table th {
  background-color: #f8f9fa;
  font-weight: bold;
}

.contacts-table td {
  text-align: center;
}

@media screen and (min-width: 475px) {
  .contacts-table {
    font-size: 16px;
  }

  .contacts-table th,
  .contacts-table td {
    font-size: 18px;
  }

  .contacts-table th:first-child,
  .contacts-table td:first-child {
    text-align: left;
  }

  .contacts-table th:nth-child(2),
  .contacts-table td:nth-child(2) {
    text-align: left;
  }
}
</style>
