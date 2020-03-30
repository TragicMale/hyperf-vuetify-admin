<template>
  <v-dialog v-model="dialog" max-width="500px" scrollable @input="dialogClose">
    <v-card>
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <v-form ref="form" @submit.prevent="handleSubmit(save)">
          <v-card-title>
            <span class="headline">{{ formTitle }}</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="12" md="6">
                  <VTextFieldWithValidation
                    v-model="item.name"
                    label="角色名"
                    rules="required|min:2|max:24"
                    clearable
                    counter
                  ></VTextFieldWithValidation>
                </v-col>
                <v-col cols="12" sm="12" md="6">
                  <VTextFieldWithValidation
                    v-model="item.key"
                    label="标识"
                    rules="required|min:4|max:24"
                    clearable
                    counter
                  ></VTextFieldWithValidation>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <VTextFieldWithValidation
                    v-model="item.remark"
                    label="描述"
                    rules="max:32"
                    clearable
                    counter
                  ></VTextFieldWithValidation>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <v-radio-group v-model="item.state" mandatory row>
                    <v-radio label="启用" :value="1"></v-radio>
                    <v-radio label="禁用" :value="2"></v-radio>
                  </v-radio-group>
                </v-col>
                <v-col cols="12" sm="6" md="6" v-if="isEditForm">
                  <v-text-field v-model="item.created_at" readonly disabled label="创建时间"></v-text-field>
                </v-col>
                <v-col cols="12" sm="6" md="6" v-if="isEditForm">
                  <v-text-field v-model="item.updated_at" readonly disabled label="更新时间"></v-text-field>
                </v-col>
              </v-row>
            </v-container>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue-grey" text @click.stop="close">取消</v-btn>
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

import * as roleService from "../../../apis/role";
import { toast } from "../../../utils";
export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation
  },
  data: function() {
    return {
      dialog: false,
      formType: "create",
      item: {}
    };
  },
  computed: {
    isEditForm() {
      return this.formType == "edit";
    },
    formTitle() {
      return this.isEditForm ? "编辑角色" : "新建角色";
    }
  },
  methods: {
    showForm(id = null) {
      if (id) {
        this.formType = "edit";
        this.getItem(id);
        this.item.id = id;
      } else {
        this.formType = "create";
      }
      this.dialog = true;
    },
    // 点击dialog外部 关闭时，不会触发close
    dialogClose(val) {
      if (val == false) {
        this.close();
      }
    },
    close() {
      this.dialog = false;
      this.item = {};
      this.$nextTick(() => {
        this.$refs.observer.reset(); // 重置验证状态
      });
      this.$emit("update:editId", null);
    },
    save() {
      delete this.item.created_at;
      delete this.item.updated_at;
      if (this.isEditForm) {
        roleService.save(this.item.id, this.item).then(({ data }) => {
          this.close();
          if (data) {
            toast("保存成功");
            this.$emit("afterSave");
          }
        });
      } else {
        roleService.add(this.item).then(({ data }) => {
          this.close();
          if (data) {
            toast("保存成功");
            this.$emit("afterSave");
          }
        });
      }
    },
    getItem(id) {
      roleService.get(id).then(({ data }) => {
        this.item = data;
      });
    }
  }
};
</script>