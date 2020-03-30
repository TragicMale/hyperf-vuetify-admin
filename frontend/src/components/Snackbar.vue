<template>
  <v-snackbar v-model="show" :color="options.color" :timeout="options.timeout" top>
    {{ message }}
    <v-btn dark icon @click="show = false;">
      <v-icon>{{ options.icon }}</v-icon>
    </v-btn>
  </v-snackbar>
</template>
<script>
export default {
  data() {
    return {
      show: false,
      message: "",
      options: {
        color: "success",
        timeout: 6000,
        icon: "mdi-close"
      }
    };
  },
  created() {
    this.$store.subscribe((mutation, state) => {
      if (mutation.type === "snackbar/showMessage") {
        this.message = state.snackbar.content;
        this.options = Object.assign(this.options, state.snackbar.options);

        this.show = true;
      }
    });
  }
};
</script>