<template>

    <div class="Dotmap" :class="isclasses">

        {{ currentCountries }}

        <svg :width="width" :height="height">

            <g :transform="'translate(0,' + (height / 4) * -1 + ')'">

                <circle
                    v-for="dot in currentDots"
                    :cx="dot.lon"
                    :cy="dot.lat"
                    :r="radius"
                    :fill="'rgba(0,0,0,0.2)'"
                />

                <circle
                    v-for="city in currentCountries"
                    :cx="city.lon"
                    :cy="city.lat"
                    :r="radius"
                    fill="black"
                />

            </g>

        </svg>

    </div>

</template>

<script>

    import { scaleLinear } from 'd3'

    export default {

        props: {
            isclasses: { default: '' },
            dots: { default: '' },
            countries: { default: '' },
            width: { default: 800 },
            height: { default: 800 }
        },

        data: () => ({
            currentDots: [],
            currentCountries: []
        }),

        computed: {
            radius() {
                return this.width / 350
            }
        },

        methods: {
            latScale(value) {
                return scaleLinear()
                    .domain([180, -180])
                    .range([10, this.height - 10])
                    (value)
            },
            lonScale(value) {
                return scaleLinear()
                    .domain([-180, 180])
                    .range([10, this.width - 10])
                    (value)
            },
        },

        mounted() {
            this.currentDots = JSON
                .parse(decodeURIComponent(this.dots))
                .map(dot => {
                    dot.lat = this.latScale(dot.lat)
                    dot.lon = this.lonScale(dot.lon)
                    return dot
                })

            this.currentCountries = JSON
                .parse(decodeURIComponent(this.countries))
                .map(country => {
                    country.lat = this.latScale(country.lat)
                    country.lon = this.lonScale(country.lon)
                    return country
                })
            
        }

    }

</script>
