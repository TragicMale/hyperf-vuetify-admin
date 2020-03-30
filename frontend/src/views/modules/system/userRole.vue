<template>
  <v-dialog v-model="dialog" max-width="500px" scrollable>
    <v-card>
      <v-card-title>
        <span class="headline">角色分配：{{user.username}}</span>
      </v-card-title>
      <v-card-text style="height: 300px;">
        <v-select
          v-model="userRoles"
          :items="roles"
          item-text="name"
          item-value="id"
          label="选择角色"
          chips
          multiple
          clearable
        ></v-select>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click.stop="close">取消</v-btn>
        <v-btn color="blue darken-1" text @click.stop="save">保存</v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>
<script>
import * as userService from "../../../apis/user";
import * as systemService from "../../../apis/system";
import { toast } from "../../../utils";

export default {
  data: function() {
    return {
      dialog: false,
      roles: [],
      user: {},
      userRoles: []
    };
  },
  created() {
    this.getRoles();
  },
  methods: {
    showForm(user) {
      this.getUserRoles(user.id);
      this.user = user;
      this.dialog = true;
    },
    close() {
      this.user = {};
      this.userRoles = [];
      this.dialog = false;
    },
    save() {
      userService
        .setUserRoles(this.user.id, this.userRoles)
        .then(({ data }) => {
          this.close();
          if (data) {
            toast("保存成功");
          }
        });
    },
    getRoles() {
      systemService.getAllRoles().then(({ data }) => {
        this.roles = data;
      });
    },
    getUserRoles(userId) {
      userService.getUserRoles(userId).then(({ data }) => {
        this.userRoles = data;
      });
    }
  }
};
</script>