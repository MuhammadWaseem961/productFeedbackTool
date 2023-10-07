import { createApp } from "vue";
import $ from "jquery";
import App from "./App.vue";
import store from "./stores/index";
import routes from "./routes";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';

const appInstance = createApp(App);
appInstance.use(routes);
appInstance.use(store);
appInstance.use(VueSweetalert2);
appInstance.mount("#app");
