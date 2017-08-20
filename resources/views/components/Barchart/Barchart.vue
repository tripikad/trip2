<template>

    <div class="Barchart" :class="isclasses">

        <div class="Barchart__row" v-for="row in rows">

            <div class="Barchart__title">{{ row.title }}</div>
            
            <div class="Barchart__bar" :style="{width: xScale(row.value) + 'px'}">
                {{ row.value }} %
            </div>

        </div>

    </div>

</template>

<script>

    import { scaleLinear } from 'd3-scale'

    export default {

        props: {
            isclasses: { default: '' },
            width: { default: 600 }
            //rows: { default: [] }
        },

        data: () => ({
            rows: [
                {
                    title: 'First',
                    value: 23
                },
                {
                    title: 'Second',
                    value: 11
                }
            ]
        }),

        methods: {
            xScale(value) {
                return scaleLinear()
                    .domain([0, 100])
                    .range([0, this.width])
                    (value)
            }
        }
    }

</script>
