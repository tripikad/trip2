<template>

    <svg :width="width" :height="height">

        <path
            v-for="path in paths"
            fill="gray"
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
            isclasses: {default: ''}
        },

        data() {
            return {
                paths: [],
                width: 600,
                height: 300,
                radius: 2
            }
        },

        ready() {
            var converter = geojson2svg({
                viewportSize: {width: this.width, height: this.height},
                mapExtent: {left: -162, bottom: -52, right: 183, top: 87},
                output: 'path',
                pointAsCircle: true,
                r: this.radius
            })

            for (var lat = -54; lat < 85; lat += 3) {
                for (var lon = -159; lon < 181; lon += 3) {
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