<template>
  <v-app>
    <Snackbar></Snackbar>
    <Confirm ref="confirm"></Confirm>
    <v-fade-transition>
      <router-view></router-view>
    </v-fade-transition>
  </v-app>
</template>
<script>
import Snackbar from "./components/Snackbar.vue";
import Confirm from "./components/Confirm.vue";
import "nprogress/nprogress.css";
export default {
  components: { Snackbar, Confirm },
  mounted() {
    this.$root.$confirm = this.$refs.confirm.open;
  }
};
</script>
<style>
#nprogress .bar {
  background: #4caf50 !important;
}
</style>