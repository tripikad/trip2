<template>

    <div class="FormSelect" :class="isclasses">
    
        <component
            is="Multiselect"
            :selected="selected"
            :multiple="false",
            :searchable="true",
            :options="options",
            @update="updateValue"
            :placeholder="placeholder"
            label="name">
        </component>

        <input type="hidden" :name="name" :value="selected.id">

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
            placeholder: { default: '' }
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