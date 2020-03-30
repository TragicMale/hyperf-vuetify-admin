<template>
  <v-dialog v-model="dialog" max-width="500px" scrollable @input="closeHandler">
    <v-card>
      <ValidationObserver ref="observer" v-slot="{ handleSubmit }">
        <v-form ref="form" @submit.prevent="handleSubmit(save)">
          <v-card-title>
            <span class="headline">修改密码</span>
          </v-card-title>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12" sm="12" md="12">
                  <VTextFieldWithValidation
                    v-model="item.old_password"
                    label="旧密码"
                    prepend-icon="mdi-lock"
                    rules="required|min:6|max:28"
                    type="password"
                    clearable
                    counter
                  ></VTextFieldWithValidation>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <VTextFieldWithValidation
                    v-model="item.new_password"
                    label="新密码"
                    prepend-icon="mdi-lock"
                    rules="required|min:6|max:28"
                    type="password"
                    clearable
                    counter
                  ></VTextFieldWithValidation>
                </v-col>
                <v-col cols="12" sm="12" md="12">
                  <VTextFieldWithValidation
                    v-model="item.new_password_confirmation"
                    label="重复新密码"
                    prepend-icon="mdi-lock"
                    rules="confirmed:新密码"
                    type="password"
                    clearable
                    counter
                  ></VTextFieldWithValidation>
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

import * as authService from "../../../apis/auth";

export default {
  components: {
    ValidationObserver,
    VTextFieldWithValidation
  },
  data: function() {
    return {
      dialog: false,
      item: {}
    };
  },
  methods: {
    showForm() {
      this.dialog = true;
    },
    // 点击dialog外部关闭时触发
    closeHandler(val) {
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
    save() {
      authService.newPassword(this.item).then(() => {
        this.close();
      });
    }
  }
};
</script>