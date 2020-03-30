import store from "../store";
import first from "lodash/first";
import omitBy from "lodash/omitBy";

/**
 * URL地址
 * @param {*} s
 */
export function isURL(s) {
  return /^http[s]?:\/\/.*/.test(s);
}

export function toast(message, options) {
  if (message) {
    store.commit("snackbar/showMessage", {
      content: message,
      options: options
    });
  }
}

export function tableQueryFormatter(tableOptions, customParams) {
  let params = {};
  params.page = tableOptions.page;
  params.perPage = tableOptions.itemsPerPage;

  params.sortBy = first(tableOptions.sortBy);

  params = Object.assign(params, customParams);

  params = omitBy(params, v => {
    return !v && v !== false && v !== 0;
  });

  if (params.sortBy) {
    params.sortDirection = first(tableOptions.sortDesc) ? "desc" : "asc";
  }

  return params;
}
