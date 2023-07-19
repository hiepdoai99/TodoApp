import "bootstrap/dist/css/bootstrap.min.css"
import "bootstrap"
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'




import router from './router'

import { createApp } from 'vue'
import App from './App.vue'
const app = createApp(App)

app.use(router);
app.use(BootstrapVue)
app.mount('#app');
