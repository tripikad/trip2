<template>
    <div style="width: 100%">
        <div class="FormSliderMultiple" :class="isclasses">
            <vue-slider
                v-model="values"
                :min="min"
                :min-range="minRange"
                :max="max"
                :interval="step"
                :enable-cross="false"
                :tooltip-formatter="formatter"
                :lazy="true"
                :tooltip="tooltip ? 'always' : 'focus'"
                :contained="true"
            />
        </div>
        <input v-show="false" :value="values[0]" type="text" :name="name" />
        <input v-show="false" :value="values[1]" type="text" :name="name2" />
    </div>
</template>

<script>
import VueSlider from 'vue-slider-component'

export default {
    components: { VueSlider },
    props: {
        isclasses: { default: '' },
        name: { default: '' },
        name2: { default: '' },
        value: { default: 0 },
        value2: { default: 100 },
        min: { default: 0 },
        max: { default: 100 },
        minRange: { default: 0 },
        step: { default: 1 },
        prefix: { default: '' },
        suffix: { default: '' },
        lazy: { default: true },
        tooltip: { default: true }
    },
    data() {
        return {
            values: [0, 100]
        }
    },
    methods: {
        formatter(value) {
            return `${this.prefix || ''}${value}${this.suffix || ''}`
        }
    },
    created() {
        this.$watch(
            vm => [vm.value, vm.value2, vm.min, vm.max],
            ([value, value2, min, max]) => {
                this.values = [value < min ? min : value, value2 > max ? max : value2]
            },
            { immediate: true }
        )

        this.$watch(
            'values',
            ([first, second]) => {
                this.$emit('input', first)
                this.$emit('input2', second)
            },
            { immediate: true }
        )
    }
}
</script>
