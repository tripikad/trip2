var _ = require('lodash')

var geonames = require(__dirname + '/data/geonames.json')

const citiesData = geonames
    .filter(city => city.type == 'city')
    .map(data => ({
        id: data.id,
        name: data.name,
        lat: data.lat,
        lon: data.lng,
        capital: data.fcodeName === 'capital of a political entity',
        geonameId: data.geonameId,
        population: data.population
    }))

console.log('<?php\n\nreturn [\n')

_.sortBy(citiesData, 'id').forEach(city => {
    console.log(`    ${city.id} => [
        'name' => '${city.name.replace(`'`, '')}',
        'lat' => ${city.lat},
        'lon' => ${city.lon},
        'capital' => ${city.capital},
        'population' => ${city.population},
        'geoname' => ${city.geonameId},
    ],`)
})

console.log('\n];\n')
