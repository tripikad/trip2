<template>

    <div class="TravelmateStart" :class="isclasses">
        <div class="TravelmateStart__fields">

            <div class="TravelmateStart__field"
                v-for="(date, index) in dates"
                @click="atClick(index)"
                :class="{ 'TravelmateStart--active': activeIndex === index }">
                {{ date.title }}
            </div>

        </div>

        <input v-show="false" type="text" :value="localValue" :name="name">

    </div>

</template>

<script>
export default {
    props: {
        isclasses: { default: '' },
        title: { default: '' },
        dates: { default: [] },
        value: { default: '' },
        name: { default: '' }
    },

    data: () => ({
        activeIndex: 0
    }),

    methods: {
        atClick: function(id) {
            this.activeIndex = id
        }
    },
    computed: {
        localValue() {
            return this.dates[this.activeIndex].datetime
                .date
        }
    },
    mounted() {
        var index = this.dates.findIndex(
            date => date.datetime.date == this.value.date
        )
        this.activeIndex = index ? index : 0
    }
}
</script>
