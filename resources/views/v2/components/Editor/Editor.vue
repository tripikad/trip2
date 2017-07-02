<template>

    <div class="Editor" :class="isclasses" v-show="show">
                
        <div class="Editor__wrapper">
        
            <div class="Editor__toolbar">

                <div class="Editor__toolbarLeft">

                    <div class="Editor__tool" @click="insertLink">Link</div>
                    <div class="Editor__tool" @click="insertBold">B</div>
                    <div class="Editor__tool" @click="insertItalic">I</div>
                    <div class="Editor__tool" @click="insertUl">*</div>
                    <div class="Editor__tool" @click="insertH3">H3</div>
                    <div class="Editor__tool" @click="insertH4">H4</div>
                    <div class="Editor__tool" @click="cleanMarkup">Cleanup</div>
                    <div class="Editor__tool" @click="openPicker">Image</div>

                </div>

                <div class="Editor__toolbarRight">

                    <div class="Editor__tool" @click="show = false">OK</div>

                </div>

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

    //import CodeMirror from 'codemirror/lib/codemirror.js'
    import gfm from 'codemirror/mode/gfm/gfm.js'

    import unescape from 'lodash.unescape'
    import tomarkdown from 'to-markdown'

    export default {

        props: {
            isclasses: { default: '' },
            route: { default: ''}
        },

        data: () => ({
            show: false,
            editor: null,
            value: '',
            preview: '',
            target: 'editor'
        }),
        watch: {
            show(value) {
                // If the editor is showed, scroll to top
                if (value === true) {
                    window.scrollTo(0, 0)
                }
            }
        },
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
            cleanMarkup() {
                var value = this.editor.getValue()
                value = value.replace(/&nbsp;/g, ' ')
                value = unescape(value)
                value = value.replace(/\n\n/g, '</p><p>')
                value = value.replace(/<br \/>/g, '</p><p>')
                value = tomarkdown(value)
                value = value.replace(/\n[0-9+]\\\./g, '@')
                value = value.replace(/\n\n\*\*/g, '\n\n### ')
                value = value.replace(/\*\*\n\n/g, '\n\n')
                this.editor.setValue(value)
                this.editor.focus()
            },
            openPicker() {
                this.$events.$emit('imagepicker.show', this.target)
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
            },
            updatePreview() {
                this.$http.post(this.route, { value: this.value })
                    .then(res => {
                        this.preview = res.body.value
                    })
            }
        },
        mounted() {
            
            if (window.CodeMirror !== undefined) {

                this.editor = CodeMirror(this.$refs.source, {
                    mode: 'gfm',
                    theme: 'neo',
                    lineWrapping: true,
                    viewportMargin: Infinity
                })
                
                this.editor.on('change', editor => {
                    this.value = editor.getValue()
                    this.$events.$emit('editor.update', this.value)
                    this.updatePreview()
                })

                this.$events.$on('editor.show', value => {
                    this.show = true
                    this.value = value
                    this.editor.setValue(this.value ? this.value : '')
                    setTimeout(() => {
                        this.editor.refresh()
                        this.editor.focus()
                        this.editor.setCursor({line: 0, ch: 0})
                    }, 1)
                    this.updatePreview()
                })
            
                this.$events.$on('imagepicker.insert', payload => {
                    if (payload.target === this.target) {
                        this.insertImage(payload.id)
                    }
                    this.$events.$emit('imagepicker.hide')
                })

            }
        }

    }

</script>
