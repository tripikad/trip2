<template>
  <div>
    <div class="FormAccordion" :class="isclasses">
      <div
        v-for="(item, i) in items"
        :key="i"
        class="FormAccordion__button"
        :class="i == activeIndex ? 'FormAccordion__button--active' : ''"
        @click="
          activeIndex = i
          $emit('input', activeIndex)
        "
        v-html="item"
      ></div>
    </div>
    <input v-model="activeIndex" v-show="false" type="text" :name="name" />
  </div>
</template>

<script>
export default {
  props: {
    isclasses: { default: '' },
    name: { default: '' },
    value: { default: 0 },
    items: { default: [] }
  },
  data: () => ({
    activeIndex: 0
  }),
  mounted() {
    this.$watch('value', value => (this.activeIndex = value), { immediate: true })
  }
}
</script>
