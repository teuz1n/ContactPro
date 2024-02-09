import { createRouter, createWebHistory } from 'vue-router'
import ContactListView from '../views/ContactListView.vue'
import FormContactView from '../views/FormContactView.vue'
import DetailContactView from '@/views/DetailContactView.vue'
import LoginView from '@/views/LoginView.vue'

const routes = [
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/contacts',
    name: 'ContactList',
    component: ContactListView
  },
  {
    path: '/create/contacts',
    name: 'FormContact',
    component: FormContactView
  },
  {
    path: '/detail/contact/:id',
    name: 'DetailContact',
    component: DetailContactView
  }
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
