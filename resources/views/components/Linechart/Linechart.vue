<template>

    <div class="Linechart" :class="isclasses">

        <svg :width="width" :height="height">

            <!-- X Axis -->

            <line
                :x1="0"
                :y1="height"
                :x2="width"
                :y2="height"
                stroke="rgba(0,0,0,0.2)"
            />

            <!-- Y Axis -->

            <line
                :x1="0"
                :y1="0"
                :x2="0"
                :y2="height"
                stroke="rgba(0,0,0,0.2)"
            />
            
            <!-- Line graphs -->

            <path
                v-for="(item, index) in items"
                :key="index"
                fill="none"
                stroke-width="2"
                stroke="hsl(205, 82%, 57%)"
                :d="line(item.values)"
                :opacity="1 - (index * 0.4)"
            />

            <!-- Vertical cursor -->

            <line
                v-show="currentIndex"
                :x1="xScale(currentIndex)"
                :y1="0"
                :x2="xScale(currentIndex)"
                :y2="height"
                stroke="rgba(0,0,0,0.2)"
                stroke-width="1"
                @mouseenter="currentIndex = index"
            />

            <!-- Hover hotspots to enable vertical cursor -->

            <rect
                v-for="(value, index) in items[0].values"
                :key="index"
                :x="xScale(index - 0.5)"
                :y="0"
                :width="xScale(1)"
                :height="height"
                fill="rgba(0,0,0,0)"
                @mouseenter="currentIndex = index"
                @mouseleave="currentIndex = false"
            />

            <!-- Legend --> 

            <g
                v-for="(line, index) in legend"
                :key="index"
                :transform="'translate(0,'+ (index * 20) + ')'"
                :opacity="1 - (index * 0.3)"
            >
                <text
                    x="15"
                    y="20"
                    font-family="Sailec"
                    font-size="14px"
                    fill="hsl(205, 82%, 57%)"
                >
                    {{ line.title }}: {{ line.value }}
                </text> 
            </g>
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

    data: () => ({ padding: 3, currentIndex: false }),

    computed: {
        height() {
            return this.width / 4
        },
        legend() {
            if (this.currentIndex) {
                return this.items.map(item => ({
                    title: item.title,
                    value: item.values[this.currentIndex]
                }))
            }
            return null
        }
    },
    methods: {
        xScale(index) {
            return scaleLinear()
                .domain([
                    0,
                    this.items[0].values.length - 1
                ])
                .range([
                    this.padding,
                    this.width - this.padding
                ])(index)
        },
        yScale(value) {
            return scaleLinear()
                .domain(
                    extent(
                        merge(
                            this.items.map(
                                item => item.values
                            )
                        )
                    )
                )
                .range([
                    this.height - this.padding,
                    this.padding
                ])(value)
        },
        line(items) {
            return line()
                .x((d, index) => this.xScale(index))
                .y(d => this.yScale(d))
                .defined(d => d > 0)(items)
        }
    }
}
</script>
