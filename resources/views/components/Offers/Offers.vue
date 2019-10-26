<template>
    <div class="Offers" :class="isclasses">
        <!--div class="Offers__filters">
            <form-buttons :items="['Kõik','Seiklusreisid','Bussireisid','Pakettreisid']" />
        </div-->
        <div class="Offers__filters">
            <form-select placeholder="Firma" :options="companies" v-model="activeCompany" />
            <form-select placeholder="Sihkoht" :options="destinations" v-model="activeDestination" />
            <form-select placeholder="Reisistiil" :options="styles" v-model="activeStyle" />
            <a v-if="!notFiltered" @click="handleClearFilters" class="Button Button--gray">Show all</a>
        </div>
        <div class="Offers__offers">
            <OfferRow
                v-for="(offer, i) in filteredOffers"
                :key="i"
                :offer="offer"
                @click.native="$events.$emit('offer', offer)"
            />
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
        activeDestination: -1,
        activeStyle: -1
    }),
    computed: {
        notFiltered() {
            return (
                this.activeCompany == -1 &&
                this.activeDestination == -1 &&
                this.activeStyle == -1
            )
        },
        companies() {
            return unique(this.offers.map(o => o.company)).map((name, id) => ({
                id,
                name
            }))
        },
        destinations() {
            return unique(this.offers.map(o => o.destination)).map(
                (name, id) => ({
                    id,
                    name
                })
            )
        },
        styles() {
            return unique(this.offers.map(o => o.style)).map((name, id) => ({
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
                .filter(o => {
                    if (this.activeStyle > -1) {
                        return (
                            o.style ==
                            this.getById(this.styles, this.activeStyle, 'name')
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
        },
        handleClearFilters() {
            this.activeCompany = -1
            this.activeDestination = -1
            this.activeStyle = -1
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
