<template>
  <div class="OfferRow" :class="isclasses">
    <img class="OfferRow__image" :src="offer.image" />
    <div>
      <div class="OfferRow__title">{{ offer.title }}</div>
      <div class="OfferRow__meta">{{ meta.join(' ') }}</div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    isclasses: { default: "" },
    offer: { default: {} }
  },
  computed: {
    meta() {
      return Object.entries(this.offer)
        .filter(([key]) => key !== "title" && key !== "image")
        .map(([key, value]) => value);
    }
  }
};
</script>
