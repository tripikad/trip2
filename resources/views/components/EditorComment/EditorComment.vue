<template>

    <div class="EditorComment" :class="isclasses">

        <div v-show="!showSource" ref="EditorComment"></div>

        <div v-show="showSource">

            <div class="EditorComment__toolbar">
                <div
                    class="EditorComment__button"
                    @click="showSource = false; editor.content.innerHTML = localValue"
                >Back</div>
            </div>

            <textarea
                class="EditorComment__source"
                :name="name"
                v-model="localValue"
            ></textarea>

        </div>

    </div>

</template>

<script>

    import pell from 'pell'

    export default {

        props: {
            isclasses: { default: '' },
            name: { default: '' },
            value: { default: '' }
        },

        data: () => ({
            localValue: '',
            editor: {},
            showSource: false,
            target: 'editor'
        }),

        methods: {

            setFocus() {
                var el = this.editor.getElementsByClassName('Body EditorComment__body')[0]
                var focused = document.activeElement

                if (! focused || focused == el) {
                    focused = true
                } else {
                    focused = false
                }

                if (! focused && el.innerHTML == '' || el.innerHTML == '<br>') {
                    el.focus();
                    if (typeof window.getSelection != "undefined" && typeof document.createRange != "undefined") {
                        var range = document.createRange()
                        range.selectNodeContents(el)
                        range.collapse(false)
                        var sel = window.getSelection()
                        sel.removeAllRanges()
                        sel.addRange(range)
                    } else if (typeof document.body.createTextRange != "undefined") {
                        var textRange = document.body.createTextRange()
                        textRange.moveToElementText(el)
                        textRange.collapse(false)
                        textRange.select()
                    }
                }
            },

        },

        mounted() {

            this.editor = pell.init({
                element: this.$refs.EditorComment,
                onChange: value => this.localValue = value,
                actions: [
                    {
                        icon: 'Rõhutatud',
                        result: () => {
                            this.setFocus()

                            pell.exec('bold')
                            return false
                        }
                    },
                    {
                        icon: 'Kaldkiri',
                        result: () => {
                            this.setFocus()

                            pell.exec('italic')
                            return false
                        }
                    },
                    {
                        icon: 'Nimekiri',
                        result: () => {
                            this.setFocus()

                            pell.exec('insertUnorderedList')
                            return false
                        }
                    },
                    {
                        icon: 'Link',
                        result: () => {
                            this.setFocus()

                            var url = prompt('Enter the link URL')
                            if (url) pell.exec('createLink', url)

                            return false
                        }
                    },
                    {
                        icon: 'Pilt',
                        result: () => {
                            this.setFocus()

                            var url = prompt("Lisa pildi URL.\n\nPilti saad üles laadida näiteks:\nhttps://pasteboard.co/\nvõi\nhttps://imgbb.com/")
                            if (url) pell.exec('insertImage', url)

                            return false
                        }
                    }
                ],
                classes: {
                    actionbar: 'EditorComment__toolbar',
                    button: 'EditorComment__button',
                    content: 'Body EditorComment__body'
                }
            })

            this.editor.content.innerHTML = this.value
            this.localValue = this.value

        }

    }

</script>
