<template>

    <div class="TravelMateStart" :class="isclasses">
        <div class="TravelMateStart__heading">{{ title }}</div>
        <div class="TravelMateStart__fields">

            <div v-for="(date, index) in dates" v-on:click="changeActive(index)" v-bind:class="{ active: isActive == index }">
                {{ date.name }}
            </div>

        </div>

        <input type="hidden" :value="value">

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            title: { default: '' },
            dates: { default: ''}
        },

        data: () => ({
            isActive: false,
            value: '',
        }),

        methods: {
           changeActive: function(id){
                this.isActive = id;
               return this.value = this.dates[id].output;
           }
        },

        mounted() {
            return this.value = this.dates[0].output;
        }

    }

</script>
