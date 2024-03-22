<template>
  <div>
    <the-navbar></the-navbar>
    <v-container>
      <v-row justify="center">
        <v-col cols="12" md="8">
          <v-card class="elevation-2">
            <v-card-title class="text-h5">Detalhes do Contato:</v-card-title>
            <v-card-text>
              <v-form v-if="!editing" class="contact-details">
                <v-row>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Nome"
                      v-model="contact.firstName"
                      readonly
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Sobrenome"
                      v-model="contact.lastName"
                      readonly
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Email"
                      v-model="contact.email"
                      readonly
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Telefone"
                      v-model="contact.telephone"
                      readonly
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      label="Categoria"
                      v-model="contact.category"
                      readonly
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-form>
              <v-form v-else>
                <v-row>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Nome"
                      v-model="editedData.firstName"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Sobrenome"
                      v-model="editedData.lastName"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Email"
                      v-model="editedData.email"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12" md="6">
                    <v-text-field
                      label="Telefone"
                      v-model="editedData.telephone"
                    ></v-text-field>
                  </v-col>
                  <v-col cols="12">
                    <v-text-field
                      label="Categoria"
                      v-model="editedData.category"
                    ></v-text-field>
                  </v-col>
                </v-row>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-btn @click="editarContato" class="custom-primary-button">{{
                editing ? "Salvar" : "Editar"
              }}</v-btn>
            </v-card-actions>
            <v-alert v-if="message" :value="message" type="success" dismissible>
              {{ message }}
            </v-alert>
            <v-alert
              v-if="errorMessage"
              :value="errorMessage"
              type="error"
              dismissible
            >
              {{ errorMessage }}
            </v-alert>
          </v-card>
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

export default {
  components: {
    "the-navbar": TheNavbar,
    "the-footer": TheFooter,
  },
  data() {
    return {
      contact: {},
      editing: false,
      editedData: {
        firstName: "",
        lastName: "",
        email: "",
        telephone: "",
        category: "",
      },
      message: "",
      errorMessage: "",
    };
  },
  created() {
    this.fetchContactDetails();
  },
  methods: {
    fetchContactDetails() {
      const contactId = this.$route.params.id;
      const token = localStorage.getItem("token");

      axios
        .get(`http://localhost:4080/api/contacts/${contactId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          this.contact = response.data.contact;
          this.updateEditedData();
        })
        .catch((error) => {
          console.error("Erro ao buscar detalhes do contato:", error);
        });
    },
    editarContato() {
      if (this.editing) {
        if (this.validateData()) {
          const token = localStorage.getItem("token");

          axios
            .put(
              `http://localhost:4080/api/contacts/${this.contact.id}`,
              this.editedData,
              {
                headers: {
                  Authorization: `Bearer ${token}`,
                },
              }
            )
            .then(() => {
              this.editing = false;
              this.message = "Contato atualizado com sucesso!";
              this.fetchContactDetails(); // Atualizar os detalhes do contato após salvar
            })
            .catch((error) => {
              console.error("Erro ao salvar os dados editados:", error);
              this.errorMessage =
                "Erro ao salvar os dados. Tente novamente mais tarde.";
            });
        }
      } else {
        this.editing = true;
      }
    },
    updateEditedData() {
      this.editedData = { ...this.contact };
    },
    validateData() {
      if (
        this.editedData.firstName &&
        this.editedData.lastName &&
        this.editedData.email
      ) {
        return true;
      } else {
        this.errorMessage = "Preencha todos os campos obrigatórios.";
        return false;
      }
    },
  },
};
</script>

<style scoped>
.custom-primary-button {
  background-color: #ff9100;
  color: #fff;
  border: none;
  border-radius: 10px;
  cursor: pointer;
  margin-top: 20px;
}

.contact-details {
  padding: 20px;
  background-color: #f9f9f9;
  border-radius: 8px;
}

.v-alert {
  margin-top: 20px;
}
</style>
