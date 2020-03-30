module.exports = file => () =>
  import(/* webpackChunkName: "modules" */ "@/views/" + file);
// import("@/views/" + file);
