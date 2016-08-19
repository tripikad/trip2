<template>

    <div class="FormSelect" :class="isclasses">
    
        <multiselect
            :selected="multiValue"
            :multiple="false",
            :searchable="true",
            :options="options",
            @update="updateValue"
            placeholder="Vali"
            key="name"
            label="name">
        </multiselect>

        <input type="hidden" :name="name" :value="newSelected" />

    </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect'

    export default {

        components: { Multiselect },

        props: {
            isclasses: { default: '' },
            name: { default: 'select' }
        },

        data() {
            return {
                selected: null,
                options: [{id: 1, name: 'One'}, {id: 2, name: 'Two'}]
            }
        },

        methods: {
            updateValue(newSelected) {
                this.selected = newSelected
            }
        }

    }

</script>