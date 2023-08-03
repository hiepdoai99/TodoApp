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

// import the pagination package
import VueAwesomePaginate from "vue-awesome-paginate";
// import the necessary css file
import "vue-awesome-paginate/dist/style.css";

import router from "./router";

import { createApp } from "vue";
import App from "./App.vue";
const app = createApp(App);

app.use(router)
    .use(VueAwesomePaginate)
    .component("font-awesome-icon", FontAwesomeIcon)
    .mount("#app");
