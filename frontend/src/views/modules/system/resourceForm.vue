<template>
  <v-dialog v-model="dialog" max-width="500px" scrollable @input="dialogClose">
    <v-card>
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <v-form ref="form" @submit.prevent="handleSubmit(save)">
          <v-card-title>
            <span class="headline">{{formTitle}}</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="12" md="12">
                  <VTextFieldWithValidation
                    label="资源路径"
                    v-model="item.path"
                    rules="required|max:64"
                    :readonly="isEditForm"
                    :clearable="formType=='create'"
                    counter
                  ></VTextFieldWithValidation>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <ValidationProvider v-slot="{ valid, errors }" name="操作权限" rules="required">
                    <v-select
                      label="操作权限"
                      v-model="item.action"
                      :items="actions"
                      :readonly="isEditForm"
                      :clearable="!isEditForm"
                      :success="valid"
                      :error-messages="errors"
                    ></v-select>
                  </ValidationProvider>
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
            <v-btn color="blue darken-1" text @click.stop="close">关闭</v-btn>
            <v-btn v-if="!isEditForm" color="blue darken-1" text type="subbmit">保存</v-btn>
          </v-card-actions>
        </v-form>
      </ValidationObserver>
    </v-card>
  </v-dialog>
</template>
<script>
import { ValidationObserver, ValidationProvider } from "vee-validate";
import VTextFieldWithValidation from "../../../components/VTextFieldWithValidation.vue";

import * as resourceService from "../../../apis/resource";
import { toast } from "../../../utils";
export default {
  components: {
    ValidationObserver,
    ValidationProvider,
    VTextFieldWithValidation
  },
  data: function() {
    return {
      actions: [
        { text: "GET", value: "GET" },
        { text: "POST", value: "POST" },
        { text: "PATCH", value: "PATCH" },
        { text: "DELETE", value: "DELETE" }
      ],
      formType: "create",
      dialog: false,
      item: {}
    };
  },
  computed: {
    isEditForm() {
      return this.formType == "edit";
    },
    formTitle() {
      return this.isEditForm ? "权限详情" : "新建权限";
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
    },
    getItem(id) {
      resourceService.get(id).then(({ data }) => {
        this.item = data;
      });
    },
    save() {
      resourceService.add(this.item).then(({ data }) => {
        this.close();
        if (data) {
          toast("保存成功");
          this.$emit("afterSave");
        }
      });
    }
  }
};
</script>