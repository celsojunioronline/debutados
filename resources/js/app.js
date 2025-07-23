import { createApp } from 'vue'
import { createRouter, createWebHistory } from 'vue-router'
import axios from 'axios'
import App from './App.vue'

import DeputadosList from './pages/DeputadoList.vue'
import DeputadoShow from './pages/DeputadoShow.vue'

const routes = [
    { path: '/', name: 'deputados', component: DeputadosList },
    { path: '/deputado/:id', name: 'deputado.show', component: DeputadoShow, props: true }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

const app = createApp(App)
app.config.globalProperties.$axios = axios
app.use(router)
app.mount('#app')
