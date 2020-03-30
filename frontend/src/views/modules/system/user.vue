<template>
  <v-container fluid>
    <v-container>
      <v-row>
        <v-col>
          <v-text-field label="账号" v-model="filter.username" clearable></v-text-field>
        </v-col>
        <v-col>
          <v-select
            label="角色"
            v-model="filter.role"
            :items="roles"
            item-value="id"
            item-text="name"
            clearable
          ></v-select>
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
          <v-toolbar-title>用户管理</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>

          <v-btn color="primary" dark @click.stop="newItem" v-permission="'user:edit'">
            <v-icon left>mdi-plus</v-icon>新建用户
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
        <v-tooltip bottom v-permission="'user:edit'">
          <template v-slot:activator="{ on }">
            <v-icon small class="mr-2" v-on="on" @click="editItem(item)">mdi-pencil</v-icon>
          </template>
          <span>用户信息</span>
        </v-tooltip>
        <v-tooltip bottom v-permission="'user:setRole'">
          <template v-slot:activator="{ on }">
            <v-icon small class="mr-2" v-on="on" @click="editRole(item)">mdi-account-plus</v-icon>
          </template>
          <span>分配角色</span>
        </v-tooltip>
        <v-tooltip bottom v-permission="'user:delete'">
          <template v-slot:activator="{ on }">
            <v-icon small v-on="on" @click="deleteItem(item)">mdi-delete</v-icon>
          </template>
          <span>删除用户</span>
        </v-tooltip>
      </template>
    </v-data-table>

    <user-form ref="userForm" @afterSave="fetchData"></user-form>
    <user-role ref="userRole"></user-role>
  </v-container>
</template>
<script>
import * as userService from "../../../apis/user";
import * as systemService from "../../../apis/system";
import UserForm from "./userForm.vue";
import UserRole from "./userRole.vue";
import { toast } from "../../../utils";

export default {
  components: { UserForm, UserRole },
  data: () => ({
    states: [
      { text: "启用", value: "1" },
      { text: "禁用", value: "2" }
    ],
    roles: [],
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
        { text: "账号", value: "username" },
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
  created() {
    this.initRoles();
  },
  methods: {
    initRoles() {
      systemService.getAllRoles().then(({ data }) => {
        this.roles = data;
      });
    },
    fetchData() {
      this.editDialog = false;
      this.editId = null;
      this.table.loading = true;
      userService.list(this.table.options, this.filter).then(({ data }) => {
        this.table.loading = false;
        this.table.items = data.data;
        this.totalRecords = data.total;
      });
    },
    newItem() {
      this.$refs.userForm.showForm();
    },
    editItem(item) {
      this.$refs.userForm.showForm(item.id);
    },
    deleteItem(item) {
      this.$root.$confirm("确认消息", "要删除该记录吗？").then(confirm => {
        if (confirm) {
          userService.remove(item.id).then(() => {
            toast("删除成功");
            this.fetchData();
          });
        }
      });
    },
    editRole(item) {
      this.$refs.userRole.showForm(item);
    }
  }
};
</script>