<template>

    <div class="Dotmap" :class="isclasses">

        <svg :width="width" :height="height">

            <g :transform="'translate(0,' + (height / 4) * -1 + ')'">

                <circle
                    v-for="dot in currentDots"
                    :cx="dot.lon"
                    :cy="dot.lat"
                    :r="radius"
                    :fill="isActive(dot) ? 'rgba(0,0,0,0.3)' : 'rgba(0,0,0,0.08)'"
                />

                <circle
                    v-for="city in currentCities"
                    :cx="city.lon"
                    :cy="city.lat"
                    :r="radius"
                    fill="white"
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
            cities: { default: '' },
            width: { default: 1000 },
            height: { default: 1000 }
        },

        data: () => ({
            currentDots: [],
            currentCountries: [],
            currentCities: []
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
            isActive(dot) {
                return dot.destination_ids.find(id => {
                    return this
                        .currentCountries
                        .find(country => country === id)
                })
            }
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
            
            this.currentCities = JSON
                .parse(decodeURIComponent(this.cities))
                .map(country => {
                    country.lat = this.latScale(country.lat)
                    country.lon = this.lonScale(country.lon)
                    return country
                })
            
        }

    }

</script>
