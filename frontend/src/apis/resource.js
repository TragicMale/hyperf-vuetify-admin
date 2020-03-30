import axois from "../utils/http";
import { tableQueryFormatter } from "../utils/index";

export const list = (tableOptions, customParams) => {
  let params = tableQueryFormatter(tableOptions, customParams);
  return axois.get("/sys/resources", { params });
};

export const add = data => {
  return axois.post("/sys/resources", data);
};

export const save = (id, data) => {
  return axois.patch("/sys/resources/" + id, data);
};

export const get = id => {
  return axois.get("/sys/resources/" + id);
};

export const remove = id => {
  return axois.delete("/sys/resources/" + id);
};
