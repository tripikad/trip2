var _ = require('lodash')

var countries = require(__dirname + '/data/geonames_countries.json')
var destinations = require(__dirname + '/data/geonames_destinations.json')
var dialcodes = require(__dirname + '/data/dialcodes.json')

const destinationsData = destinations
    .slice(0, 3)
    .filter(data => data.type == 'country')
    .map(data => {
        const country = countries.geonames.filter(
            c => c.countryCode == data.countryCode
        )[0]
        const dialcode = dialcodes.filter(c => c.countryCode == data.code)[0]
        return {
            id: data.id,
            name: data.name,
            countryCode: data.countryCode,
            capital: country && country.capital ? country.capital : '',
            area: country && country.areaInSqKm ? country.areaInSqKm : '',
            currencCode:
                country && country.currencyCode ? country.currencyCode : '',
            population: data.population,
            // callingCode
            lat: parseFloat(data.lat),
            lon: parseFloat(data.lng),
            callingCode:
                dialcode && dialcode.dial_code ? dialcode.dial_code : ''
        }
    })

console.log(destinationsData)

//console.log('<?php\n\nreturn [\n')

/*
381 => [
  'code' => 'AD',
  'capital' => 'Andorra la Vella',
  'area' => 468,
  'population' => '84000',
  'callingCode' => '376',
  'currencyCode' => 'EUR',
],

{
    "type": "country",
    "id": 381,
    "name": "Andorra",
    "timezone": {
      "gmtOffset": 1,
      "timeZoneId": "Europe/Andorra",
      "dstOffset": 2
    },
    "bbox": {
      "east": 1.786576000000025,
      "south": 42.42874300100004,
      "north": 42.65576500000003,
      "west": 1.413760001000071,
      "accuracyLevel": 10
    },
    "asciiName": "Principality of Andorra",
    "astergdem": 1785,
    "countryId": "3041565",
    "fcl": "A",
    "srtm3": 1802,
    "score": 147.78631591796875,
    "countryCode": "AD",
    "lat": "42.55",
    "fcode": "PCLI",
    "continentCode": "EU",
    "adminCode1": "00",
    "lng": "1.58333",
    "geonameId": 3041565,
    "toponymName": "Principality of Andorra",
    "population": 84000,
    "adminName5": "",
    "adminName4": "",
    "adminName3": "",
    "adminName2": "",
    "fclName": "country, state, region,...",
    "countryName": "Andorra",
    "fcodeName": "independent political entity",
    "adminName1": ""
  },
  
*/

// _.sortBy(citiesData, 'id').forEach(city => {
//     console.log(`    ${city.id} => [
//         'name' => '${city.name.replace(`'`, '')}',
//         'lat' => ${city.lat},
//         'lon' => ${city.lon},
//         'capital' => ${city.capital},
//         'population' => ${city.population},
//         'geoname' => ${city.geonameId},
//     ],`)
// })

// console.log('\n];\n')
