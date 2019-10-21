<template>
  <div class="OfferRow" :class="isclasses">{{ offer }}</div>
</template>

<script>
export default {
  props: {
    isclasses: { default: "" },
    offer: { default: {} }
  },
};
</script>
