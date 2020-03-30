<template>
  <v-list nav shaped>
    <template v-for="item in menuList">
      <v-list-group
        :key="item.id"
        v-if="item.children"
        v-model="item.open"
        :prepend-icon="item.icon?'mdi-' + item.icon:undefined"
        :no-action="subGroup"
        :sub-group="subGroup"
        :value="item.open"
      >
        <template v-slot:activator>
          <v-list-item-content>
            <v-list-item-title v-text="item.name"></v-list-item-title>
          </v-list-item-content>
        </template>
        <left-menu :menu-list="item.children" :sub-group="true"></left-menu>
      </v-list-group>
      <v-list-item v-else :key="item.id" :to="routeHandle(item.path)" link>
        <v-list-item-icon>
          <v-icon v-text="'mdi-'+item.icon"></v-icon>
        </v-list-item-icon>
        <v-list-item-title v-text="item.name"></v-list-item-title>
      </v-list-item>
    </template>
  </v-list>
</template>
<script>
export default {
  name: "LeftMenu",
  props: {
    menuList: {
      type: Array,
      required: true
    },
    subGroup: {
      type: Boolean,
      default: false
    }
  },
  methods: {
    routeHandle(routeKey) {
      if ("" == routeKey) {
        return "";
      }
      return { name: routeKey.trim("/").replace("/", "-") };
    }
  }
};
</script>