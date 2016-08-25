<template>

    <div class="FormSelect" :class="isclasses">
    
        <component
            is="Multiselect"
            :selected="selected"
            :multiple="multiple",
            :searchable="true",
            :options="options",
            @update="updateValue"
            :placeholder="placeholder"
            label="name"
            :select-label="helper"
        >
        </component>

        <select
            v-if="multiple"
            v-show="false"
            :name="name + '[]'
            multiple
        ">
            <option v-for="item in selected" :value="item.id" selected>{{ item.name }}</option>
        </select>

        <input
            v-if="!multiple"
            v-show="false"
            type="text"
            :name="name"
            :value="selected ? selected.id : ''
        ">

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
            multiple: { default: '' }
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
            this.multiple = this.multiple
                ? JSON.parse(decodeURIComponent(this.multiple))
                : []
            this.options = this.options
                ? JSON.parse(decodeURIComponent(this.options))
                : []
        }

    }

</script>