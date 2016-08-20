<template>

    <div class="FormSelect" :class="isclasses">
    
        <multiselect
            :selected="selected"
            :multiple="false",
            :searchable="true",
            :options="options",
            @update="updateValue"
            placeholder="Vali"
            key="name"
            label="name">
        </multiselect>

        <!--input type="hidden" :name="name" :value="selected" /-->

    </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect'

    export default {

        components: { Multiselect },

        props: {
            isclasses: { default: '' },
            name: { default: '' },
            options: { default: [] }
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