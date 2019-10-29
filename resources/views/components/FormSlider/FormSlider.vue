<template>
    <div>
        <div class="FormSlider" :class="isclasses">
            <div class="FormSlider__labels">
                <div class="FormSlider__label">{{ values[0] }}</div>
                <div class="FormSlider__label">{{ values[1] }}</div>
            </div>
            <vue-slider
                v-model="values"
                :min="min"
                :min-range="minRange"
                :max="max"
                :interval="step"
                :enable-cross="false"
                :tooltip-formatter="formatter"
                :lazy="true"
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
        min: { default: 0 },
        max: { default: 100 },
        minRange: { default: 0 },
        step: { default: 1 },
        prefix: { default: '' },
        suffix: { default: '' },
        suffix: { lazy: true }
    },
    data() {
        return {
            values: [this.min, this.max]
        }
    },
    methods: {
        formatter(value) {
            return `${this.prefix}${value}${this.suffix}`
        }
    },
    mounted() {}
}
</script>
