import axois from "../utils/http";
import { tableQueryFormatter } from "../utils/index";

export const list = (tableOptions, customParams) => {
  let params = tableQueryFormatter(tableOptions, customParams);
  return axois.get("/sys/users", { params });
};

export const add = data => {
  return axois.post("/sys/users", data);
};

export const save = (id, data) => {
  return axois.patch("/sys/users/" + id, data);
};

export const get = id => {
  return axois.get("/sys/users/" + id);
};

export const remove = id => {
  return axois.delete("/sys/users/" + id);
};

export const getUserRoles = userId => {
  return axois.get("/sys/userRoles/" + userId);
};

export const setUserRoles = (userId, roles) => {
  return axois.patch("/sys/userRoles/" + userId, { roles });
};
