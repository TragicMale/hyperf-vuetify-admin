<template>
  <v-app>
    <v-content>
      <div id="particlesId"></div>
      <v-container class="fill-height" fluid>
        <v-row align="center" justify="center">
          <v-col cols="12" sm="8" md="4">
            <v-card class="elevation-12">
              <v-toolbar color="primary" dark flat>
                <v-toolbar-title>用户登录</v-toolbar-title>
              </v-toolbar>
              <v-card-text>
                <ValidationObserver ref="loginForm" v-slot="{ handleSubmit }">
                  <v-form @submit.prevent="handleSubmit(login)">
                    <ValidationProvider
                      v-slot="{ valid, errors }"
                      name="账号"
                      rules="required|min:4|max:16"
                    >
                      <v-text-field
                        label="帐号"
                        hint="请输入账号"
                        name="username"
                        prepend-icon="mdi-account"
                        type="text"
                        counter
                        clearable
                        v-model="username"
                        :success="valid"
                        :error-messages="errors"
                      ></v-text-field>
                    </ValidationProvider>
                    <ValidationProvider
                      v-slot="{ valid, errors }"
                      name="密码"
                      rules="required|min:6|max:28"
                    >
                      <v-text-field
                        label="密码"
                        hint="请输入密码"
                        name="password"
                        prepend-icon="mdi-lock"
                        :type="showPassword ? 'text' : 'password'"
                        counter
                        clearable
                        :append-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                        @click:append="showPassword = !showPassword"
                        v-model="password"
                        :success="valid"
                        :error-messages="errors"
                      ></v-text-field>
                    </ValidationProvider>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn class="mr-2" color="primary" type="submit">登 录</v-btn>
                    </v-card-actions>
                  </v-form>
                </ValidationObserver>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-container>
    </v-content>
  </v-app>
</template>

<script>
import { ValidationObserver, ValidationProvider } from "vee-validate";

import * as authService from "../../apis/auth";
import { setToken } from "../../utils/user";
import "particles.js";
import particlesConfig from "../../assets/particles.json";

export default {
  components: {
    ValidationObserver,
    ValidationProvider
  },
  data() {
    return {
      username: "",
      password: "",
      showPassword: false,
      redirect: undefined
    };
  },
  watch: {
    $route: {
      handler: function(route) {
        const query = route.query;
        if (query) {
          this.redirect = query.redirect;
          this.otherQuery = this.getOtherQuery(query);
        }
      },
      immediate: true
    }
  },
  mounted() {
    this.initParticles();
  },
  methods: {
    initParticles() {
      window.particlesJS("particlesId", particlesConfig);
    },
    login() {
      authService.login(this.username, this.password).then(({ data }) => {
        if (data.token) {
          setToken(data.token);
          this.$router
            .push({
              path: this.redirect || "/",
              query: this.otherQuery
            })
            .catch(err => err);
        }
      });
    },
    getOtherQuery(query) {
      return Object.keys(query).reduce((perv, cur) => {
        if (cur !== "redirect") {
          perv[cur] = query[cur];
        }
        return perv;
      }, {});
    }
  }
};
</script>
<style scoped>
#particlesId {
  position: absolute;
  width: 100%;
  height: 100%;
  background-color: rgb(35, 39, 65);
  background-repeat: no-repeat;
  background-size: cover;
  background-position: 50% 50%;
}
</style>
