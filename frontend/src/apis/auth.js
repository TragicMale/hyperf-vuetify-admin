import axois from "../utils/http";

export const login = (username, password) => {
  return axois.post("/login", {
    username,
    password
  });
};

export const accountInfo = () => {
  return axois.get("/account");
};

export const newPassword = params => {
  return axois.put("/account/password", params);
};
