<template>

    <div class="FormSelect" :class="isclasses">
        
        <component
            is="Multiselect"
            v-model="localValue"
            :options="options"
            track-by="name"
            label="name"
            :placeholder="placeholder"
        >
        </component>

        <input
            v-model="returnValue"
            v-show="false"
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
            value: { default: '' }
        },

        data() {
            return {
                localValue: {}
            }
        },

        computed: {
            returnValue() {
                return this.localValue ? this.localValue.id : ''
            }
        },

        mounted() {
            this.localValue = this.options.find(option => option.id === parseInt(this.value))
        }
    }

</script>