<template>
    <div class="EditorSmall" :class="isclasses">
        <div v-show="!showSource" ref="EditorSmall"></div>

        <div v-show="showSource">
            <div class="EditorSmall__toolbar">
                <div
                    class="EditorSmall__button"
                    @click="
                        showSource = false
                        editor.content.innerHTML = localValue
                    "
                >
                    Back
                </div>
            </div>

            <textarea class="EditorSmall__source" :name="name" v-model="localValue"></textarea>
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
        showSource: false
    }),

    mounted() {
        this.editor = pell.init({
            element: this.$refs.EditorSmall,
            onChange: value => (this.localValue = value),
            actions: [
                {
                    icon: 'B',
                    result: () => pell.exec('bold')
                },
                {
                    icon: 'I',
                    result: () => pell.exec('italic')
                },
                {
                    icon: '•',
                    result: () => pell.exec('insertUnorderedList')
                },
                {
                    icon: 'Link',
                    result: () => {
                        var url = window.prompt('Enter the link URL')
                        if (url) pell.exec('createLink', url)
                    }
                },
                {
                    icon: 'Source',
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
