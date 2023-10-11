<template>
  <div>
    <v-btn @click="adicionarContato" class="custom-primary-button mb-4">Criar novo contato</v-btn>
    <v-btn @click="exibirRelatorio" class="custom-secondary-button mb-4">Relatório</v-btn>
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
        <tr v-for="(item, index) in contacts" :key="index">
          <td class="category-cell">{{ item.category }}</td>
          <td>{{ item.firstName }}</td>
          <td>{{ item.lastName }}</td>
          <td>
            <v-btn @click="verDetalhes(item)" class="custom-secondary-button" small>
              Ver Detalhes
            </v-btn>
            <v-btn @click="editarContato(item)" class="custom-primary-button" small>
              Editar
            </v-btn>
          </td>
        </tr>
      </tbody>
    </v-table>
  </div>
</template>

<script>
export default {
  props: {
    contacts: Array,
  },
  data() {
    return {};
  },
  methods: {
    verDetalhes(contact) {
      console.log('Ver detalhes de', contact.firstName, contact.lastName);
    },
    editarContato(contact) {
      console.log('Editar contato', contact.firstName, contact.lastName);
    },
  },
};
</script>

<style scoped>
th {
  text-align: left;
  background-color: #f0f0f0;
  padding: 10px;
  font-weight: bold;
}

td {
  text-align: left;
  padding: 10px;
}

.category-cell {
  background-color: #f0f0f0;
  font-weight: bold;
  padding: 8px 12px;
  border-radius: 4px;
  text-transform: uppercase;
}

.v-btn {
  margin-right: 5px;
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
