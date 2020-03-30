import router from "./router/index";
import store from "./store/index";
import { getToken, removeToken } from "./utils/user";
import { getPermissions } from "./apis/system";
import { toast } from "./utils/index";
import NProgress from "./plugins/nprogress";
import { baseRoutes, mainRoutes } from "./router/index";

const _import = require("./router/lazyLoad");

router.beforeEach((to, from, next) => {
  NProgress.start();

  let title = to.meta.title || to.name;
  window.document.title = title ? title : "";

  if (getToken()) {
    if (to.path === "/login") {
      // if is logged in, redirect to the home page
      next({ path: "/" });
      NProgress.done();
    } else {
      if (
        store.state.common.menuList &&
        store.state.common.menuList.length > 0
      ) {
        next();
      } else {
        getPermissions()
          .then(({ data }) => {
            if (data.menuList) {
              let dynamicRoutes = filterDynamicRoutes(data.menuList);

              // 注册路由
              mainRoutes.children = dynamicRoutes;
              const NotFoundRoute = { path: "*", redirect: { name: "404" } };
              router.addRoutes([mainRoutes, NotFoundRoute]);

              store.commit("common/updateMenuList", data.menuList);
              store.commit("common/updateBtnList", data.btnList);
              next({ ...to, replace: true });
            } else {
              next(`/login?redirect=${to.path}`);
            }
          })
          .catch(res => {
            removeToken();
            // toast("权限获取失败");
            toast(res.data.message, { color: "error" });
            NProgress.done();
            next(`/login?redirect=${to.path}`);
          });
      }
    }
  } else {
    if (
      baseRoutes.some(item => {
        return item.path == to.path;
      })
    ) {
      next();
    } else {
      next(`/login?redirect=${to.path}`);
      NProgress.done();
    }
  }
});

router.afterEach(() => {
  NProgress.done();
});

function filterDynamicRoutes(menuList = [], dynamicRoutes = []) {
  for (var i = 0; i < menuList.length; i++) {
    let item = menuList[i];
    if (item.children && item.children.length >= 1) {
      filterDynamicRoutes(item.children, dynamicRoutes);
    } else if (item.path) {
      item.path = item.path.replace(/^\//, "");

      let component = _import(`modules/${item.path}`);
      if (component) {
        dynamicRoutes.push({
          name: item.path.replace("/", "-"),
          path: item.path,
          meta: {
            title: item.name
          },
          component: component
        });
      }
    }
  }
  return dynamicRoutes;
}
