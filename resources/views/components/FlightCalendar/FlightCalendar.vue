<template>
    <div class="FlightCalendar">
        <div class="FlightCalendar__loading_container" v-if="loading">
            <Loading :show="loading"/>
        </div>
        <div class="FlightCalendar_container" :class="{ FlightCalendar__loading: loading }" v-if="activeDate">
            <div class="FlightCalendar__nav">
                <div class="FlightCalendar__nav__btn" v-if="showPrevMonthBtn()">
                    <button @click="prevMonth">
                        <
                    </button>
                </div>
                <div class="FlightCalendar__month_name">
                    <span>{{$moment(activeDate, 'YYYY-MM-DD', true).format('MMMM YYYY')}}</span>
                </div>
                <div class="FlightCalendar__nav__btn FlightCalendar__nav__btn--right">
                    <button @click="nextMonth">
                        >
                    </button>
                </div>
            </div>

            <table>
                <thead>
                <tr>
                    <th>E</th>
                    <th>T</th>
                    <th>K</th>
                    <th>N</th>
                    <th>R</th>
                    <th>L</th>
                    <th>P</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(week, index) in monthDates" :key="index">
                    <td v-for="(date, index2) in week" :key="index2"
                        class="FlightCalendar__day"
                        :class="{
                            'FlightCalendar__day--no-date': !date,
                            'FlightCalendar__day--empty': date < today,
                            'FlightCalendar__day--selected': date === selectedStartDate || date === selectedEndDate,
                            'FlightCalendar__day--in-range': date > selectedStartDate && date < selectedEndDate
                        }"
                        @click="onDateClick(date)"
                    >
                        <span class="FlightCalendar__day__number" v-if="date">{{$moment(date, 'YYYY-MM-DD', true).format('D')}}</span>
                        {{getDatePrice(date)}}
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="FlightCalendar__total-price" v-if="price">
                Hind: <span>{{price}}€</span>
            </div>
            <div class="FlightCalendar__total-price" v-if="!price && hasError">
                Hind: <span>Hinda ei leitud</span>
            </div>
            <div class="FlightCalendar__selected-dates" v-if="selectedStartDate">
                Kuupäevad: <span>{{this.$moment(this.selectedStartDate, 'YYYY-MM-DD', true).format('DD.MM.YYYY')}} - {{this.selectedEndDate && this.$moment(this.selectedEndDate, 'YYYY-MM-DD', true).format('DD.MM.YYYY')}}</span>
            </div>

            <div class="FlightCalendar__book-btn" v-if="selectedStartDate && selectedEndDate">
                <a :href="getLinkSrc()" target="_blank">
                    Vaata pakkumist
                </a>
            </div>
        </div>
    </div>
</template>

<script>
import Loading from '../Loading/Loading.vue';
export default {
    components: {Loading},
    props: {
        startMonth: {
            type: String,
            required: true
        },
        endMonth: {
            type: String,
            required: true
        },
        startCode: {
            type: String,
            required: true
        },
        endCode: {
            type: String,
            required: true
        },
    },
    data() {
        let start = this.startMonth;
        let end = this.endMonth;
        if (this.startMonth < this.$moment(new Date(), 'YYYY-MM', true).format('YYYY-MM')) {
            start = this.$moment(new Date(), 'YYYY-MM', true).format('YYYY-MM')
            end = this.$moment(new Date(), 'YYYY-MM', true).add(1, 'month').format('YYYY-MM')
        }

        return {
            today: this.$moment(new Date(), 'YYYY-MM-DD', true).format('YYYY-MM-DD'),
            loading: true,
            firstMonth: start,
            lastMonth: end,
            requestStartMonth: start,
            requestEndMonth: end,
            activeDate: undefined,
            activeMonth: undefined,
            monthDates: [],
            selectedStartDate: undefined,
            selectedEndDate: undefined,
            selectedStartPrice: undefined,
            selectedEndPrice: undefined,
            data: undefined,
            price: undefined,
            hasError: false
        }
    },
    methods: {
        resetDates: function() {
            this.selectedStartDate = undefined
            this.selectedStartPrice = undefined
            this.selectedEndDate = undefined
            this.selectedEndPrice = undefined
        },
        onDateClick: function(date) {
            this.price = undefined
            this.hasError = undefined

            if (date < this.today)
                return false

            if (this.selectedStartDate && this.selectedEndDate) {
                this.resetDates()
                this.selectedStartDate = date
                if (this.data[date]) {
                    this.selectedStartPrice = this.data[date]['price']
                }
                return
            }

            if (this.selectedStartDate && this.selectedStartDate === date) {
                this.resetDates()
            } else {
                if (!this.selectedStartDate) {
                    this.selectedStartDate = date
                    if (this.data[date]) {
                        this.selectedStartPrice = this.data[date]['price']
                    }
                } else {
                    if (date < this.selectedStartDate) {
                        this.selectedEndDate = this.selectedStartDate;
                        this.selectedStartDate = date;
                    } else {
                        this.selectedEndDate = date
                    }

                    this.getSelectedDatesData()
                }
            }
        },
        prevMonth: function() {
            this.activeDate = this.$moment(this.activeDate, 'YYYY-MM-DD', true).subtract(1, 'month').format('YYYY-MM-DD')
            this.activeMonth = this.$moment(this.activeDate, 'YYYY-MM-DD', true).format('YYYY-MM')
            if (this.$moment(this.activeDate, 'YYYY-MM-DD', true).format('YYYY-MM') < this.firstMonth) {
                this.firstMonth = this.$moment(this.activeDate, 'YYYY-MM-DD', true).format('YYYY-MM')
                this.requestStartMonth = this.firstMonth
                this.requestEndMonth = this.firstMonth
                this.getMonthData()
            }
        },
        nextMonth: function() {
            this.activeDate = this.$moment(this.activeDate, 'YYYY-MM-DD', true).add(1, 'month').format('YYYY-MM-DD')
            this.activeMonth = this.$moment(this.activeDate, 'YYYY-MM-DD', true).format('YYYY-MM')
            if (this.$moment(this.activeDate, 'YYYY-MM-DD', true).format('YYYY-MM') > this.lastMonth) {
                this.requestStartMonth = this.lastMonth
                this.lastMonth = this.$moment(this.activeDate, 'YYYY-MM-DD', true).format('YYYY-MM')
                this.requestEndMonth = this.lastMonth
                this.getMonthData()
            }
        },
        showPrevMonthBtn: function() {
            return this.activeMonth > this.$moment().format('YYYY-MM')
        },
        getDatePrice: function(date) {
            if (this.selectedStartDate) {
                if (this.selectedStartDate === date && this.data[date]) {
                    return this.data[date]['price'] + '€'
                }

                const dates = this.data[this.selectedStartDate]
                if (dates && dates['dates'] && parseInt(dates['dates'][date])) {
                    const price = dates['dates'][date]
                    const diff = parseInt(price - this.selectedStartPrice)

                    if (diff === 0) {
                        return '+0€'
                    } else {
                        return diff > 0 ? '+' + diff + '€' : diff + '€'
                    }
                }
            } else {
                if (this.data[date]) {
                    return this.data[date]['price'] + '€'
                }
            }

            return ''
        },
        /*getTotalPrice: function() {
            if (this.selectedStartPrice && this.selectedEndPrice) {
                return this.selectedEndPrice > this.selectedStartPrice ? this.selectedEndPrice : this.selectedStartPrice
            }

            return null
        },*/
        getLinkSrc: function() {
            return 'https://www.skyscanner.net/g/referrals/v1/flights/day-view' +
                '?adultsv2=1' +
                '&associateid=API_B2B_19043_00001' +
                '&cabinclass=economy' +
                '&childrenv2=' +
                '&currency=EUR' +
                '&destination=' + this.endCode +
                '&inboundDate=' + this.$moment(this.selectedEndDate, 'YYYY-MM-DD', true).format('YYYYMMDD') +
                '&inboundaltsenabled=false' +
                '&locale=en-GB' +
                '&market=UK' +
                '&origin=' + this.startCode +
                '&outboundDate=' + this.$moment(this.selectedStartDate, 'YYYY-MM-DD', true).format('YYYYMMDD') +
                '&outboundaltsenabled=false' +
                '&preferdirects=false' +
                '&preferflexible=false' +
                '&rtn=1' +
                '&showDirectDays=false' +
                '&sortby=best'
        },
        setMonthDates: function() {
            if (!this.activeDate)
                return

            const activeDateObject = this.$moment(this.activeDate, 'YYYY-MM-DD', true)
            const startOfMonth = activeDateObject.startOf('month')
            const endOfMonth = activeDateObject.clone().endOf('month')
            const month = activeDateObject.month()
            const maxDays = endOfMonth.date()
            const weekCount = Math.ceil(maxDays / 7)
            const weekStart = startOfMonth.startOf('week')

            let weeks = []
            for (let i = 0; i < weekCount; i++) {
                const weekStartDay = weekStart.clone()
                let days = ['', '', '', '', '', '', '']

                for (let j = 0; j < 7; j++) {
                    if (month === weekStartDay.month())
                        days[weekStartDay.weekday()] = weekStartDay.format('YYYY-MM-DD')

                    weekStartDay.add(1, 'day')
                }

                weeks.push(days)
                weekStart.add(1, 'week')
            }

            this.monthDates = weeks
        },
        getMonthData: function() {
            this.loading = true;
            let url = '/flightcalendar/month'
            url += '?startMonth=' + this.requestStartMonth
            url += '&endMonth=' + this.requestEndMonth
            url += '&startCode=' + this.startCode
            url += '&endCode=' + this.endCode

            this.$http.get(url)
                .then(res => {
                    const data = res.data
                    if (!this.activeDate) {
                        this.activeDate = data.activeDate
                        this.activeMonth = this.$moment(this.activeDate, 'YYYY-MM-DD', true).format('YYYY-MM')
                    }

                    this.data = Object.assign( {}, data.data, this.data);
                    this.loading = false
                })
                .catch(error => {
                    this.loading = false
                });
        },
        async getSelectedDatesData() {
            this.loading = true
            this.price = undefined
            let url = '/flightcalendar/getLivePrice'
            url += '?startDate=' + this.selectedStartDate
            url += '&endDate=' + this.selectedEndDate
            url += '&startCode=' + this.startCode
            url += '&endCode=' + this.endCode

            await this.$http.get(url)
                .then(res => {
                    const price = res.data
                    if (price)
                        this.price = price
                    else
                        this.hasError = true

                    this.loading = false
                })
                .catch(error => {
                    this.loading = false
                    this.hasError = true
                });
        }
    },
    watch: {
        activeDate: function (newActiveDate, oldActiveDate) {
            this.setMonthDates()
        }
    },
    mounted: function () {
        this.setMonthDates()
    },
    created() {
        this.getMonthData()
    }
}
</script>
