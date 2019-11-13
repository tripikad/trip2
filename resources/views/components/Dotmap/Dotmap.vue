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
                <path
                    :d="line(activeLine)"
                    stroke="white"
                    stroke-width="2"
                    fill="none"
                    opacity="0.7"
                />
                <circle
                    v-if="activeCity"
                    :cx="xScale(activeLine[0][0])"
                    :cy="yScale(activeLine[0][1])"
                    :r="radius * 2"
                    stroke="white"
                    stroke-width="2"
                    :fill="$styleVars.blue"
                />
                <circle
                    v-if="activeCity"
                    :cx="xScale(activeCity[0])"
                    :cy="yScale(activeCity[1])"
                    :r="radius * 3"
                    stroke="white"
                    stroke-width="2"
                    :fill="$styleVars.orange"
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
        startcity: { default: null },
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
            return [this.cities[this.city].lon, this.cities[this.city].lat]
        },
        activeLine() {
            return [
                [
                    this.cities[this.startcity].lon,
                    this.cities[this.startcity].lat
                ],
                this.activeCity
            ]
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
    },
    mounted() {
        console.log(this.$styleVars.blue)
    }
}
</script>
