import { createApp } from "vue";
import $ from "jquery";
import App from "./App.vue";
import routes from "./routes";

const appInstance = createApp(App);
appInstance.use(routes);
appInstance.mount("#app");
