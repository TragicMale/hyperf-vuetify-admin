<template>
  <v-toolbar-items class="float-right">
    <v-btn icon>
      <v-icon>mdi-apps</v-icon>
    </v-btn>
    <v-btn icon>
      <v-icon>mdi-bell</v-icon>
    </v-btn>
    <v-btn icon>
      <v-badge color="pink" content="3" bordered>
        <v-icon>mdi-message</v-icon>
      </v-badge>
    </v-btn>
    <v-divider vertical class="mx-6"></v-divider>
    <v-menu bottom offset-y open-on-hover close-on-content-click>
      <template v-slot:activator="{ on }">
        <div v-on="on" class="ma-auto" style="width:60px">
          <v-avatar color="blue" size="36">{{username}}</v-avatar>
          <v-icon color="white" class="d-inline-flex">mdi-menu-down</v-icon>
        </div>
      </template>
      <v-list>
        <v-list-item @click="newPassword">
          <v-list-item-avatar>
            <v-icon>mdi-security</v-icon>
          </v-list-item-avatar>
          <v-list-item-content>
            <v-list-item-title>修改密码</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
        <v-list-item @click.stop="logout">
          <v-list-item-avatar>
            <v-icon>mdi-logout</v-icon>
          </v-list-item-avatar>
          <v-list-item-title>退出</v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
    <NewPassword ref="newPassword"></NewPassword>
  </v-toolbar-items>
</template>

<script>
import { removeToken } from "../../../utils/user";
import { resetRouter } from "../../../router/index";

import NewPassword from "./NewPassword.vue";

export default {
  components: { NewPassword },
  computed: {
    username() {
      return this.$store.state.user.username;
    }
  },
  methods: {
    newPassword() {
      this.$refs.newPassword.showForm();
    },
    logout() {
      this.$root.$confirm("确认消息", "要退出登录吗？").then(confirm => {
        if (confirm) {
          removeToken();
          this.$store.commit("common/updateMenuList", []);
          this.$store.commit("resetStore");
          resetRouter();
          this.$router.push({ name: "login" });
        }
      });
    }
  }
};
</script>