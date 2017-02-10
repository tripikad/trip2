<template>

    <div class="Editor" v-show="show" :class="isclasses">
        
        <div class="Editor__close" @click="show = false">×</div>
        
        <div class="Editor__wrapper">
        
            <!--div class="Editor__toolbar">
                <div class="Editor__tool" @click="insertLink">Link</div>
                <div class="Editor__tool" @click="insertBold">b</div>
                <div class="Editor__tool" @click="insertItalic">i</div>
                <div class="Editor__tool" @click="insertUl">ul</div>
                <div class="Editor__tool" @click="insertOl">ol</div>
                <div class="Editor__tool" @click="insertH3">h3</div>
                <div class="Editor__tool" @click="insertH4">h4</div>
                <div class="Editor__tool" @click="cleanMarkup">Clean</div>
                <div class="Editor__tool" @click="openPicker">Image</div>
            </div-->
        
            <div class="Editor__content">

                <div class="Editor__source" ref="source"></div>
                <div class="Editor__target">
                    <div class="Body" v-html="preview"></div>
                </div>

            </div>

        </div>

    </div>

</template>

<script>

    import CodeMirror from 'codemirror/lib/codemirror.js'
    import gfm from 'codemirror/mode/gfm/gfm.js'

    export default {

        props: {
            isclasses: { default: '' },
            value: { default: 'Hello world' },
            route: { default: ''}
        },

        data: () => ({
            show: true,
            preview: 'from Vue',
            editor: null,
            currentValue: '',
            preview: ''
        }),

        mounted() {
            this.currentValue = this.value
            this.editor = CodeMirror(this.$refs.source, {
                value: this.currentValue,
                mode: 'gfm',
                theme: 'neo',
                lineWrapping: true,
                viewportMargin: Infinity
            })
            this.editor.on('change', editor => {
                this.currentValue = editor.getValue()
                this.$events.$emit('editor.update', this.currentValue)
                this.$http.post(this.route, { value: this.currentValue })
                    .then(res => {
                        this.preview = res.body.value
                    })
            })
        }

    }

</script>
