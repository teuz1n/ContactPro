import { createRouter, createWebHistory } from 'vue-router'
import ContactListView from '../views/ContactListView.vue'

const routes = [
  {
    path: '/contacts',
    name: 'ContactList',
    component: ContactListView
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
