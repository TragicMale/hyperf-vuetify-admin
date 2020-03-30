<template>
  <v-dialog v-model="dialog" max-width="500px" scrollable>
    <v-card>
      <v-card-title>
        <span class="headline">菜单权限：{{role.name}}</span>
        <v-spacer></v-spacer>
        <v-switch v-model="openAll" class="mr-2" label="展开/关闭"></v-switch>
      </v-card-title>
      <v-card-text style="max-height: 450px;">
        <v-treeview
          ref="tree"
          :items="menus"
          v-model="roleMenus"
          selectable
          hoverable
          open-on-click
          :open-all="openAll"
          transition
        >
          <template v-slot:prepend="{ item }">
            <v-tooltip bottom>
              <template v-slot:activator="{ on }">
                <v-icon
                  small
                  v-on="on"
                  color="primary"
                >{{item.type==1?'mdi-menu':'mdi-gesture-tap-hold'}}</v-icon>
              </template>
              <span>{{item.type==1?'菜单':'按钮'}}</span>
            </v-tooltip>
          </template>
        </v-treeview>
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
import findAllParent from "../../../utils/tree";

import uniq from "lodash/uniq";

export default {
  data: function() {
    return {
      dialog: false,
      openAll: false,
      menus: [],
      role: {},
      roleMenus: []
    };
  },
  watch: {
    openAll(val) {
      this.$refs.tree.updateAll(val);
    }
  },
  created() {
    this.getMenus();
  },
  methods: {
    showForm(role) {
      this.getRoleMenus(role.id);
      this.role = role;
      this.dialog = true;
    },
    close() {
      this.role = [];
      this.roleMenus = [];
      this.dialog = false;
    },
    save() {
      let roleMenusWithParents = [];
      this.roleMenus.map(menuId => {
        let nodes = findAllParent(menuId, this.menus);
        nodes.push(menuId);
        roleMenusWithParents = uniq(roleMenusWithParents.concat(nodes));
      });
      roleService
        .setRoleMenus(this.role.id, this.roleMenus, roleMenusWithParents)
        .then(() => {
          this.close();
        });
    },
    getMenus() {
      systemService.getAllMenus().then(({ data }) => {
        this.menus = data;
      });
    },
    getRoleMenus(roleId) {
      roleService.getRoleMenus(roleId).then(({ data }) => {
        this.roleMenus = data;
      });
    }
  }
};
</script>