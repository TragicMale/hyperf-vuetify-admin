<template>
  <v-dialog v-model="dialog" max-width="500px" scrollable @input="closeHandler">
    <v-card>
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <v-form ref="form" @submit.prevent="handleSubmit(save)">
          <v-card-title flat>
            <span class="headline">{{ formTitle }}</span>

            <v-tabs v-model="tabIndex" fixed-tabs color="indigo">
              <v-tab>菜单</v-tab>
              <v-tab>按钮</v-tab>
            </v-tabs>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="6" md="6">
                  <VTextFieldWithValidation
                    v-model="item.name"
                    label="名称"
                    rules="required|min:2|max:24"
                    clearable
                    counter
                  ></VTextFieldWithValidation>
                </v-col>
                <v-col cols="12" sm="6" md="6" v-if="item.type==1">
                  <v-text-field v-model="item.icon" label="图标" clearable counter></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" v-if="item.type==2">
                  <v-text-field v-model="item.path" label="按钮标识" clearable counter></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12" v-if="item.type==1">
                  <v-text-field v-model="item.path" label="前端路由" clearable counter></v-text-field>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <v-radio-group v-model="item.state" mandatory row>
                    <v-radio label="启用" :value="1"></v-radio>
                    <v-radio label="禁用" :value="2"></v-radio>
                  </v-radio-group>
                </v-col>
                <v-col cols="12" sm="6" md="6" v-if="formType=='edit'">
                  <v-text-field v-model="item.created_at" readonly disabled label="创建时间"></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" v-if="formType=='edit'">
                  <v-text-field v-model="item.updated_at" readonly disabled label="更新时间"></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click.stop="close">取消</v-btn>
            <v-btn color="blue darken-1" text type="submit">保存</v-btn>
          </v-card-actions>
        </v-form>
      </ValidationObserver>
    </v-card>
  </v-dialog>
</template>
<script>
import { ValidationObserver } from "vee-validate";
import VTextFieldWithValidation from "../../../components/VTextFieldWithValidation.vue";

import * as menuService from "../../../apis/menu";
export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation
  },
  data: function() {
    return {
      dialog: false,
      defaultItem: {
        type: 1,
        state: 1
      },
      item: {}
    };
  },
  created() {
    this.resetForm();
  },
  computed: {
    formTitle() {
      return this.item.id ? "编辑菜单" : "新建菜单";
    },
    tabIndex: {
      get() {
        return this.item.type - 1;
      },
      set(val) {
        this.item.type = val + 1;
        switch (this.item.type) {
          case 1:
            this.item.path = ""; // path = 前端路由/按钮标识
            break;
          case 2:
            this.item.path = "";
            this.item.icon = "";
            break;
        }
      }
    }
  },
  methods: {
    // 新建菜单
    showAdd() {
      this.formType = "create";
      this.dialog = true;
    },
    // 编辑菜单
    showEdit(id) {
      this.formType = "edit";
      this.dialog = true;
      this.item.id = id;
      this.getMenu(id);
    },
    // 添加子菜单
    showAddSub(id) {
      this.formType = "sub";
      this.dialog = true;
      this.item.pid = id;
    },
    getMenu(id) {
      menuService.get(id).then(({ data }) => {
        this.item = data;
      });
    },
    // 点击dialog外部关闭时触发
    closeHandler(val) {
      if (val == false) {
        this.close();
      }
    },
    close() {
      this.dialog = false;
      this.resetForm();
      this.$nextTick(() => {
        this.$refs.observer.reset(); // 重置验证状态
      });
    },
    resetForm() {
      this.item = Object.assign({}, this.defaultItem);
    },
    save() {
      delete this.item.created_at;
      delete this.item.updated_at;

      if (this.formType == "edit") {
        menuService.save(this.item.id, this.item).then(() => {
          this.close();
          this.$emit("afterSave");
        });
      } else {
        menuService.add(this.item).then(() => {
          this.close();
          this.$emit("afterSave");
        });
      }
    }
  }
};
</script>