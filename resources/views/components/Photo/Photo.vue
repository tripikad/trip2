<template>
  <div class="Photo" :class="isclasses" @click="onClick">
    <img class="Photo__image" :src="image" />
  </div>
</template>

<script>
export default {
  props: {
    isclasses: { default: '' },
    image: { default: '' },
    large_image: { default: '' },
    meta: { default: '' }
  },
  methods: {
    onClick() {
      if (this.large_image) {
        this.$events.$emit('photo', {
          large: this.large_image,
          meta: this.meta
        })
      }
    }
  }
}
</script>