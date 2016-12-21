<template>

    <svg :width="width" :height="height">

        <path
            v-for="path in paths"
            fill=""
            :d="path"
         />

    </div>

</template>

<script>

    import turf from 'turf'
    import geojson2svg from 'geojson2svg'
    import countries from './countries.json'

    export default {

        props: {
            isclasses: {default: ''},
            left: {default: '-162'},
            bottom: {default: '-52'},
            right: {default: '183'},
            top: {default: '87'},
            step: {default: 3},
            radius: {default: 3}
        },

        computed: {
            width: function() {
                return Math.abs(this.left) + Math.abs(this.right) * 5
            },
            height: function() {
                return Math.abs(this.top) + Math.abs(this.bottom) * 5
            }

        },

        data() {
            return {
                paths: []
            }
        },

        mounted() {
            var converter = geojson2svg({
                viewportSize: {width: this.width, height: this.height},
                mapExtent: {left: this.left, bottom: this.bottom, right: this.right, top: this.top},
                output: 'path',
                pointAsCircle: true,
                r: this.radius
            })

            for (var lat = -54; lat < 85; lat += this.step) {
                for (var lon = -159; lon < 181; lon += this.step) {
                    if (this.getPointData(lat, lon)) {
                        var path = converter.convert({
                            type: 'Point', coordinates: [lon, lat]
                        })

                        this.paths.push(path)
                    }
                }
            }
        },

        methods: {

            getPointData: function(lat, lon) {
                var show = false

                countries.features.forEach(function(country) {
                    if (country.geometry.type === 'Polygon' &&
                        turf.inside(
                            turf.point([lon, lat]),
                            turf.polygon(country.geometry.coordinates)
                        )
                    ) { show = true }

                    if (country.geometry.type === 'MultiPolygon') {
                        country.geometry.coordinates.forEach(function(polygon) {
                            if (turf.inside(
                                turf.point([lon, lat]),
                                turf.polygon(polygon))
                            ) { show = true }
                        })
                    }
                })

                return show
            }
        }

    }

</script>