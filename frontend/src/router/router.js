import { createRouter, createWebHistory } from 'vue-router'
import ContactListView from '../views/ContactListView.vue'
import FormContactView from '../views/FormContactView.vue'

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
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
