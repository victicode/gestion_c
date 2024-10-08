import { createWebHashHistory, createRouter } from 'vue-router'

import auth from './middlewares/auth'
import admin from './middlewares/admin'
import guest from './middlewares/guest'
import hostLayout from '@/layouts/hostLayout.vue'
import hostPage from '@/pages/host.vue'

const setInitByRol = () => {
  return window.localStorage.getItem('is_admin') == '1' 
  ? '/admin' 
  :  window.localStorage.getItem('is_admin') == '3'
  ? '/counter'
  : '/host'
}

const routes = [
  { path: '/', redirect: setInitByRol() },
  { 
    path: '/login', 
    component: () => import('@/pages/login.vue'),
    name:'Login',
    meta: {
      title : 'Iniciar sesion'
    },
    beforeEnter: guest,
  },

  { 
    path: '/', 
    component: hostLayout ,
    children:[
      {
        name:'hostDashboard',
        path: '/host', 
        component: hostPage ,
        meta: {
          title : 'Bienvenido'
        },
      },
      {
        name:'createTicket',
        path: '/create_ticket', 
        component: () => import('@/pages/host/createTicket.vue'), 
        meta: {
          title : 'Crear nuevo ticket'
        },
      }
    ],
    beforeEnter: auth,
  },
]

const router = createRouter({
  history: createWebHashHistory(),
  routes,
})

export default router