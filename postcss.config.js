module.exports = {
    plugins: [
        require('postcss-discard-comments')(),
        require('postcss-import')({
            path: ['./resources/views/styles', './node_modules']
        }),
        require('postcss-simple-vars')({
            variables: () => require('./resources/views/styles/styles'),
            silent: true
        }),
        require('postcss-responsive-type')(),
        require('postcss-font-magician')(),
        require('postcss-if-media')()
    ]
}
