export default {
  namespaced: true,
  state: {
    menuList: [],
    btnList: [],
    menuActiveName: ""
  },
  mutations: {
    updateMenuList(state, list) {
      state.menuList = list;
    },
    updateBtnList(state, list) {
      state.btnList = list;
    }
  },
  actions: {}
};
