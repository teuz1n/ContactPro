import { createApp } from 'vue'
import App from './App.vue'
import Vuetify from '@/plugins/vuetify'
import 'vuetify/dist/vuetify.min.css'
import router from './router/router'
import VueTheMask from 'vue-the-mask'


const app = createApp(App)

app.use(Vuetify)

app.use(router)

app.use(VueTheMask)

app.mount('#app')