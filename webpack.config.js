var fs = require("fs");
var path = require("path");
var webpack = require("webpack");
var MiniCssExtractPlugin = require("mini-css-extract-plugin");
var SpriteLoaderPlugin = require("svg-sprite-loader/plugin");
var CleanWebpackPlugin = require("clean-webpack-plugin");
const { VueLoaderPlugin } = require("vue-loader");

module.exports = {
  entry: {
    main: "./resources/views/main.js"
  },
  output: {
    path: path.resolve(__dirname, "./public/dist"),
    publicPath: "/dist/",
    filename: "[name].[chunkhash:6].js",
    chunkFilename: "main.[name].[chunkhash:6].js"
  },
  module: {
    rules: [
      {
        test: /\.vue$/,
        loader: "vue-loader"
      },
      {
        test: /\.js$/,
        loader: "babel-loader",
        exclude: /node_modules/
      },
      {
        test: /\.css$/,
        use: [
          MiniCssExtractPlugin.loader,
          {
            loader: "css-loader",
            options: { importLoaders: 1 }
          },
          "postcss-loader"
        ]
      },
      {
        test: /\.svg$/,
        use: [
          {
            loader: "svg-sprite-loader",
            options: {
              extract: true,
              spriteFilename: "[chunkname].svg"
            }
          },
          "svgo-loader"
        ]
      },
      {
        test: /\.(ttf|woff|woff2|eot)$/,
        loader: "file-loader",
        options: {
          name: "[name].[ext]"
        }
      }
    ]
  },
  plugins: [
    new VueLoaderPlugin(),
    new MiniCssExtractPlugin({
      filename: "[name].[contenthash:6].css"
    }),
    new SpriteLoaderPlugin(),
    new CleanWebpackPlugin("./public/dist"),
    function() {
        this.plugin("done", stats => {
            var assets = stats.toJson().assetsByChunkName;
            var manifest = {
                js: assets.main.find(asset => path.extname(asset) === ".js"),
                css: assets.main.find(asset => path.extname(asset) === ".css"),
                svg: "main.svg"
            };
            fs.writeFileSync(
                path.join(__dirname, 'public/dist/manifest.json'),
                JSON.stringify(manifest)
            );
        });
    }
  ],
  resolve: {
    alias: {
      vue$: "vue/dist/vue.esm.js"
    }
  },
  performance: {
    hints: false
  },
  devtool: "#eval-source-map",
  stats: { entrypoints: false }
};

if (process.env.NODE_ENV === "production") {
    module.exports.devtool = "";
    module.exports.plugins = module.exports.plugins.concat([
        new webpack.optimize.UglifyJsPlugin()
    ]);
}
