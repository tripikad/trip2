<template>
    <div class="FormSelect" :class="{ 'FormSelect--error': errors.length, [isclasses]: true }">
        <div class="FormSelect__header">
            <label v-if="title" :for="name" class="FormSelect__label">{{ title }}</label>
        </div>

        <multiselect
            v-model="localValue"
            :options="groupOptions"
            track-by="id"
            label="name"
            :multiple="false"
            :taggable="false"
            :placeholder="placeholder"
            selectedLabel=""
        >
            <template slot="noResult">
                Tulemusi ei leitud
            </template>
            <template slot="option" slot-scope="props">
                <div class="option__desc">
                    <span class="option__title" v-html="customLabel(props)"/>
                </div>
            </template>

        </multiselect>

        <input v-model="returnValue" v-show="false" type="text" :name="name" />
    </div>
</template>

<script>
import { Multiselect } from 'vue-multiselect'

export default {
    components: { Multiselect },

    props: {
        isclasses: { default: '' },
        errors: { default: () => [] },
        title: { default: '' },
        description: { default: '' },
        name: { default: '' },
        options: { default: () => [] },
        placeholder: { default: '' },
        value: { default: '' }
    },

    data() {
        return {
            localValue: {}
        }
    },
    methods: {
        customLabel ({ option }) {
            if (!option.parent) {
                return '&nbsp;&nbsp;&nbsp;&nbsp;' + option.name
            }
            return `${option.name.toUpperCase()}`
        }
    },
    computed: {
        returnValue() {
            return this.localValue ? this.localValue.id : ''
        },
        groupOptions() {
            let res = []
            this.options.map((option) => {
                res.push({id: option.id, name: option.name, parent: true})
                if (option.children) {
                    option.children.map((childOption) => {
                        res.push({id: childOption.id, name: childOption.name, parent: false})
                    })
                }
            })

            return res
        },
    },

    mounted() {
        this.$watch('value', value => (this.localValue = this.groupOptions.find(option => option.id === parseInt(this.value))), {
            immediate: true
        })
        //this.$watch('localValue', localValue => this.$emit('input', this.localValue ? this.localValue.id : ''))
    }
}
</script>
