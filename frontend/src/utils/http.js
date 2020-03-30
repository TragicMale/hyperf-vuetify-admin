import axios from "axios";
import router from "../router/index";
import store from "../store/index";
import { getToken, removeToken } from "./user";
import { toast } from "./index";
import NProgress from "../plugins/nprogress";

/**
 * 跳转登录页
 * 携带当前页面路由，以期在登录页面完成登录后返回当前页面
 */
const toLogin = () =>
  router.replace({
    name: "login",
    query: {
      redirect: router.currentRoute.fullPath
    }
  });

/**
 * 请求失败后的错误统一处理
 * @param {Number} status 请求失败的状态码
 */
const errorHandle = response => {
  if (response.data && typeof response.data == "string") {
    toast(response.data);
    toast(response.data, { color: "error" });
  } else {
    toast("未知错误", { color: "error" });
  }
  switch (response.status) {
    // 401 token无效
    case 401:
      // 清除token并跳转登录页
      removeToken();
      setTimeout(() => {
        toLogin();
      }, 1000);
      break;
  }
};

const instance = axios.create({
  baseURL: process.env.VUE_APP_BASE_API,
  timeout: 3000,
  headers: { "Content-Type": "application/json" }
});

/**
 * 请求拦截器
 * 每次请求前，如果存在token则在请求头中携带token
 */
instance.interceptors.request.use(
  config => {
    NProgress.start();
    const token = getToken();
    if (token) {
      config.headers["Authorization"] = token;
    }
    return config;
  },
  error => {
    NProgress.done();
    console.error(error);
    Promise.error(error);
  }
);

// 响应拦截器
instance.interceptors.response.use(
  // 请求成功
  res => {
    NProgress.done();
    return res.status === 200 ? Promise.resolve(res) : Promise.reject(res);
  },
  // 请求失败
  error => {
    NProgress.done();
    const { response } = error;
    if (response) {
      // 请求已发出，但是不在2xx的范围
      errorHandle(response);
    } else {
      // 断网
      toast("无法连接到服务器,请检查网络", { color: "error" });
      store.commit("changeNetwork", { network: false });
    }
    return Promise.reject(response);
  }
);

export default instance;
