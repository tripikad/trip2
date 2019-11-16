var fs = require('fs')
var { point, polygon } = require('@turf/helpers')
var intersect = require('@turf/intersect').default
const turf = { point, polygon, intersect }
var baby = require('babyparse')

var countries = require(__dirname + '/data/countries.json')
var destinations = require(__dirname + '/data/destinations2.json')

// var codes = baby.parse(fs.readFileSync(__dirname + '/data/codes.csv', 'utf8'), {
//     header: true
// }).data

// Utilities

// Mapping 3-letter ISO country codes to 2-letter ISO codes

// function iso3to2(iso3) {
//     var code = codes.find(code => code['ISO3166-1-Alpha-3'] === iso3)
//     return code ? code['ISO3166-1-Alpha-2'] : iso3
// }

// Mapping the 3-letter ISO code to trip.ee's Destination model id

function iso3toId(iso3) {
    var destination = destinations.find(d => d.country_code3 === iso3)
    return destination ? destination.id : 0
}

// Starting dot generation

var lat = 0
var lon = 0
var step = 2.5
var halfStep = step / 25

var dots = []

// Loop over world Y-axis

for (var lat = 80; lat > -80; lat -= step) {
    // Loop over world X-axis

    for (var lon = -180; lon < 180; lon += step) {
        // Set up a square polygon with dot coordinates in the center

        var box = turf.polygon([
            [
                [lon - halfStep, lat + halfStep],
                [lon + halfStep, lat + halfStep],
                [lon + halfStep, lat - halfStep],
                [lon - halfStep, lat - halfStep],
                [lon - halfStep, lat + halfStep]
            ]
        ])

        // Set up the dot to be generated as a GeoJSON object
        // for easier debuggability with tools like geojson.io

        var dot = turf.point([lon, lat])

        dot.properties.countries = []

        // Loop over countries to find the intersection with our
        // square. If there is an intersection, add the country to
        // the dot.properties.countries array

        countries.features
            //.slice(0, 3)
            .filter(country => country.properties.name !== 'Antarctica')
            .forEach(country => {
                if (country.geometry.type === 'Polygon') {
                    var intersection = turf.intersect(
                        box,
                        turf.polygon(country.geometry.coordinates)
                    )
                    if (intersection !== null) {
                        dot.properties.countries.push(iso3toId(country.id))
                    }
                }
                if (country.geometry.type === 'MultiPolygon') {
                    country.geometry.coordinates.forEach(polygon => {
                        var intersection = turf.intersect(
                            box,
                            turf.polygon(polygon)
                        )
                        if (intersection !== null) {
                            dot.properties.countries.push(iso3toId(country.id))
                        }
                    })
                }
            })

        if (dot.properties.countries.length > 0) {
            dots.push(dot)
        }
    }
}

// Generate the PHP array output

console.log('<?php\n\nreturn [\n')

dots.forEach(dot => {
    console.log(`    [
        'destination_ids' => [${dot.properties.countries}],
        'lat' => ${dot.geometry.coordinates[1]},
        'lon' => ${dot.geometry.coordinates[0]}
    ],`)
})

console.log('\n];\n')
