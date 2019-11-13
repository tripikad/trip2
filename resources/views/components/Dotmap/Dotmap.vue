<template>
    <div class="Dotmap" :class="isclasses">
        <svg :width="width" :height="height">
            <g>
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
                <path
                    :d="
                        line([
                            [23.027343749999996, 58.81374171570782],
                            [98.61328125, 20.632784250388028]
                        ])
                    "
                    stroke="white"
                    stroke-width="2"
                    fill="none"
                    opacity="0.7"
                />
            </g>
        </svg>
    </div>
</template>

<script>
import { geoEquirectangular, geoPath } from 'd3-geo'

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
        height() {
            return this.width / 2.5
        },
        projection() {
            const yOffset = -0.2
            return geoEquirectangular()
                .scale(this.width / 6.75)
                .translate([this.width / 2, this.height / (2 + yOffset)])
        },
        geopath() {
            return geoPath().projection(projection)
        },
        radius() {
            return this.width / 350
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
        line(coordinates) {
            return geoPath().projection(this.projection)({
                type: 'FeatureCollection',
                features: [
                    {
                        type: 'Feature',
                        geometry: {
                            type: 'LineString',
                            coordinates
                        }
                    }
                ]
            })
        },
        xScale(lon) {
            return this.projection([lon, 0])[0]
        },
        yScale(lat) {
            return this.projection([0, lat])[1]
        }
        // xScale(value) {
        //     return scaleLinear()
        //         .domain([-180, 180])
        //         .range([10, this.width - 10])(value)
        // },
        // yScale(value) {
        //     return scaleLinear()
        //         .domain([180, -180])
        //         .range([10, this.width - 10])(value)
        // }
    },
    mounted() {
        console.log(this.activeCountries)
    }
}
</script>
