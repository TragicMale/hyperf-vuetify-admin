import Vue from "vue";
import App from "./App.vue";
import vuetify from "./plugins/vuetify";
import router from "./router/index";
import store from "./store/index";
import cloneDeep from "lodash/cloneDeep";

import "./plugins/vee-validate";
import "./permission"; // 根据权限加载路由
import "./directive/permission"; // 导入按钮权限指令

Vue.config.productionTip = process.env.VUE_APP_PRODUCTION_TIP;

window.SITE_CONFIG = {};
window.SITE_CONFIG["storeState"] = cloneDeep(store.state);

new Vue({
  store,
  router,
  vuetify,
  render: h => h(App)
}).$mount("#app");
