<template>

    <div class="FormSelectMultiple" :class="isclasses">
        
        <component
            is="Multiselect"
            :options="options"
            track-by="id"
            label="name"
            :placeholder="placeholder"
            :multiple="true"
            :taggable="true"
            @input="onInput"
            :value="localValue"
        >
        </component>

        <input
            v-for="value in returnValue"
            type="text"
            :name="name + '[]'"
            :value="value.id"
            v-show="false"
        />

    </div>

</template>

<script>

    import { Multiselect } from 'vue-multiselect'

    export default {

        components: { Multiselect },

        props: {
            isclasses: { default: '' },
            name: { default: '' },
            options: { default: () => [] },
            placeholder: { default: '' },
            helper: { default: '' },
            value: { default: () => [] }
        },

        data() {
            return {
                localValue: [],
                returnValue: []
            }
        },

        methods: {
            onInput(value) {
                this.returnValue = value
            }
        },

        mounted() {
            // We can not modify the props so we create the local value
            this.localValue = this.value.map(value => {
                // We convert the id's from the input value prop
                // to full collection, this is what Vue-Multiselect expects
                var option = this.options.find(option => option.id === value)
                return { id: value, name: option.name }
            })
            // We assign the local collection to return value
            this.returnValue = this.localValue
        }
    }

</script>