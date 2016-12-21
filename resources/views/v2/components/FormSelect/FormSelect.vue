<template>

    <div class="FormSelect" :class="isclasses">
        
        <component
            is="Multiselect"
            v-model="selected"
            :options="currentOptions"
            track-by="name"
            label="name"
        >
        </component>

        <input
            v-model="currentId"
            v-show="true"
            type="text"
            :name="name"
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
                selected: {},
                currentOptions: []
            }
        },

        computed: {
            currentId() {
                return this.selected ? this.selected.id : ''
            }
        },

        mounted() {
            this.currentOptions = JSON.parse(decodeURIComponent(this.options))
            this.selected = this.currentOptions.find((option) => option.id === parseInt(this.value))
        }
    }

</script>