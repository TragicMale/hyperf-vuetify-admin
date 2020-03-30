export default {
  namespaced: true,
  state: {
    content: "",
    options: {}
  },
  mutations: {
    showMessage(state, payload) {
      state.content = payload.content;
      state.options = payload.options;
    }
  }
};
