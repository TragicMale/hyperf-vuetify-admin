import axois from "../utils/http";
import { tableQueryFormatter } from "../utils/index";

export const list = (tableOptions, customParams) => {
  let params = tableQueryFormatter(tableOptions, customParams);
  return axois.get("/sys/roles", { params });
};

export const add = data => {
  return axois.post("/sys/roles", data);
};

export const save = (id, data) => {
  return axois.patch("/sys/roles/" + id, data);
};

export const get = id => {
  return axois.get("/sys/roles/" + id);
};

export const remove = id => {
  return axois.delete("/sys/roles/" + id);
};

export const getRoleMenus = roleId => {
  return axois.get("/sys/roleMenus/" + roleId);
};

export const setRoleMenus = (roleId, menus, menusWithParents) => {
  return axois.patch("/sys/roleMenus/" + roleId, { menus, menusWithParents });
};

export const getRoleResources = roleId => {
  return axois.get("/sys/roleResources/" + roleId);
};

export const setRoleResources = (roleId, resources) => {
  return axois.patch("/sys/roleResources/" + roleId, { resources });
};
