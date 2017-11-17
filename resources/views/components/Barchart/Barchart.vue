<template>

    <div class="Barchart" :class="isclasses">

        <div class="Barchart__item" v-for="item in items">

            <div class="Barchart__title">{{ item.title }}</div>
            
            <div class="Barchart__bar" :style="{width: xScale(item.value) + 'px'}">
                {{ item.value }} %
            </div>

        </div>

    </div>

</template>

<script>

    import { scaleLinear } from 'd3-scale'
 
    export default {

        props: {
            isclasses: { default: '' },
            width: { default: 600 },
            items: { default: [] }
        },

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