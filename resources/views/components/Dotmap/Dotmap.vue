<template>
  <div class="Dotmap" :class="isclasses">
    <svg :width="currentWidth" :height="currentHeight">
      <g>
        <circle
          v-for="(c, i) in countrydots"
          :key="i"
          :cx="xScale(c[0])"
          :cy="yScale(c[1])"
          :r="radius"
          :fill="$styles[backgroundcolor] || backgroundcolor"
        />
      </g>
      <g v-if="activeCountryDots.length">
        <circle
          v-for="(c, i) in activeCountryDots"
          :key="i"
          :cx="xScale(c[0])"
          :cy="yScale(c[1])"
          :r="radius"
          :fill="$styles[dotcolor] || dotcolor"
        />
      </g>
      <g v-if="smalldots.length">
        <circle
          v-for="(c, i) in smalldots"
          :key="i"
          :cx="xScale(c.lon)"
          :cy="yScale(c.lat)"
          :r="radius"
          :fill="$styles[smalldotcolor] || smalldotcolor"
        />
      </g>
      <path
        v-if="lines.length"
        :d="line(lines)"
        :stroke="$styles[linecolor] || linecolor"
        stroke-width="2"
        fill="none"
      />
      <g v-if="mediumdots.length">
        <circle
          v-for="(d, i) in mediumdots"
          :key="i"
          :cx="xScale(d.lon)"
          :cy="yScale(d.lat)"
          :r="radius * 2"
          :stroke="$styles[linecolor] || linecolor"
          stroke-width="2"
          :fill="$styles[mediumdotcolor] || mediumdotcolor"
        />
      </g>
      <g v-if="largedots.length">
        <circle
          v-for="(d, i) in largedots"
          :key="i"
          :cx="xScale(d.lon)"
          :cy="yScale(d.lat)"
          :r="largeRadius"
          :stroke="$styles[linecolor] || linecolor"
          stroke-width="2"
          :fill="$styles[largedotcolor] || largedotcolor"
        />
      </g>
    </svg>
  </div>
</template>

<script>
import { geoEquirectangular, geoPath } from 'd3-geo'
import { intersection, debounce, setCssVariable } from '../../utils/utils'

export default {
  props: {
    isclasses: { default: '' },
    width: { default: 700 },
    height: { default: 'auto' },
    areas: { default: () => [] },
    smalldots: { default: () => [] },
    mediumdots: { default: () => [] },
    largedots: { default: () => [] },
    lines: { default: () => [] },
    backgroundcolor: { default: 'rgba(0,0,0,0.25)' },
    dotcolor: { default: 'white' },
    smalldotcolor: { default: 'white' },
    mediumdotcolor: { default: 'orange' },
    largedotcolor: { default: 'orange' },
    linecolor: { default: 'white' }
  },
  data: function() {
    return {
      countrydots: [],
      currentWidth: this.width,
      tabletBreakpoint: 700,
      mobileWidth: 370
    }
  },
  computed: {
    currentHeight() {
      return this.currentWidth / 2
    },
    projection() {
      const xOffset = 0.08
      const yOffset = 0.2
      return geoEquirectangular()
        .scale(this.currentWidth / 8)
        .translate([this.currentWidth / 2 - this.currentWidth * xOffset, this.currentHeight / (2 - yOffset)])
        .precision(0.1)
    },
    geopath() {
      return geoPath().projection(projection)
    },
    radius() {
      return this.currentWidth / 350
    },
    largeRadius() {
      return this.currentWidth < this.tabletBreakpoint ? 7 : this.radius * 3
    },
    activeCountryDots() {
      return this.countrydots.filter(d => intersection(d[2], this.areas).length)
    }
  },

  methods: {
    line(coordinates) {
      return geoPath().projection(this.projection)({
        type: 'FeatureCollection',
        features: [
          {
            type: 'Feature',
            geometry: {
              type: 'LineString',
              coordinates: coordinates.map(({ lon, lat }) => [lon, lat])
            }
          }
        ]
      })
    },
    xScale(lon) {
      return this.projection([lon, 0])[0]
    },
    yScale(lat) {
      return this.projection([0, lat])[1]
    },
    setSize() {
      // @TODO2 Remove this hack
      if (window.innerWidth > this.tabletBreakpoint) {
        this.currentWidth = this.width
        setCssVariable('--Dotmap--height', `calc(${this.$styles['spacer']} * 30`)
      } else {
        this.currentWidth = this.mobileWidth
        setCssVariable('--Dotmap--height', 'auto')
      }
    },
    onResize: debounce(function() {
      this.setSize()
    }, 200)
  },
  mounted() {
    this.setSize()
    this.$http.get('/api/countrydots').then(res => {
      this.countrydots = res.data
    })
  },
  created() {
    window.addEventListener('resize', this.onResize)
  },
  destroyed() {
    window.removeEventListener('resize', this.onResize)
  }
}
</script>
