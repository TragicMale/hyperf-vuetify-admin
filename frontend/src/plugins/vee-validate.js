import { localize, extend } from "vee-validate";
import { required, min, max, confirmed } from "vee-validate/dist/rules";
import zh_CN from "vee-validate/dist/locale/zh_CN.json";

localize("zh_CN", zh_CN);

// 引入需要使用的验证规则

extend("required", {
  ...required
  // message: "该字段为必填项"
});

extend("min", {
  ...min
  // message: "不少于 {length} 位"
});

extend("max", {
  ...max
  // message: "不大于 {length} 位"
});

extend("confirmed", {
  ...confirmed,
  message: "两次密码输入不一致"
});
