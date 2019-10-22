<template>
    <div class="Offers" :class="isclasses">
        <div class="Offers__filters">
            <form-select placeholder="Company" :options="companies" v-model="activeCompany" />
            <form-select
                placeholder="Destination"
                :options="destinations"
                v-model="activeDestination"
            />
        </div>
        <!--
        <form-select-multiple :options="options" v-model="activeOptions" />
        {{ activeOptions }}
        -->
        <div class="Offers__offers">
            <OfferRow v-for="(offer, i) in filteredOffers" :key="i" :offer="offer" />
        </div>
    </div>
</template>

<script>
import { parseSheets, unique } from '../../utils/utils'

export default {
    props: {
        isclasses: { default: '' }
    },
    data: () => ({
        offers: [],
        id: '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE',
        activeCompany: -1,
        activeDestination: -1
    }),
    computed: {
        companies() {
            return unique(
                this.offers.map(o => o.company)
            ).map((name, id) => ({
                id,
                name
            }))
        },
        destinations() {
            return unique(
                this.offers.map(o => o.destination)
            ).map((name, id) => ({
                id,
                name
            }))
        },
        filteredOffers() {
            return this.offers
                .filter(o => {
                    if (this.activeCompany > -1) {
                        return (
                            o.company ==
                            this.getById(
                                this.companies,
                                this.activeCompany,
                                'name'
                            )
                        )
                    }
                    return true
                })
                .filter(o => {
                    if (this.activeDestination > -1) {
                        return (
                            o.destination ==
                            this.getById(
                                this.destinations,
                                this.activeDestination,
                                'name'
                            )
                        )
                    }
                    return true
                })
        }
    },
    methods: {
        getById(data, id, key) {
            if (data.length) {
                return data.filter(d => d.id == id)[0][key]
            }
            return null
        }
    },
    mounted() {
        fetch(
            `https://spreadsheets.google.com/feeds/list/${this.id}/od6/public/values?alt=json`
        )
            .then(res => res.json())
            .then(res => {
                this.offers = parseSheets(res)
            })
    }
}
</script>
