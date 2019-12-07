const _ = require('lodash')
const baby = require('babyparse')
const { readFileSync } = require('fs')

const destinations = require(__dirname + '/data/geonames_destinations.json')
const countries = require(__dirname + '/data/geonames_countries.json')
const dialcodes = require(__dirname + '/data/dialcodes.json')

const codes = baby.parse(readFileSync(__dirname + '/data/codes.csv', 'utf8'), {
  header: true
}).data

function iso2to3(iso2) {
  const code = codes.find(code => code['ISO3166-1-Alpha-2'] === iso2)
  return code ? code['ISO3166-1-Alpha-3'] : ''
}

const makeFloat = str => {
  const f = parseFloat(str)
  return Number.isNaN(f) ? false : f
}

const destinationData = destinations.map(data => {
  const country = countries.geonames.filter(c => c.countryCode == data.countryCode)[0]
  const dialcode = dialcodes.filter(c => c.countryCode == data.code)[0]
  return {
    id: data.id,
    english_name: data.name,
    type: data.type,
    timezone: data.timezone && data.timezone.gmtOffset ? data.timezone.gmtOffset : false,
    country_code2: data.countryCode !== undefined ? data.countryCode : false,
    country_code3: data.countryCode !== undefined && iso2to3(data.countryCode) ? iso2to3(data.countryCode) : false,
    geoname_id: data.geonameId !== undefined ? data.geonameId : false,
    capital: country && country.capital ? country.capital : '',
    area: data.type == 'country' && country && country.areaInSqKm ? makeFloat(country.areaInSqKm) : false,
    currency_code: country && country.currencyCode ? country.currencyCode : '',
    population: data.population !== undefined ? data.population : false,
    lat: makeFloat(data.lat),
    lon: makeFloat(data.lng),
    calling_code: dialcode && dialcode.dial_code ? dialcode.dial_code : ''
  }
})

if (process.argv[2] == '--json') {
  console.log(JSON.stringify(_.sortBy(destinationData, 'id'), null, 2))
} else {
  console.log('<?php\n\nreturn [\n')

  _.sortBy(destinationData, 'id').forEach(d => {
    console.log(`    ${d.id} => [
        'type' => '${d.type}',
        'english_name' => '${d.english_name.replace(`'`, '')}',
        'timezone' => ${d.timezone},
        'country_code2' => '${d.country_code2}',
        'country_code3' => '${d.country_code3}',
        'geoname_id' => ${d.geoname_id},
        'capital' => ${typeof d.capital == 'boolean' ? d.capital : `'${d.capital.replace(`'`, '')}'`},
        'currency_code' => '${d.currency_code}',
        'population' => ${d.population},
        'area' => ${d.area},
        'lat' => ${d.lat},
        'lon' => ${d.lon},
        'calling_code' => '${d.calling_code}'
    ],`)
  })

  console.log('\n];\n')
}
