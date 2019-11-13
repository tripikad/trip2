<template>
    <div class="Dotmap" :class="isclasses">
        <svg :width="width" :height="height">
            <g
                :transform="
                    'translate(' + width * -0.03 + ',' + height / -1.5 + ')'
                "
            >
                <circle
                    v-for="(c, i) in countries"
                    :key="i"
                    :cx="xScale(c.lon)"
                    :cy="yScale(c.lat)"
                    :r="radius"
                    fill="black"
                    opacity="0.25"
                />
                <g v-if="activeCountries.length">
                    <circle
                        v-for="(c, i) in activeCountries"
                        :key="i"
                        :cx="xScale(c.lon)"
                        :cy="yScale(c.lat)"
                        :r="radius"
                        fill="white"
                        opacity="0.5"
                    />
                </g>
                <circle
                    v-if="activeCity"
                    :cx="xScale(activeCity.lon)"
                    :cy="yScale(activeCity.lat)"
                    :r="radius * 3"
                    stroke="white"
                    stroke-width="3"
                    fill="none"
                />
            </g>
        </svg>
    </div>
</template>

<script>
import { scaleLinear } from 'd3-scale'

export default {
    props: {
        isclasses: { default: '' },
        countries: { default: () => [] },
        country: { default: null },
        cities: { default: () => [] },
        city: { default: null },
        width: { default: 750 },
        destination: { default: null }
    },

    computed: {
        radius() {
            return this.width / 350
        },
        height() {
            return this.width / 2.5
        },
        activeCountries() {
            return this.countries.filter(d =>
                d.destination_ids.includes(this.country)
            )
        },
        activeCity() {
            return this.cities[this.city]
        }
    },

    methods: {
        xScale(value) {
            return scaleLinear()
                .domain([-180, 180])
                .range([10, this.width - 10])(value)
        },
        yScale(value) {
            return scaleLinear()
                .domain([180, -180])
                .range([10, this.width - 10])(value)
        }
    },
    mounted() {
        console.log(this.activeCountries)
    }
}
</script>
