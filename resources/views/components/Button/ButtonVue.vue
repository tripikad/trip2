<template>
  <a :href="route" :target="external ? '_blank' : ''" dusk="slugTitle">
    <div class="Button" :class="isclasses">
      <div v-if="icon" class="Button__icon">
        <!-- component('Icon')->is('white')->with('icon', $icon) !!} -->
      </div>

      <div class="Button__title">{{ title }}</div>
    </div>
  </a>
</template>

<script>
import { slug } from '../../utils/utils'

export default {
  props: {
    isclasses: { default: '', type: String },
    route: { default: '', type: String },
    external: {
      default: false,
      type: [Boolean, String]
    },
    icon: { default: '', type: String },
    title: { default: '', type: String }
  },
  computed: {
    slugTitle() {
      return this.title ? slug(this.title) : ''
    }
  }
}
</script>
