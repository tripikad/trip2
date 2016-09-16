<template>

    <div class="FormSelect" :class="isclasses">
    
        <component
            is="Multiselect"
            :selected="selected"
            :multiple="false",
            :searchable="false",
            :options="currentOptions",
            @update="updateValue"
            :placeholder="placeholder"
            label="name"
            :select-label="helper"
        >
        </component>

        <input
            type="text"
            :name="name"
            :value="selected | json"
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
            value: { default: '' }
        },

        data() {
            return {
                selected: null,
                currentOptions: []
            }
        },

        methods: {
            updateValue(selected) {
                this.selected = selected
            }
        },

        ready() {
            this.currentOptions = JSON.parse(decodeURIComponent(this.options))
            this.selected = this.currentOptions.find((option) => option.id === parseInt(this.value))
        }
    }

</script>