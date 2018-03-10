<template>

    <div class="EditorSmall" :class="isclasses">

        <div v-show="!showSource" ref="EditorSmall"></div>

        <div v-show="showSource">

            <div class="EditorSmall__toolbar">
                <div
                    class="EditorSmall__button"
                    @click="showSource = false; editor.content.innerHTML = localValue"
                >Back</div>
            </div>

            <textarea
                class="EditorSmall__source"
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
                var el = this.editor.getElementsByClassName('Body EditorSmall__body')[0]
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
                element: this.$refs.EditorSmall,
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
                    actionbar: 'EditorSmall__toolbar',
                    button: 'EditorSmall__button',
                    content: 'Body EditorSmall__body'
                }
            })

            this.localValue = this.value

        }

    }

</script>
