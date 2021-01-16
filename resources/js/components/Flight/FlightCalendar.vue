<template>
    <div class="FlightCalendar">
        <table>
            <tbody>
                <tr>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day">515</td>
                    <td class="FlightCalendar__day">234</td>
                    <td class="FlightCalendar__day">543</td>
                    <td class="FlightCalendar__day"></td>
                </tr>
                <tr>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day">656</td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day">878</td>
                </tr>
                <tr>
                    <td class="FlightCalendar__day FlightCalendar__day--selected">334</td>
                    <td class="FlightCalendar__day FlightCalendar__day--in-range"></td>
                    <td class="FlightCalendar__day FlightCalendar__day--in-range">434</td>
                    <td class="FlightCalendar__day FlightCalendar__day--in-range"></td>
                    <td class="FlightCalendar__day FlightCalendar__day--in-range">256</td>
                    <td class="FlightCalendar__day FlightCalendar__day--in-range"></td>
                </tr>
                <tr>
                    <td class="FlightCalendar__day FlightCalendar__day--in-range">334</td>
                    <td class="FlightCalendar__day FlightCalendar__day--in-range"></td>
                    <td class="FlightCalendar__day FlightCalendar__day--selected">434</td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day">256</td>
                    <td class="FlightCalendar__day"></td>
                </tr>
                <tr>
                    <td class="FlightCalendar__day">434</td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day"></td>
                    <td class="FlightCalendar__day">543</td>
                    <td class="FlightCalendar__day"></td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
    props: {
        startDate: { default: '' },
        endDate: { default: '' },
        startCode: { default: '' },
        endCode: { default: '' },
    },

    data() {
        return {
            start: this.startDate
        }
    },

    methods: {
        onDayClick: function(day) {

        },
    }
}
</script>
