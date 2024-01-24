<template>
  <div>
    <the-navbar></the-navbar>
    <v-container fluid>
      <v-row>
        <v-col cols="12">
          <v-card class="elevation-2">
            <v-card-title class="text-h5">
              Detalhes do Contato:
            </v-card-title>
            <v-card-text>
              <div class="contact-details">
                <div class="detail" v-if="!editing">
                  <span><strong>Nome:</strong> {{ contact.firstName }}</span>
                </div>
                <div class="detail" v-if="!editing">
                  <span><strong>Sobrenome:</strong> {{ contact.lastName }}</span>
                </div>
                <div class="detail" v-if="!editing">
                  <span><strong>Email:</strong> {{ contact.email }}</span>
                </div>
                <div class="detail" v-if="!editing">
                  <span><strong>Telefone:</strong> {{ contact.telephone }}</span>
                </div>
                <div class="detail" v-if="!editing">
                  <span><strong>Categoria:</strong> {{ contact.category }}</span>
                </div>
                <div v-if="editing || !contact.id">
                <div class="detail edit-mode">
                  <span><strong>Nome:</strong> <input v-model="editedData.firstName" v-if="editing"></span>
                </div>
                <div class="detail edit-mode">
                  <span><strong>Sobrenome:</strong> <input v-model="editedData.lastName" v-if="editing"></span>
                </div>
                <div class="detail edit-mode">
                  <span><strong>Email:</strong> <input v-model="editedData.email" v-if="editing"></span>
                </div>
                <div class="detail edit-mode">
                  <span><strong>Telefone:</strong> <input v-model="editedData.telephone" v-if="editing"></span>
                </div>
                <div class="detail edit-mode">
                  <span><strong>Categoria:</strong> <input v-model="editedData.category" v-if="editing"></span>
                </div>
            </div>
          </div>
            </v-card-text>
          </v-card>
          <v-btn @click="editarContato" class="custom-primary-button">{{ editing ? "Salvar" : "Editar" }}</v-btn>
          <div v-if="message">{{ message }}</div>
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

export default {
  components: {
    'the-navbar': TheNavbar,
    'the-footer': TheFooter
  },
  data() {
    return {
      contact: {},
      editing: false,
      editedData: {
        firstName: '',
        lastName: '',
        email: '',
        telephone: '',
        category: '',
      },
      message: '', 
    };
  },
  created() {
    const contactId = this.$route.params.id;

    axios.get(`http://localhost:4080/api/contacts/${contactId}`)
      .then((response) => {
        this.contact = response.data.contact;
        this.updateEditedData();
      })
      .catch((error) => {
        console.error('Erro ao buscar detalhes do contato:', error);
      });
  },
  methods: {
    editarContato() {
      if (this.editing) {
        if (this.validateData()) {
          axios
            .put(`http://localhost:4080/api/contacts/${this.contact.id}`, this.editedData)
            .then(() => {
              this.editing = false;
              this.message = 'Contato atualizado com sucesso!';
            })
            .catch((error) => {
              console.error('Erro ao salvar os dados editados:', error);
              this.message = 'Erro ao salvar os dados. Tente novamente mais tarde.';
            });
        }
      } else {
        this.editing = true;
      }
    },
    updateEditedData() {
      this.editedData = {
        firstName: this.contact.firstName,
        lastName: this.contact.lastName,
        email: this.contact.email,
        telephone: this.contact.telephone,
        category: this.contact.category,
      };
    },
    validateData() {
      if (this.editedData.firstName && this.editedData.lastName && this.editedData.email) {
        return true;
      } else {
        this.message = 'Preencha todos os campos obrigatórios.';
        return false;
      }
    },
  },
};
</script>

<style scoped>
.contact-details {
  display: flex;
  flex-direction: column;
}

.detail {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.custom-primary-button {
  background-color: #FF9100;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  margin-top: 20px;
}

.edit-mode {
  background-color: #f0f0f0;
  padding: 5px; 
}
</style>
