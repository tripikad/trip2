<template>

    <div class="Dotmap" :class="isclasses">

        <svg :width="width" :height="height">

            <g :transform="'translate(' + (width * -0.03) +',' + (height / -1.5) + ')'">

                <circle
                    v-for="dot in currentDots"
                    :cx="dot.lon"
                    :cy="dot.lat"
                    :r="radius"
                    :fill="isHavebeen(dot) ? 'rgba(0,0,0,0.3)' : 'rgba(0,0,0,0.08)'"
                />

                <circle
                    v-for="dot in currentDots"
                    v-if="isWanttogo(dot)"
                    :cx="dot.lon"
                    :cy="dot.lat"
                    :r="radius"
                    stroke="orange"
                    stroke-width="0"
                    fill="orange"
                    opacity="0.4"
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
            wanttogo_countries: { default: '' },
            havebeen_countries: { default: '' },
            cities: { default: '' },
            width: { default: 700 }
        },

        data: () => ({
            currentDots: [],
            currentHavebeenCountries: [],
            currentWanttogoCountries: [],
            currentCities: []
        }),

        computed: {
            radius() {
                return this.width / 350
            },
            height() {
                return this.width / 2.5
            }
        },

        methods: {
            latScale(value) {
                return scaleLinear()
                    .domain([180, -180])
                    .range([10, this.width - 10])
                    (value)
            },
            lonScale(value) {
                return scaleLinear()
                    .domain([-180, 180])
                    .range([10, this.width - 10])
                    (value)
            },
            isHavebeen(dot) {
                return dot.destination_ids.find(id => {
                    return this
                        .currentHavebeenCountries
                        .find(country => country === id)
                })
            },
            isWanttogo(dot) {
                return dot.destination_ids.find(id => {
                    return this
                        .currentWanttogoCountries
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

            this.currentHavebeenCountries = JSON
                .parse(decodeURIComponent(this.havebeen_countries))
                
            this.currentWanttogoCountries = JSON
                .parse(decodeURIComponent(this.wanttogo_countries))
    
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
