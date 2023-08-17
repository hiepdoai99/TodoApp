import "bootstrap/dist/css/bootstrap.min.css";
import "bootstrap";

import "bootstrap/dist/css/bootstrap.css";
import "bootstrap-vue/dist/bootstrap-vue.css";
/* import the fontawesome core */
import { library } from "@fortawesome/fontawesome-svg-core";

/* import font awesome icon component */
import { FontAwesomeIcon } from "@fortawesome/vue-fontawesome";

/* import specific icons */
import {
    faUserSecret,
    faEye,
    faPenToSquare,
    faDeleteLeft,
    faBars,
} from "@fortawesome/free-solid-svg-icons";

/* add icons to the library */
library.add(faUserSecret, faEye, faPenToSquare, faDeleteLeft, faBars);
// Vuetify
import "vuetify/styles";
import { createVuetify } from "vuetify";
import * as components from "vuetify/components";
import * as directives from "vuetify/directives";

const vuetify = createVuetify({
    components,
    directives,
});
import router from "./router";

import { createApp } from "vue";
import App from "./App.vue";
const app = createApp(App);

app.use(router)
    .use(vuetify)
    .component("font-awesome-icon", FontAwesomeIcon)
    .mount("#app");
