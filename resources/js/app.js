import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import router from './router'

import { createApp } from 'vue'
import App from './App.vue'
const app = createApp(App)

app.use(router).mount('#app');
