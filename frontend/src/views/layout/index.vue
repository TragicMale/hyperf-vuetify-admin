<template>
  <v-app id="app" style="background-color:#fafafa">
    <!-- <v-system-bar app></v-system-bar> -->

    <v-app-bar :clipped-left="clipped" app color="blue darken-3" dark elevate-on-scroll>
      <v-app-bar-nav-icon @click.stop="drawer = !drawer" />
      <v-toolbar-title style="width: 200px" class="ml-0 pl-4">
        <span class="hidden-sm-and-down">Vuetify-Admin</span>
      </v-toolbar-title>

      <v-text-field
        flat
        solo-inverted
        hide-details
        prepend-inner-icon="mdi-magnify"
        label="Search"
        class="hidden-sm-and-down my-auto"
      />

      <v-spacer></v-spacer>

      <bar-menu></bar-menu>
    </v-app-bar>

    <v-navigation-drawer v-model="drawer" :clipped="clipped" app>
      <left-menu :menu-list="menuList"></left-menu>
    </v-navigation-drawer>

    <v-content>
      <!-- <v-fade-transition> -->
      <router-view></router-view>
      <!-- </v-fade-transition> -->
    </v-content>

    <!-- <v-footer inset app>
      <span class="mx-auto">&copy; {{ new Date().getFullYear() }}</span>
    </v-footer>-->
  </v-app>
</template>

<script>
import LeftMenu from "./components/LeftMenu.vue";
import BarMenu from "./components/BarMenu.vue";

import { accountInfo } from "../../apis/auth";

export default {
  components: { LeftMenu, BarMenu },
  data: () => ({
    drawer: null,
    clipped: true,
    menuList: []
  }),
  created() {
    this.menuList = JSON.parse(
      JSON.stringify(this.$store.state.common.menuList)
    );
    this.getAccountInfo();
  },
  methods: {
    getAccountInfo() {
      accountInfo().then(({ data }) => {
        this.$store.commit("user/updateAccountInfo", data);
      });
    }
  }
};
</script>