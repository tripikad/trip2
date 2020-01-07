<template>
  <div>
    <!-- @TODO2 Translate titles -->
    <ButtonVue
      @click.native.prevent="onClick"
      isclasses="Button--small Button--pink Button--narrow"
      :title="published ? 'Peida' : 'Tee avalikuks'"
    />
  </div>
</template>

<script>
export default {
  props: {
    isclasses: { default: '' },
    publish_route: { default: '' },
    unpublish_route: { default: '' },
    published: { default: true }
  },
  data: () => ({
    currentPublished: true
  }),
  methods: {
    onClick() {
      if (this.currentPublished) {
        this.$http.post(this.unpublish_route).then(({ data }) => {
          this.$events.$emit('alert', { title: data })
          this.currentPublished = false
        })
      } else {
        this.$http.post(this.publish_route).then(({ data }) => {
          this.$events.$emit('alert', { title: data })
          this.currentPublished = true
        })
      }
      setTimeout(() => document.location.reload(true), 1000)
    }
  },
  mounted() {
    this.$watch('published', published => (this.currentPublished = !!published), { immediate: true })
  }
}
</script>
