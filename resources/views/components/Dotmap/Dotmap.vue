<template>
    <div class="Dotmap" :class="isclasses">
        <svg :width="width" :height="height">
            <g>
                <circle
                    v-for="(c, i) in countrydots"
                    :key="i"
                    :cx="xScale(c[0])"
                    :cy="yScale(c[1])"
                    :r="radius"
                    :fill="$styleVars[backgroundcolor] || backgroundcolor"
                />
            </g>
            <g v-if="activeCountryDots.length">
                <circle
                    v-for="(c, i) in activeCountryDots"
                    :key="i"
                    :cx="xScale(c[0])"
                    :cy="yScale(c[1])"
                    :r="radius"
                    :fill="$styleVars[dotcolor] || dotcolor"
                />
            </g>
            <g v-if="smalldots.length">
                <circle
                    v-for="(c, i) in smalldots"
                    :key="i"
                    :cx="xScale(c.lon)"
                    :cy="yScale(c.lat)"
                    :r="radius"
                    :fill="$styleVars[smalldotcolor] || smalldotcolor"
                />
            </g>
            <path
                v-if="lines.length"
                :d="line(lines)"
                :stroke="$styleVars[linecolor] || linecolor"
                stroke-width="2"
                fill="none"
            />
            <g v-if="mediumdots.length">
                <circle
                    v-for="(d, i) in mediumdots"
                    :key="i"
                    :cx="xScale(d.lon)"
                    :cy="yScale(d.lat)"
                    :r="radius * 2"
                    :stroke="$styleVars[linecolor] || linecolor"
                    stroke-width="2"
                    :fill="$styleVars[mediumdotcolor] || mediumdotcolor"
                />
            </g>
            <g v-if="largedots.length">
                <circle
                    v-for="(d, i) in largedots"
                    :key="i"
                    :cx="xScale(d.lon)"
                    :cy="yScale(d.lat)"
                    :r="radius * 3"
                    :stroke="$styleVars[linecolor] || linecolor"
                    stroke-width="2"
                    :fill="$styleVars[largedotcolor] || largedotcolor"
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
        areas: { default: () => [] },
        smalldots: { default: () => [] },
        mediumdots: { default: () => [] },
        largedots: { default: () => [] },
        lines: { default: () => [] },
        backgroundcolor: { default: 'rgba(0,0,0,0.25)' },
        dotcolor: { default: 'white' },
        smalldotcolor: { default: 'white' },
        mediumdotcolor: { default: 'orange' },
        largedotcolor: { default: 'orange' },
        linecolor: { default: 'white' }
    },
    data: () => ({
        countrydots: []
    }),
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
        activeCountryDots() {
            return this.countrydots.filter(
                d => intersection(d[2], this.areas).length
            )
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
                            coordinates: coordinates.map(({ lon, lat }) => [
                                lon,
                                lat
                            ])
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
        this.$http.get('/api/countrydots').then(res => {
            this.countrydots = res.data
        })
    }
}
</script>
