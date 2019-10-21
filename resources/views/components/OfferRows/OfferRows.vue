<template>
  <div class="OfferRows" :class="isclasses">
    <OfferRow v-for="(offer, i) in offers" :key="i" :offer="offer" />
  </div>
</template>

<script>

import { parseSheets } from "../../utils/utils";

export default {
  props: {
    isclasses: { default: "" }
  },
  data: () => ({
    offers: [],
    id: '1TLEDlvDC_06gy75IhNAyXaUjt-9oOT2XOqW2LEpycHE'
  }),
  mounted() {
    fetch(
        `https://spreadsheets.google.com/feeds/list/${
          this.id
        }/od6/public/values?alt=json`
      )
        .then(res => res.json())
        .then(res => {
          this.offers = parseSheets(res)
        });
  }
};
</script>
