import axois from "../utils/http";

export const getPermissions = () => axois.get("/permissions");

export const getAllMenus = () => axois.get("/menus");

export const getAllRoles = () => axois.get("/roles");

export const getAllResources = () => axois.get("/resources");
