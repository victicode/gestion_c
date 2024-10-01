import { createWebHashHistory, createRouter } from 'vue-router'

import loginPage from '@/pages/login.vue'
import hostPage from '@/pages/host.vue'

const routes = [
  { path: '/', component: loginPage },
  { path: '/host', component: hostPage },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
})

export default router