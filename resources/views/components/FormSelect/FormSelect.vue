<template>
    <div class="FormSelect" :class="{'FormSelect--error': isError, [isclasses]: true}">
        <label v-if="title" :for="name" class="FormSelect__label">{{ title }}</label>

        <component
            :is="'Multiselect'"
            v-model="localValue"
            :options="options"
            track-by="name"
            label="name"
            :placeholder="placeholder"
            :dusk="slugTitle"
        ></component>

        <input v-model="returnValue" v-show="false" type="text" :name="name" />
    </div>
</template>

<script>
import { Multiselect } from 'vue-multiselect'
import { slug } from '../../utils/utils'

export default {
    components: { Multiselect },

    props: {
        isclasses: { default: '' },
        errors: { default: () => [] },
        title: { default: '' },
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
        },
        slugTitle() {
            return this.title ? slug(this.title) : ''
        },
        isError() {
            return this.errors.includes(this.name.replace('[]', ''))
        }
    },

    mounted() {
        this.localValue = this.options.find(option => option.id === parseInt(this.value))
        this.$watch('localValue', localValue => this.$emit('input', this.localValue ? this.localValue.id : ''))
    }
}
</script>
