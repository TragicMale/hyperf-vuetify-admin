import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

import Layout from "../views/layout/index.vue";

// const originalPush = Router.prototype.push;
// Router.prototype.push = function push(location) {
//   return originalPush.call(this, location).catch(err => err);
// };

const _import = require("./lazyLoad");

export const baseRoutes = [
  {
    path: "/login",
    component: _import("common/login"),
    name: "login",
    meta: { title: "登录" }
  },
  {
    path: "/401",
    name: "401",
    component: _import("common/401"),
    meta: { title: "无权访问" }
  },
  {
    path: "/404",
    name: "404",
    component: _import("common/404"),
    meta: { title: "找不到页面" }
  }
];

export const mainRoutes = {
  name: "main",
  path: "/",
  component: Layout,
  redirect: "home",
  children: []
};

const createRouter = () =>
  new Router({
    mode: "hash",
    scrollBehavior(to, from, savedPosition) {
      if (savedPosition) {
        return savedPosition;
      } else {
        return { x: 0, y: 0 };
      }
    },
    routes: baseRoutes
  });

// Detail see: https://github.com/vuejs/vue-router/issues/1234#issuecomment-357941465
export function resetRouter() {
  const newRouter = createRouter();
  router.matcher = newRouter.matcher; // reset router
}

const router = createRouter();

export default router;
