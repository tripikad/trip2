var fs = require("fs");
var path = require("path");
var webpack = require("webpack");
var ExtractTextPlugin = require("extract-text-webpack-plugin");
var SpriteLoaderPlugin = require("svg-sprite-loader/plugin");
var CleanWebpackPlugin = require("clean-webpack-plugin");

module.exports = {
    entry: {
        main: "./resources/views/v2/main.js",
        vendor: [
            "vue",
            "vue-clickaway",
            "vue-cookie",
            "vue-focus",
            "vue-multiselect",
            "vue-resource"
        ]
    },
    output: {
        path: path.resolve(__dirname, "./public/dist"),
        publicPath: "/dist/",
        filename: "[name].[chunkhash:6].js"
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
                use: ExtractTextPlugin.extract({
                    use: [
                        { loader: "css-loader", options: { importLoaders: 1 } },
                        "postcss-loader"
                    ]
                })
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
        new ExtractTextPlugin('[name].[chunkhash:6].css'),
        new SpriteLoaderPlugin(),
        new CleanWebpackPlugin('./public/dist'),
        function() {
            this.plugin("done", stats => {
                var assets = stats.toJson().assetsByChunkName;
                var manifest = {
                    js: assets.main.find(
                        asset => path.extname(asset) === '.js'
                    ),
                    vendor: assets.vendor,
                    css: assets.main.find(
                        asset => path.extname(asset) === '.css'
                    ),
                    svg: assets["main.svg"]
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
    devtool: "#eval-source-map"
};

if (process.env.NODE_ENV === "production") {
    module.exports.devtool = "#source-map";
    module.exports.plugins = (module.exports.plugins || []).concat([
        new webpack.DefinePlugin({
            "process.env": {
                NODE_ENV: '"production"'
            }
        }),
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: true,
            compress: {
                warnings: false
            }
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true
        })
    ]);
}
