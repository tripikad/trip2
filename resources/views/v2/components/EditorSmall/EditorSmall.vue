<template>

    <div class="EditorSmall" :class="isclasses">

        <div v-show="!showSource" ref="EditorSmall"></div>

        <div v-show="showSource">
            <div class="EditorSmall__toolbar">
                <div class="EditorSmall__button" @click="showSource = false">Back</div> 
            </div>
            <textarea class="EditorSmall__source" :value="localValue" @blur="editor.content.innerHTML = $event.target.value"></textarea>
        </div>

    </div>

</template>

<script>

    import pell from 'pell'

    export default {

        props: {
            isclasses: { default: '' },
            value: { default: '' }
        },

        data: () => ({
            localValue: '',
            editor: {},
            showSource: false
        }),

        watch: {
            localValue(value) {
                //this.editor.content.innerHTML = value
            }
        },

        mounted() {

            this.editor = pell.init({
                element: this.$refs.EditorSmall,
                onChange: value => this.localValue = value,
                actions: [
                    {
                        name: 'bold',
                        icon: 'B',
                        result: () => pell.exec('bold')
                    },
                    {
                        name: 'italic',
                        icon: 'I',
                        result: () => pell.exec('italic')
                    },
                    {
                        name: 'ulist',
                        icon: '•',
                        result: () => pell.exec('insertUnorderedList')
                    },
                    {
                        name: 'link',
                        icon: 'Link',
                        result: () => {
                            var url = window.prompt('Enter the link URL')
                            if (url) pell.exec('createLink', url)
                        }
                    },
                    {
                        name: 'link',
                        icon: 'Link',
                        result: () => {
                            this.showSource = !this.showSource
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
