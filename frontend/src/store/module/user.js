export default {
  namespaced: true,
  state: {
    token: null,
    id: "",
    username: ""
  },
  mutations: {
    setToken(state, token) {
      state.token = token;
    },
    updateAccountInfo(state, accountInfo) {
      state.id = accountInfo.id;
      state.username = accountInfo.username;
    }
  }
};
