module.exports = {
    resolve: {
        alias: {
            'vue$': 'vue/dist/vue.common.js'
        }
    },
    module: {
        loaders: [
            {
                test: /\.vue$/,
                loader: 'vue-loader'
            },
            {
                test: /\.json$/,
                loader: 'json-loader'
            }
        ]
    }

}
