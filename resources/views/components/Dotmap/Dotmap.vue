<template>
    <div class="Dotmap" :class="isclasses">
        <svg :width="width" :height="height">
            <g v-if="destination_dots.length">
                <circle
                    v-for="(c, i) in destination_dots"
                    :key="i"
                    :cx="xScale(c.lon)"
                    :cy="yScale(c.lat)"
                    :r="radius"
                    fill="black"
                    opacity="0.25"
                />
            </g>
            <g v-if="activeCountriesDots.length">
                <circle
                    v-for="(c, i) in activeCountriesDots"
                    :key="i"
                    :cx="xScale(c.lon)"
                    :cy="yScale(c.lat)"
                    :r="radius"
                    :fill="$styleVars.cyan"
                />
            </g>
            <path
                v-if="activeLinesCoordinates.length"
                :d="line(activeLinesCoordinates)"
                stroke="white"
                stroke-width="2"
                fill="none"
                opacity="0.7"
            />
            <g v-if="passiveCitiesCircles.length">
                <circle
                    v-for="(c, i) in passiveCitiesCircles"
                    :key="i"
                    :cx="xScale(c.lon)"
                    :cy="yScale(c.lat)"
                    :r="radius * 2"
                    stroke="white"
                    stroke-width="2"
                    :fill="$styleVars.blue"
                />
            </g>
            <g v-if="activeCitiesCircles.length">
                <circle
                    v-for="(c, i) in activeCitiesCircles"
                    :key="i"
                    :cx="xScale(c.lon)"
                    :cy="yScale(c.lat)"
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
import { intersection } from '../../utils/utils'

export default {
    props: {
        isclasses: { default: '' },
        width: { default: 750 },
        destination_dots: { default: () => [] },
        destination_facts: { default: () => [] },
        areas: { default: () => [] },
        mediumdots: { default: () => [] },
        largedots: { default: () => [] },
        lines: { default: () => [] }
    },
    /*
    dotareas
    lines
    smalldots
    mediumdots
    largedots
    */

    computed: {
        height() {
            return this.width / 2.5
        },
        projection() {
            const yOffset = -0.2
            return geoEquirectangular()
                .scale(this.width / 6.75)
                .translate([this.width / 2, this.height / (2 + yOffset)])
                .precision(0.1)
        },
        geopath() {
            return geoPath().projection(projection)
        },
        radius() {
            return this.width / 350
        },
        activeCountriesDots() {
            return this.destination_dots.filter(
                d => intersection(d.destination_ids, this.areas).length
            )
        },
        passiveCitiesCircles() {
            return this.mediumdots
                .map(c =>
                    typeof c == 'object'
                        ? c
                        : this.destination_facts[c]
                        ? this.destination_facts[c]
                        : null
                )
                .filter(c => c)
        },
        activeCitiesCircles() {
            return this.largedots
                .map(c =>
                    typeof c == 'object'
                        ? c
                        : this.destination_facts[c]
                        ? this.destination_facts[c]
                        : null
                )
                .filter(c => c)
        },
        activeLinesCoordinates() {
            return this.lines
                .map(c =>
                    typeof c == 'object'
                        ? c
                        : this.destination_facts[c]
                        ? this.destination_facts[c]
                        : null
                )
                .filter(c => c)
                .map(c => [c.lon, c.lat])
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
        return this.mediumdots
    }
}
</script>
