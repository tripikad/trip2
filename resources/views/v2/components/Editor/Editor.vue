<template>

    <div class="Editor" :class="isclasses" v-show="show">
        
        <div class="Editor__close" @click="show = false">×</div>
        
        <div class="Editor__wrapper">
        
            <div class="Editor__toolbar">
                <div class="Editor__tool" @click="insertLink">Link</div>
                <div class="Editor__tool" @click="insertBold">Bold</div>
                <div class="Editor__tool" @click="insertItalic">Italic</div>
                <div class="Editor__tool" @click="insertUl">List</div>
                <div class="Editor__tool" @click="insertH3">H3</div>
                <div class="Editor__tool" @click="insertH4">H4</div>
                <div class="Editor__tool" @click="openPicker">Image</div>
            </div>
        
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
        methods: {
            insertLink() {
                var link = window.prompt('Link', 'http://')
                var doc = this.editor.getDoc()
                doc.replaceSelection('['+doc.getSelection()+'](' + link + ')');
                this.editor.focus()
            },
            insertBold() {
                var doc = this.editor.getDoc()
                doc.replaceSelection('**'+this.editor.getDoc().getSelection()+'**');
                this.editor.focus()
            },
            insertItalic() {
                var doc = this.editor.getDoc()
                doc.replaceSelection('_'+doc.getSelection()+'_');
                this.editor.focus()
            },
            insertH3() {
                var doc = this.editor.getDoc()
                var cursor = doc.getCursor();
                doc.replaceRange('\n\n### \n\n', cursor);
                doc.setCursor({
                    line: cursor.line + 2,
                    ch: 4
                })
                this.editor.focus()
            },
            insertH4() {
                var doc = this.editor.getDoc()
                var cursor = doc.getCursor();
                doc.replaceRange('\n\n#### \n\n', cursor);
                doc.setCursor({
                    line: cursor.line + 2,
                    ch: 5
                })
                this.editor.focus()
            },
            insertUl() {
                var doc = this.editor.getDoc()
                var cursor = doc.getCursor();
                doc.replaceRange('\n\n* \n\n', cursor);
                doc.setCursor({
                    line: cursor.line + 2,
                    ch: 3
                })
                this.editor.focus()
            },
            openPicker() {
                this.$events.$emit('photopicker.show')
            },
            insertImage(id) {
                var doc = this.editor.getDoc()
                var cursor = doc.getCursor();
                doc.replaceRange('\n\n' + id + '\n', cursor);
                doc.setCursor({
                    line: cursor.line + 4,
                    ch: 0
                })
                this.editor.focus()
                this.$events.$emit('photopicker.hide')
            }
        },
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
            this.$events.$on('editor.show', () => {
                this.show = true
            })
            this.$events.$on('photopicker.insert', id => {
                this.insertImage(id)
            })
        }

    }

</script>
