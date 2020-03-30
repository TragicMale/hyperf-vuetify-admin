<template>
  <v-container fluid>
    <v-container>
      <v-row>
        <v-col>
          <v-text-field label="名称" v-model="search" clearable></v-text-field>
        </v-col>
        <v-col>
          <v-select label="状态" v-model="filter.state" :items="states" clearable></v-select>
        </v-col>
      </v-row>
    </v-container>

    <v-row class="pa-4" justify="space-between">
      <v-col cols="6">
        <v-row>
          <v-switch class="ml-4" label="展开/关闭" v-model="tree.openAll">updateAll</v-switch>
          <v-spacer></v-spacer>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-btn icon class="mr-4" v-on="on" @click="newItem()" v-permission="'menu:edit'">
                <v-icon>mdi-plus</v-icon>
              </v-btn>
            </template>
            <span>新建菜单</span>
          </v-tooltip>
          <v-tooltip bottom>
            <template v-slot:activator="{ on }">
              <v-btn
                icon
                class="mr-8"
                v-on="on"
                @click="fetchData(true)"
                v-permission="'menu:edit'"
              >
                <v-icon>mdi-refresh</v-icon>
              </v-btn>
            </template>
            <span>刷新</span>
          </v-tooltip>
        </v-row>
        <v-treeview ref="tree" :items="tree.items" :search="search" activatable transition>
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
          <template v-slot:label="{ item }">
            <v-btn tile depressed>
              <v-icon
                left
                dense
                small
                v-if="item.type == 1 && item.icon"
                v-text="`mdi-${item.icon}`"
              ></v-icon>
              {{item.name}}
            </v-btn>
            <div class="d-inline ml-10">
              <v-tooltip bottom v-permission="'menu:edit'">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    class="ml-2"
                    color="teal"
                    v-on="on"
                    @click="editItem(item)"
                  >mdi-pencil</v-icon>
                </template>
                <span>编辑菜单</span>
              </v-tooltip>
              <v-tooltip bottom v-if="item.type == 1" v-permission="'menu:edit'">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    class="ml-2"
                    color="teal"
                    v-on="on"
                    @click="addSubItem(item)"
                  >mdi-plus-thick</v-icon>
                </template>
                <span>添加子菜单</span>
              </v-tooltip>
              <v-tooltip bottom v-permission="'menu:delete'">
                <template v-slot:activator="{ on }">
                  <v-icon
                    small
                    class="ml-2"
                    color="teal"
                    v-on="on"
                    @click="deleteItem(item)"
                  >mdi-delete</v-icon>
                </template>
                <span>删除菜单</span>
              </v-tooltip>
            </div>
          </template>
        </v-treeview>
      </v-col>

      <v-divider vertical></v-divider>

      <v-col class="text-center">
        <v-scroll-y-transition mode="out-in">
          <div class="title grey--text text--lighten-1 font-weight-light">show something here</div>
        </v-scroll-y-transition>
      </v-col>
    </v-row>

    <menu-form ref="menuForm" @afterSave="fetchData"></menu-form>
  </v-container>
</template>
<script>
import * as menuService from "../../../apis/menu";
import MenuForm from "./menuForm.vue";
import { toast } from "../../../utils";

export default {
  components: { MenuForm },
  data: () => ({
    states: [
      { text: "启用", value: "1" },
      { text: "禁用", value: "2" }
    ],
    search: "",
    filter: {
      state: ""
    },
    tree: {
      openAll: false,
      items: []
    },
    totalRecords: 0,
    selectedItem: null
  }),
  watch: {
    "tree.openAll": function(val) {
      this.$refs.tree.updateAll(val);
    },
    filter: {
      handler() {
        this.fetchData();
      },
      deep: true
    }
  },
  created() {
    this.fetchData();
  },
  methods: {
    fetchData(snackbar = false) {
      menuService.list(this.filter).then(({ data }) => {
        this.tree.items = data;
        snackbar === true && toast("刷新完成", { color: "info" });
      });
    },
    newItem() {
      this.$refs.menuForm.showAdd();
    },
    editItem(item) {
      this.$refs.menuForm.showEdit(item.id);
    },
    addSubItem(item) {
      this.$refs.menuForm.showAddSub(item.id);
    },
    deleteItem(item) {
      this.$root.$confirm("确认消息", "要删除该记录吗？").then(confirm => {
        if (confirm) {
          menuService.remove(item.id).then(() => {
            toast("删除成功");
            this.fetchData();
          });
        }
      });
    }
  }
};
</script>