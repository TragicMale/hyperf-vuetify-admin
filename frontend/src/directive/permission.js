import Vue from "vue";
import store from "../store/index";

Vue.directive("permission", {
  inserted(el, binding) {
    const key = binding.value;
    if (key) {
      const btnList = store.state.common.btnList;
      const hasPermission = btnList.indexOf(key) > -1;
      if (!hasPermission) {
        el.parentNode && el.parentNode.removeChild(el);
      }
    }
  }
});
