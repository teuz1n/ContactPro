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
                <v-text-field
                  v-model="novoContato.nome"
                  label="Nome"
                  :rules="[
                    (v) => !!v || 'Campo Nome é obrigatório',
                    (v) =>
                      (v && v.length <= 20) ||
                      'Nome deve ter no máximo 20 caracteres',
                  ]"
                ></v-text-field>

                <v-text-field
                  v-model="novoContato.sobrenome"
                  label="Sobrenome (opicional)"
                  :rules="[
                    (v) =>
                      !v ||
                      v.length <= 20 ||
                      'Sobrenome deve ter no máximo 20 caracteres',
                  ]"
                ></v-text-field>

                <v-text-field
                  v-model="novoContato.email"
                  label="Email"
                  :rules="[
                    (v) => !!v || 'Campo Email é obrigatório',
                    (v) => /.+@.+/.test(v) || 'Email deve ser válido',
                  ]"
                ></v-text-field>

                <v-text-field
                  v-model="novoContato.telefone"
                  label="Telefone"
                  v-mask="'(##) #####-####'"
                  :rules="[
                    (v) => !!v || 'Campo Telefone é obrigatório',
                    (v) =>
                      (v.match(/\d/g) || []).length === 11 ||
                      'Telefone deve conter 11 dígitos numéricos',
                  ]"
                ></v-text-field>

                <v-text-field
                  v-model="novoContato.categoria"
                  label="Categoria"
                  :rules="[
                    (v) => !!v || 'Campo Categoria é obrigatório',
                    (v) =>
                      (v && v.length <= 50) ||
                      'Categoria deve ter no máximo 50 caracteres',
                  ]"
                ></v-text-field>
                <v-btn type="submit" class="custom-primary-button mt-4"
                  >Criar Contato</v-btn
                >
                <div style="margin-top: 10px">
                  <!-- Espaçamento adicional -->
                  <v-alert
                    v-if="message"
                    :value="message"
                    type="success"
                    dismissible
                  >
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
                </div>
              </v-form>
            </v-card-text>
          </v-card>
        </v-col>
      </v-row>
    </v-container>
    <the-footer></the-footer>
  </div>
</template>

<script>
import axios from "axios";
import { ref } from "vue";
import { useRouter } from "vue-router";
import TheNavbar from "@/components/TheNavbar.vue";
import TheFooter from "@/components/TheFooter.vue";

export default {
  components: {
    "the-navbar": TheNavbar,
    "the-footer": TheFooter,
  },
  setup() {
    const novoContato = ref({
      nome: "",
      sobrenome: "",
      email: "",
      telefone: "",
      categoria: "",
    });

    const router = useRouter();

    const message = ref("");
    const errorMessage = ref("");

    const criarNovoContato = () => {
      const token = localStorage.getItem("token");

      const data = {
        firstName: novoContato.value.nome,
        lastName: novoContato.value.sobrenome,
        email: novoContato.value.email,
        telephone: novoContato.value.telefone,
        category: novoContato.value.categoria,
      };

      axios
        .post("http://localhost:4080/api/contacts", data, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        })
        .then((response) => {
          console.log("Novo Contato criado:", response.data.contact);
          message.value = "Contato criado com sucesso!";
          router.push({ name: "ContactList" });
        })
        .catch((error) => {
          console.error("Erro ao criar um novo contato:", error);
          errorMessage.value =
            "Erro ao criar um novo contato. Tente novamente mais tarde.";
        });
    };

    return {
      novoContato,
      criarNovoContato,
      message,
      errorMessage,
    };
  },
};
</script>

<style scoped>
.custom-primary-button {
  background-color: #ff9100;
  color: #fff;
  border-radius: 10px;
}
</style>
