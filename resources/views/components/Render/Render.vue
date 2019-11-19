<script>
import Vue from 'vue'

export default {
    props: { body: { default: '', type: String } },
    data: () => ({
        render: null,
        someVariable: 0
    }),
    mounted() {
        this.$watch(
            'body',
            body => {
                const template = Vue.compile(body)
                this.render = template.render
                this.$options.staticRenderFns = []
                this._staticTrees = []
                for (var i in template.staticRenderFns) {
                    this.$options.staticRenderFns.push(
                        template.staticRenderFns[i]
                    )
                }
            },
            { immediate: true }
        )
    },
    render: function(h) {
        return this.render ? this.render() : h()
    }
}
</script>