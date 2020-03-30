<template>
  <v-dialog v-model="dialog" max-width="500px" scrollable>
    <v-card>
      <v-card-title>
        <span class="headline">权限管理：{{role.name}}</span>
        <v-spacer></v-spacer>
        <v-switch v-model="openAll" class="mr-2" label="展开/关闭"></v-switch>
      </v-card-title>
      <v-card-text style="max-height: 450px;">
        <v-treeview
          ref="tree"
          v-model="roleResources"
          :items="resources"
          item-text="p"
          item-key="p"
          selectable
          hoverable
          open-on-click
          :open-all="openAll"
          transition
        ></v-treeview>
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
import * as systemService from "../../../apis/system";
import * as roleService from "../../../apis/role";

export default {
  data: function() {
    return {
      dialog: false,
      openAll: false,
      resources: [],
      role: {},
      roleResources: []
    };
  },
  watch: {
    openAll(val) {
      this.$refs.tree.updateAll(val);
    }
  },
  created() {
    this.getResources();
  },
  methods: {
    showForm(role) {
      this.getRoleResources(role.id);
      this.role = role;
      this.dialog = true;
    },
    close() {
      this.role = {};
      this.roleResources = [];
      this.dialog = false;
    },
    save() {
      roleService
        .setRoleResources(this.role.id, this.roleResources)
        .then(() => {
          this.close();
        });
    },
    getResources() {
      systemService.getAllResources().then(({ data }) => {
        this.resources = data;
      });
    },
    getRoleResources(roleId) {
      roleService.getRoleResources(roleId).then(({ data }) => {
        this.roleResources = data;
      });
    }
  }
};
</script>