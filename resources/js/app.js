import { createApp } from "vue";
import $ from "jquery";
import App from "./App.vue";
import store from "./stores/index";
import routes from "./routes";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import jquery from 'jquery';
import 'datatables.net-bs4/css/dataTables.bootstrap4.min.css';
import 'datatables.net-bs4/js/dataTables.bootstrap4.min';
import 'datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css';
import 'datatables.net-responsive-bs4/js/responsive.bootstrap4.min';

const appInstance = createApp(App);
appInstance.use(jquery);
appInstance.use(routes);
appInstance.use(store);
appInstance.use(VueSweetalert2);
appInstance.mount("#app");
