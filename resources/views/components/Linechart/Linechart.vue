<template>

    <div class="Linechart" :class="isclasses">

        <svg :width="width" :height="height">

            <path
                v-for="(item, index) in items"
                fill="none"
                stroke-width="2"
                stroke="hsl(205, 82%, 57%)"
                :d="line(item.values)"
                :opacity="1 - (index * 0.4)"
            />
            <line
                :x1="0"
                :y1="0"
                :x2="0"
                :y2="height"
                stroke="hsl(204, 6%, 55%)"
            />
            <line
                :x1="0"
                :y1="height"
                :x2="width"
                :y2="height"
                stroke="hsl(204, 6%, 55%)"
            />
        </svg>  

    </div>

</template>

<script>

    import { scaleLinear } from 'd3-scale'
    import { line } from 'd3-shape'
    import { extent, merge } from 'd3-array'
 
    export default {

        props: {
            isclasses: { default: '' },
            width: { default: 600 },
            items: { default: [] }
        },

        data: () => ({ padding: 3 }),

        computed: {
            height() {
                return this.width / 4
            }
        },
        methods: {
            xScale(index) {
                return scaleLinear()
                    .domain([0, this.items[0].values.length - 1])
                    .range([this.padding, this.width - this.padding])
                    (index)
            },
            yScale(value) {
                return scaleLinear()
                    .domain(
                        extent(merge(this.items.map(item => item.values)))
                    )
                    .range([this.height - this.padding, this.padding])
                    (value)
            },
            line(items) {
                return line()
                    .x((d, index) => this.xScale(index))
                    .y(d => this.yScale(d))
                    .defined(d => d > 0)
                    (items)
            },
        }
    }

</script>
