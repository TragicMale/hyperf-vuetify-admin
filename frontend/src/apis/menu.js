import axois from "../utils/http";

export const list = params => {
  return axois.get("/sys/menus", { params });
};

export const add = data => {
  return axois.post("/sys/menus", data);
};

export const save = (id, data) => {
  return axois.patch("/sys/menus/" + id, data);
};

export const get = id => {
  return axois.get("/sys/menus/" + id);
};

export const remove = id => {
  return axois.delete("/sys/menus/" + id);
};
