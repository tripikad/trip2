<template>

    <div>
        
        <div class="Editor" :class="isclasses">

            <div class="Editor__toolbar">

                <div class="Editor__tool" @click="insertBold()">B</div>
                <div class="Editor__tool" @click="insertItalic()">I</div>
                <div class="Editor__tool" @click="insertMarkdownLink()">Link</div>
                <div class="Editor__tool" @click="insertHeading3()">H3</div>
                <div class="Editor__tool" @click="insertHeading4()">H4</div>
                <div class="Editor__tool" @click="insertTable()">▦</div>
                <div class="Editor__tool" @click="toggleImagebrowser()">Image</div>
                <div class="Editor__tool" @click="cleanMarkup()">Cleanup</div>

            </div>

            <div class="Editor__wrapper">

                <div ref="writer" class="Editor__writer" id="writer"></div>
                
                <div class="Editor__preview">

                    <div class="Body" v-html="body">
                    </div>

                </div>

            </div>

       </div>

   </div>

</template>

<script>

    import brace from 'brace'
    
    import _ from 'lodash'
    import tomarkdown from 'to-markdown'
    import striptags from 'striptags'

    import 'brace/theme/chrome'
    import 'brace/mode/markdown'

    // import ImageUpload from '../ImageUpload/ImageUpload.vue'

    const globalProps = JSON.parse(decodeURIComponent(
        document.querySelector('#globalprops').getAttribute('content')
    ))

    export default {

        components: {
    //      ImageUpload
        },

        props: {
            item: { default: {} }
        },

        data() {
            return {
                body: '',
                images: [],
                editor: {},
                imagebrowserOpen: false
            }
        },

        mounted() {
            // Set up the editor

            this.editor = brace.edit(this.$refs.writer)
            this.editor.setTheme('ace/theme/chrome')
            this.editor.getSession().setMode('ace/mode/markdown')
            this.editor.renderer.setShowGutter(false)
            this.editor.setHighlightActiveLine(false)
            this.editor.setOption('wrap', 70)
            this.editor.$blockScrolling = Infinity

            this.editor.getSession().on('change', function() {
                this.updatePreview()
            }.bind(this))

            // Get the content

            this.body = JSON.parse(decodeURIComponent(this.item)).body
            this.editor.setValue(this.body)
            this.updatePreview()

            // this.updateImages()

            this.$events.$on('imageUploaded', function() {
                // this.updateImages()
            })
        },

        methods: {

            updatePreview: function() {
                this.$http.item('/v2/utils/format', {body: this.editor.getValue()})
                    .then(function(res) {
                        this.body = res.data.body
                    })
            },

            insertBold: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '**' + this.editor.getSelectedText() + '**'
                )
                this.updatePreview()
                this.editor.focus()
            },

            insertItalic: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '*' + this.editor.getSelectedText() + '*'
                )
                this.updatePreview()
                this.editor.focus()
            },

            insertMarkdownLink: function() {
                var link = window.prompt('Link URL', 'http://')
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '[' + this.editor.getSelectedText() + '](' + link + ')'
                )
                this.updatePreview()
                this.editor.focus()
            },

            insertHeading3: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '\n#### ' + this.editor.getSelectedText()
                )
                this.updatePreview()
                this.editor.focus()
            },

            insertHeading4: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '\n##### ' + this.editor.getSelectedText()
                )
                this.updatePreview()
                this.editor.focus()
            },

            insertTable: function() {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(), [
                        '| Veerg 1 | Veerg 2 | Veerg 3 |',
                        '|---------|---------|---------|',
                        '| Sisu 1  | Sisu 2  | Sisu 3  |',
                        '\n'
                    ].join('\n')
                )
                this.updatePreview()
                this.editor.focus()
            },

            cleanMarkup: function() {
                var body = this.editor.getValue()
                body = body.replace(/&nbsp;/g, ' ')
                body = _.unescape(body)
                body = striptags(body, globalProps.allowedTags)
                body = body.replace(/\n\n/g, '</p><p>')
                body = body.replace(/<br \/>/g, '</p><p>')
                body = tomarkdown(body)
                body = body.replace(/\n\n\*\*/g, '\n\n### ')
                body = body.replace(/\*\*\n\n/g, '\n\n')
                this.editor.setValue(body)
                this.editor.focus()
                this.updatePreview()
            }
    
            /*
            updateImages: function() {
                this.$http.get('image/index').then(function(res) {
                    this.images = res.data
                })
            },

            toggleImagebrowser: function() {
                this.imagebrowserOpen = !this.imagebrowserOpen
            },

            insertImage: function(key) {
                this.editor.getSession().replace(
                    this.editor.selection.getRange(),
                    '\n\n[[' + key + ']]\n\n'
                )
                this.imagebrowserOpen = false
                this.editor.focus()
            }
            */
        }

    }

</script>