const { point, polygon } = require('@turf/helpers')
const intersect = require('@turf/intersect').default
const turf = { point, polygon, intersect }

const countries = require(__dirname + '/data/countries.json')
const destinations = require(__dirname + '/data/trip_facts.json')

const iso3toId = iso3 => {
    const destination = destinations.find(d => d.country_code3 === iso3)
    return destination ? destination.id : 0
}

// Starting dot generation

const step = 2.5
const halfStep = step / 25

let dots = []

// Loop over world Y-axis

for (let lat = 80; lat > -80; lat -= step) {
    // Loop over world X-axis

    for (let lon = -180 + step * 5; lon < 180 + step * 5; lon += step) {
        // Set up a square polygon with dot coordinates in the center

        const box = turf.polygon([
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

        const dot = turf.point([lon, lat])

        dot.properties.countries = []

        // Loop over countries to find the intersection with our
        // square. If there is an intersection, add the country to
        // the dot.properties.countries array

        countries.features
            //.slice(0, 3)
            .filter(country => country.properties.name !== 'Antarctica')
            .forEach(country => {
                if (country.geometry.type === 'Polygon') {
                    const intersection = turf.intersect(
                        box,
                        turf.polygon(country.geometry.coordinates)
                    )
                    if (intersection !== null) {
                        dot.properties.countries.push(iso3toId(country.id))
                    }
                }
                if (country.geometry.type === 'MultiPolygon') {
                    country.geometry.coordinates.forEach(polygon => {
                        const intersection = turf.intersect(
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
