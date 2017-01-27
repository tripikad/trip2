<template>

    <div class="FormSelectMultiple" :class="isclasses">
        
        <component
            is="Multiselect"
            :options="currentOptions"
            track-by="id"
            label="name"
            :placeholder="placeholder"
            :multiple="true"
            :taggable="true"
            @input="onInput"
            :value="currentValue"
        >
        </component>

        <input
            v-for="select in selected"
            type="text"
            :name="name + '[]'"
            :value="select.id"
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
            options: { default: '' },
            placeholder: { default: '' },
            helper: { default: '' },
            value: { default: '' },
            tagplaceholder: { default: '' },
        },

        data() {
            return {
                selected: [],
                currentOptions: [],
                currentValue: []
            }
        },

        methods: {
            onInput(selected) {
                this.selected = selected
            }
        },

        mounted() {
            this.currentOptions = JSON.parse(decodeURIComponent(this.options))
            this.currentValue = JSON.parse(decodeURIComponent(this.value))
            this.currentValue = this.currentValue.map(value => {
                var option = this.currentOptions.find(option => option.id === value)
                return {id: value, name: option.name}
            })
        }
    }

</script>