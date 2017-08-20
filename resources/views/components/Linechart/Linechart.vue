<template>

    <div class="Linechart" :class="isclasses">

        <svg :width="width" :height="height">

            <path
                fill="none"
                stroke-width="2"
                stroke="hsl(205, 82%, 57%)"
                :d="line(indexedRows)"
            />
            <line
                :x1="xScale(0)"
                :y1="yScale(0)"
                :x2="xScale(0)"
                :y2="yScale(100)"
                stroke="hsl(204, 6%, 55%)"
            />
            <line
                :x1="xScale(0)"
                :y1="yScale(100)"
                :x2="xScale(rows.length - 1)"
                :y2="yScale(100)"
                stroke="hsl(204, 6%, 55%)"
            />
        </svg>  

    </div>

</template>

<script>

    import { scaleLinear } from 'd3-scale'
    import { line } from 'd3-shape'
 
    export default {

        props: {
            isclasses: { default: '' },
            width: { default: 600 },
            rows: { default: [] }
        },

        computed: {
            height() {
                return this.width / 4
            },
            indexedRows() {
                return this.rows.map((row, index) => {
                    row.index = index
                    return row
                })
            }
        },

        methods: {
            xScale(index) {
                return scaleLinear()
                    .domain([0, this.rows.length - 1])
                    .range([0, this.width])
                    (index)
            },
            yScale(value) {
                return scaleLinear()
                    .domain([0, 100])
                    .range([0, this.height])
                    (value)
            },
            line(rows) {
                return line()
                    .x(d => this.xScale(d.index))
                    .y(d => this.yScale(d.value))
                    (rows)
            },
        }
    }

</script>
