<template>
  <v-container fluid>
    <v-container>
      <v-row>
        <v-col>
          <v-text-field label="名称" v-model="filter.name" clearable></v-text-field>
        </v-col>
        <v-col>
          <v-text-field label="标识" v-model="filter.key" clearable></v-text-field>
        </v-col>
        <v-col>
          <v-select label="状态" v-model="filter.state" :items="states" clearable></v-select>
        </v-col>
      </v-row>
    </v-container>

    <v-data-table
      :headers="table.headers"
      :items="table.items"
      :options.sync="table.options"
      :server-items-length="totalRecords"
      :loading="table.loading"
      loading-text="努力加载中... 请稍等"
      no-data-text="暂无数据"
      no-results-text="未找到相关数据"
      class="elevation-1"
      :footer-props="{showFirstLastPage: true,'items-per-page-options': [5, 10, 15, 20, 50]}"
    >
      <template v-slot:top>
        <v-toolbar flat>
          <v-toolbar-title>角色管理</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>

          <v-btn color="primary" dark @click.stop="newItem" v-permission="'role:edit'">
            <v-icon left>mdi-plus</v-icon>新建角色
          </v-btn>

          <v-spacer></v-spacer>

          <v-btn color="primary" dark @click="fetchData">
            <v-icon left>mdi-magnify</v-icon>查询
          </v-btn>
        </v-toolbar>
      </template>
      <template v-slot:item.state="{ item }">
        <v-chip :color="item.state==1?'green':'orange'" dark>{{ item.state==1?'启用':'禁用' }}</v-chip>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-tooltip bottom v-permission="'role:edit'">
          <template v-slot:activator="{ on }">
            <v-icon small class="mr-2" v-on="on" @click="editItem(item)">mdi-pencil</v-icon>
          </template>
          <span>角色信息</span>
        </v-tooltip>
        <v-tooltip bottom v-permission="'role:setMenu'">
          <template v-slot:activator="{ on }">
            <v-icon small class="mr-2" v-on="on" @click="editMenu(item)">mdi-menu</v-icon>
          </template>
          <span>菜单权限</span>
        </v-tooltip>
        <v-tooltip bottom v-permission="'role:setResource'">
          <template v-slot:activator="{ on }">
            <v-icon small class="mr-2" v-on="on" @click="editResource(item)">mdi-key</v-icon>
          </template>
          <span>资源权限</span>
        </v-tooltip>
        <v-tooltip bottom v-permission="'role:delete'">
          <template v-slot:activator="{ on }">
            <v-icon small v-on="on" @click="deleteItem(item)">mdi-delete</v-icon>
          </template>
          <span>删除角色</span>
        </v-tooltip>
      </template>
    </v-data-table>

    <role-form ref="roleForm" @afterSave="fetchData"></role-form>
    <role-menu ref="roleMenu"></role-menu>
    <role-resource ref="roleResource"></role-resource>
  </v-container>
</template>
<script>
import * as roleService from "../../../apis/role";
import RoleForm from "./roleForm.vue";
import RoleMenu from "./roleMenu.vue";
import RoleResource from "./roleResource.vue";
import { toast } from "../../../utils";

export default {
  components: { RoleForm, RoleMenu, RoleResource },
  data: () => ({
    states: [
      { text: "启用", value: "1" },
      { text: "禁用", value: "2" }
    ],
    filter: {
      name: "",
      role: "",
      state: ""
    },
    table: {
      options: {},
      loading: false,
      headers: [
        { text: "ID", value: "id" },
        { text: "名称", value: "name" },
        { text: "标识", value: "key" },
        { text: "备注", value: "remark" },
        { text: "状态", value: "state" },
        { text: "创建时间", value: "created_at" },
        { text: "更新时间", value: "updated_at" },
        { text: "操作", value: "actions", sortable: false }
      ],
      items: []
    },
    totalRecords: 0
  }),

  watch: {
    "table.options": {
      handler() {
        this.fetchData();
      },
      deep: true
    }
  },
  methods: {
    fetchData() {
      this.editDialog = false;
      this.editId = null;
      this.table.loading = true;
      roleService.list(this.table.options, this.filter).then(({ data }) => {
        this.table.loading = false;
        this.table.items = data.data;
        this.totalRecords = data.total;
      });
    },
    newItem() {
      this.$refs.roleForm.showForm();
    },
    editItem(item) {
      this.$refs.roleForm.showForm(item.id);
    },
    deleteItem(item) {
      this.$root.$confirm("确认消息", "要删除该记录吗？").then(confirm => {
        if (confirm) {
          roleService.remove(item.id).then(() => {
            toast("删除成功");
            this.fetchData();
          });
        }
      });
    },
    editMenu(item) {
      this.$refs.roleMenu.showForm(item);
    },
    editResource(item) {
      this.$refs.roleResource.showForm(item);
    }
  }
};
</script>