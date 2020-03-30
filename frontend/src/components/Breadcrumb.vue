<template>
  <v-breadcrumbs :items="items" class="pb-0"></v-breadcrumbs>
</template>
<script>
export default {
  data() {
    return {
      items: [
        {
          text: "Dashboard",
          disabled: false,
          href: "http://baidu.com"
        }
      ]
    };
  },
  watch: {
    $route() {
      this.getBreadcrumbs();
    }
  },
  created() {
    this.getBreadcrumbs();
  },
  methods: {
    getBreadcrumbs() {
      let matched = this.$route.matched.filter(
        item => item.meta && item.meta.title
      );

      let breadcrumbs = [];
      matched.map(router => {
        if (router.meta && router.meta.title) {
          breadcrumbs.push({
            text: router.meta.title,
            href: router.path,
            disabled: router.meta.disabled
          });
        }
      });

      this.items = breadcrumbs;
    }
  }
};
</script>