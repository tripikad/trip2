<template>

    <div class="Dotmap" :class="isclasses">

        <svg :width="width" :height="height">

            <g :transform="'translate(' + (width * -0.03) +',' + (height / -1.5) + ')'">

                <circle
                    v-for="dot in dots"
                    :cx="xScale(dot.lon)"
                    :cy="yScale(dot.lat)"
                    :r="radius"
                    fill="gray"
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
            dots: { default: [] },
            width: { default: 750 }
        },

        computed: {
            radius() {
                return this.width / 350
            },
            height() {
                return this.width / 2.5
            }
        },

        methods: {
            xScale(value) {
                return scaleLinear()
                    .domain([-180, 180])
                    .range([10, this.width - 10])
                    (value)
            },
            yScale(value) {
                return scaleLinear()
                    .domain([180, -180])
                    .range([10, this.width - 10])
                    (value)
            }
        }

    }

</script>