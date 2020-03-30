import Cookie from "js-cookie";
import store from "../store/index";

const TokenKey = "token";

export function setToken(token) {
  Cookie.set(TokenKey, token);
  store.commit("user/setToken", token);
}

export function getToken() {
  return store.state.user.token ? store.state.user.token : Cookie.get(TokenKey);
}

export function removeToken() {
  Cookie.remove(TokenKey);
  store.commit("user/setToken", null);
}
