import { createRouter, createWebHistory } from 'vue-router'
import ContactListView from '../views/ContactListView.vue'
import FormContactView from '../views/FormContactView.vue'
import DetailContactView from '@/views/DetailContactView.vue'

const routes = [
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
