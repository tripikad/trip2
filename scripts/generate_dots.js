var turf = require('@turf/turf')
var countries = require('./data/countries.json')
var codes = require('./data/codes.json')
var destinations = require('./data/destinations_data.json')

function iso3to2(iso3) {
    var code = codes.find(code => code['ISO3166-1-Alpha-3'] === iso3)
    return code ? code['ISO3166-1-Alpha-2'] : iso3
}

function iso3toId(iso3) {
    var destination = destinations.find(destination => destination.code === iso3to2(iso3))
    return destination ? destination.id : 0;
}

var lat = 0
var lon = 0
var step = 2.5
var halfStep = step / 2

var circles = []

for (var lat = 80; lat > -80; lat -= step) {

    for (var lon = -180; lon < 180; lon += step) {

        var box = turf.polygon([[
            [lon - halfStep, lat + halfStep],
            [lon + halfStep, lat + halfStep],
            [lon + halfStep, lat - halfStep],
            [lon - halfStep, lat - halfStep],
            [lon - halfStep, lat + halfStep]
        ]])
        var circle = turf.circle(turf.point([lon, lat]), halfStep, 8, 'degrees')
        var circle = turf.point([lon, lat]);

        circle.properties.countries = []

        countries.features
            .slice(0, 2)
            .filter(country => country.properties.name !== 'Antarctica')
            .forEach(country => {
            
            if (country.geometry.type === 'Polygon') {
                var intersection = turf.intersect(
                    box,
                    turf.polygon(country.geometry.coordinates)
                )
                if (intersection !== undefined) {
                    circle.properties.countries.push(iso3toId(country.id))
                }
            }
            if (country.geometry.type === 'MultiPolygon') {
                country.geometry.coordinates.forEach(polygon => {
                    var intersection = turf.intersect(
                        box,
                        turf.polygon(polygon)
                    )
                    if (intersection !== undefined) {
                        circle.properties.countries.push(iso3toId(country.id))
                    }
                })
            }
        })

        if (circle.properties.countries.length > 0) {
            circles.push(circle)
        }

    }
}

console.log('<?php\n\nreturn [\n')

circles.forEach(circle => {
    console.log(`    [
        'destination_ids' => [${circle.properties.countries}],
        'lat' => ${circle.geometry.coordinates[1]},
        'lon' => ${circle.geometry.coordinates[0]}
    ],`);
})

console.log('\n];\n')

