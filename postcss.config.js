module.exports = {
    plugins: [
        require('postcss-import')({
            path: [
                './resources/views/styles',
                './node_modules'
            ]
        }),
        require('postcss-simple-vars')({
            variables: () =>
                require('./resources/views/styles/variables.json'),
            silent: true
        }),
        require('postcss-responsive-type')(),
        require('postcss-font-magician')(),
        require('postcss-if-media')(),
        require('postcss-discard-comments')()
    ]
}
