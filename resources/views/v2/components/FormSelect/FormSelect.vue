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

        <select multiple :name="name + '[]'">
            <option v-for="item in selected" :value="item.id" selected>{{ item.name }}</option>
        </select>

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