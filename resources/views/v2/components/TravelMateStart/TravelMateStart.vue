<template>

    <div class="TravelMateStart" :class="isclasses">
        <div class="TravelMateStart__heading">{{ title }}</div>
        <div class="TravelMateStart__fields">

            <div class="TravelMateStart__field"
                    v-for="(date, index) in dates"
                    @click="atClick(index)"
                    :class="{ 'TravelMateStart--active': activeIndex === index }">
                {{ date.title }}
            </div>

        </div>

        <input type="hidden" :value="localValue" :name="name">

    </div>

</template>

<script>

    export default {

        props: {
            isclasses: { default: '' },
            title: { default: '' },
            dates: { default: []},
            value: { default: ''},
            name: { default: ''}
        },

        data: () => ({
            activeIndex: 0,
            localValue: false,
        }),

        methods: {
            atClick: function(id) {
                this.activeIndex = id;
                return this.localValue = this.dates[id].datetime.date;
            }
        },

        mounted() {
            this.activeIndex = this.value;
            return this.localValue = this.value ?  this.dates[this.value].datetime.date : this.dates[0].datetime.date;
        }

    }

</script>
