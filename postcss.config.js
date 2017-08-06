module.exports = {
    plugins: [
        require('postcss-import')({
            path: [
                './resources/views/v2/styles',
                './node_modules'
            ]
        }),
        require('postcss-simple-vars')({
            silent: true
        }),
        require('postcss-responsive-type')(),
        require('postcss-font-magician')(),
        require('postcss-if-media')(),
        require('postcss-discard-comments')()
    ]
}