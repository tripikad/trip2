<template>
    <div class="FormSelectMultiple" :class="{ 'FormSelect--error': isError, [isclasses]: true }">
        <label v-if="title" :for="name" class="FormSelect__label">{{ title }}</label>

        <component
            :is="'Multiselect'"
            :options="options"
            track-by="id"
            label="name"
            :placeholder="placeholder"
            :multiple="true"
            :taggable="true"
            @input="onInput"
            :value="localValue"
            :max="max"
            :close-on-select="close_on_select"
            :dusk="slugTitle"
        >
            <span slot="maxElements">{{ max_limit_text }}</span>
        </component>

        <input
            v-for="(value, index) in returnValue"
            :key="index"
            type="text"
            :name="name + '[]'"
            :value="value.id"
            v-show="false"
        />
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
        options: { default: () => [] },
        placeholder: { default: '' },
        helper: { default: '' },
        value: { default: () => [] },
        max: { default: Infinity },
        close_on_select: { default: true },
        max_limit_text: {
            default: 'Maksimaalsed valikud tehtud'
        }
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
            this.$emit('input', this.returnValue)
        }
    },

    computed: {
        slugTitle() {
            return this.title ? slug(this.title) : ''
        },
        isError() {
            return this.errors.includes(this.name.replace('[]', ''))
        }
    },

    mounted() {
        // @TODO2 Add watcher for value

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
