<template>

    <div class="FormSelectMultiple" :class="isclasses">
        
        <component
            is="Multiselect"
            :options="currentOptions"
            track-by="name"
            label="name"
            :placeholder="placeholder"
            :multiple="true"
            :taggable="true"
            @input="onInput"
        >
        </component>

        <input
            v-model="currentIds"
            v-show="true"
            type="text"
            :name="name"
            size="100"
        >

    </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect'

    export default {

        components: { Multiselect },

        props: {
            isclasses: { default: '' },
            name: { default: '' },
            options: { default: '' },
            placeholder: { default: '' },
            helper: { default: '' },
            value: { default: '' },
            tagplaceholder: { default: '' },
        },

        data() {
            return {
                selected: null,
                currentOptions: [],
                currentMultiple: false
            }
        },

        computed: {
            currentIds() {
                return '1,2'
            }
        },

        methods: {
            onInput(selected) {
                this.selected = selected
            }
        },

        mounted() {
            this.currentOptions = JSON.parse(decodeURIComponent(this.options))
            this.selected = this.currentOptions.find((option) => option === this.value)
        }
    }

</script>