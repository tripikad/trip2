<template>
    <div class="Dotmap" :class="isclasses">
        <svg :width="width" :height="height">
            <g v-if="dots.length">
                <circle
                    v-for="(c, i) in dots"
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
                    fill="black"
                    opacity="0.25"
                />
            </g>
            <!-- <path
                v-if="activeLine"
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
            /> -->
            <g v-if="activeCitiesCircles.length">
                <circle
                    v-for="(c, i) in activeCitiesCircles"
                    :key="i"
                    :cx="xScale(c.lon)"
                    :cy="yScale(c.lat)"
                    :r="radius * 2"
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
        dots: { default: () => [] },
        country: { default: null },
        activecountries: { default: () => [] },
        activecities: { default: () => [] },
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
        activeCountriesDots() {
            return this.dots.filter(
                d =>
                    intersection(d.destination_ids, this.activecountries).length
            )
        },
        activeCitiesCircles() {
            return this.activecities
                .map(c => (this.cities[c] ? this.cities[c] : null))
                .filter(c => c)
        },
        activeCity() {
            return this.allcities[this.city]
                ? [this.allcities[this.city].lon, this.allcities[this.city].lat]
                : null
        },
        activeLine() {
            return this.allcities[this.city] && this.allcities[this.city]
                ? [
                      [
                          this.allcities[this.startcity].lon,
                          this.allcities[this.startcity].lat
                      ],
                      [
                          this.allcities[this.city].lon,
                          this.allcities[this.city].lat
                      ]
                  ]
                : null
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
        console.log(this.countriesDots)
    }
}
</script>
