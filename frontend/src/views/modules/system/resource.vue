<template>
  <v-container fluid>
    <v-container>
      <v-row>
        <v-col>
          <v-text-field label="资源路径" v-model="filter.path" clearable></v-text-field>
        </v-col>
        <v-col>
          <v-select label="操作权限" v-model="filter.action" :items="actions" clearable></v-select>
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
          <v-toolbar-title>权限管理</v-toolbar-title>
          <v-divider class="mx-4" inset vertical></v-divider>

          <v-btn color="primary" dark @click.stop="newItem" v-permission="'resource:edit'">
            <v-icon left>mdi-plus</v-icon>新建权限
          </v-btn>

          <v-spacer></v-spacer>

          <v-btn color="primary" dark @click="fetchData">
            <v-icon left>mdi-magnify</v-icon>查询
          </v-btn>
        </v-toolbar>
      </template>
      <template v-slot:item.actions="{ item }">
        <v-tooltip bottom>
          <template v-slot:activator="{ on }">
            <v-icon small class="mr-2" v-on="on" @click="showItem(item)">mdi-eye</v-icon>
          </template>
          <span>查看权限</span>
        </v-tooltip>
        <v-tooltip bottom v-permission="'resource:delete'">
          <template v-slot:activator="{ on }">
            <v-icon small class="mr-2" v-on="on" @click="deleteItem(item)">mdi-delete</v-icon>
          </template>
          <span>删除权限</span>
        </v-tooltip>
      </template>
    </v-data-table>

    <resource-form ref="resourceForm" @afterSave="fetchData"></resource-form>
  </v-container>
</template>
<script>
import * as resourceService from "../../../apis/resource";
import ResourceForm from "./resourceForm.vue";
import { toast } from "../../../utils";

export default {
  components: { ResourceForm },
  data: () => ({
    actions: [
      { text: "GET", value: "GET" },
      { text: "POST", value: "POST" },
      { text: "PATCH", value: "PATCH" },
      { text: "DELETE", value: "DELETE" }
    ],
    filter: {
      name: "",
      role: ""
    },
    table: {
      options: {},
      loading: false,
      headers: [
        { text: "ID", value: "id" },
        { text: "资源路径", value: "path" },
        { text: "操作权限", value: "action" },
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
      this.selectId = null;
      this.table.loading = true;
      resourceService.list(this.table.options, this.filter).then(({ data }) => {
        this.table.loading = false;
        this.table.items = data.data;
        this.totalRecords = data.total;
      });
    },
    newItem() {
      this.$refs.resourceForm.showForm();
    },
    showItem(item) {
      this.$refs.resourceForm.showForm(item.id);
    },
    deleteItem(item) {
      this.$root
        .$confirm("确认消息", "要删除该记录吗？已分配权限会失效。")
        .then(confirm => {
          if (confirm) {
            resourceService.remove(item.id).then(() => {
              toast("删除成功");
              this.fetchData();
            });
          }
        });
    }
  }
};
</script>