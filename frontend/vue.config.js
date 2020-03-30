module.exports = {
  transpileDependencies: ["vuetify"],
  publicPath: "/", //default
  outputDir: "dist", //default
  indexPath: "index.html", //default
  filenameHashing: true, //default

  assetsDir: "asset", //default = ''
  productionSourceMap: false, // default = true

  devServer: {
    proxy: {
      "/api": {
        target: "http://6.6.6.6:9501",
        secure: false,
        ws: true,
        changeOrigin: true,
        pathRewrite: {
          "^/api": ""
        }
      }
    }
  },

  chainWebpack: config => {
    if (process.env.use_analyzer) {
      // 分析
      config
        .plugin("webpack-bundle-analyzer")
        .use(require("webpack-bundle-analyzer").BundleAnalyzerPlugin);
    }
  }
};
