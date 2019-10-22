<template>
    <div class="Offers" :class="isclasses">
        <form-select-multiple :options="options" />
        {{ activeOptions }}
        <div class="Offers__offers">
            <OfferRow v-for="(offer, i) in offers" :key="i" :offer="offer" />
        </div>
    </div>
</template>

<script>
import { parseSheets } from '../../utils/utils'

export default {
    props: {
        isclasses: { default: '' }
    },
    data: () => ({
        offers: [],
        id: '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE',
        options: [
            { id: 1, name: 'hello' },
            { id: 2, name: 'wold' }
        ],
        activeOptions: []
    }),
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
