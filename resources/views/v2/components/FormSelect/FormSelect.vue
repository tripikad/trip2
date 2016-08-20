<template>

    <div class="FormSelect" :class="isclasses">
    
        <component
            is="Multiselect"
            :selected="selected"
            :multiple="true",
            :searchable="true",
            :options="options",
            @update="updateValue"
            :placeholder="placeholder"
            label="name"
            :select-label="helper"
        >
        </component>

        <input type="hidden" :name="name" :value="selected | json">

    </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect'

    export default {

        components: { Multiselect },

        props: {
            isclasses: { default: '' },
            name: { default: '' },
            options: { default: [] },
            placeholder: { default: '' },
            helper: { default: '' }
        },

        data() {
            return {
                selected: null
            }
        },

        methods: {
            updateValue(selected) {
                this.selected = selected
            }
        },

        ready() {
            this.options = this.options
                ? JSON.parse(decodeURIComponent(this.options))
                : []
        }

    }

</script>