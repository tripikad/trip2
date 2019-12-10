<template>
    <div class="OfferList" :class="isclasses">
        <!--Dotmap :largedots="filteredOfferList.map(o => o.coordinates)" /-->
        <pre>
        {{ uniques }}
        </pre>
        <div class="OfferList__offers">
            <OfferRow v-for="(offer, i) in filteredOfferList" :key="i" :offer="offer" :route="offer.route" />
        </div>
        <ButtonVue v-if="nextPageUrl" @click.native.prevent="getData" title="Gimme data" />
    </div>
</template>

<script>
import { uniqueFilter, toObject } from '../../utils/utils'

const filters = [
    {
        key: 'company',
        unique: o => o.user.id,
        result: o => ({ id: o.id, name: o.user.name })
    },
    {
        key: 'style',
        unique: o => o.style,
        result: o => ({ id: o.style, name: o.style })
    }
]

export default {
    props: {
        isclasses: { default: '' },
        route: { default: '' }
    },
    data: () => ({
        offers: [],
        nextPageUrl: null,
        activeFilters: {
            userId: -1
        }
    }),
    computed: {
        uniques() {
            return toObject(
                filters.map(({ key, unique, result }) => {
                    return [key, uniqueFilter(this.offers, unique).map(result)]
                })
            )
        },

        filteredOfferList() {
            return this.offers
        }
    },
    methods: {
        getData() {
            if (this.nextPageUrl) {
                this.$http.get(this.nextPageUrl).then(({ data }) => {
                    this.offers = [...this.offers, ...data.data]
                    this.nextPageUrl = data.next_page_url ? data.next_page_url : null
                })
            }
        }
    },
    mounted() {
        this.$http.get(this.route).then(({ data }) => {
            this.offers = [...this.offers, ...data.data]
            this.nextPageUrl = data.next_page_url
        })
    }
}
</script>
