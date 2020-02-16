var request = require('request')
var async = require('async')
var _ = require('lodash')

// Destinations exported from Trip's destinations table

var destinations = require(__dirname + '/data/trip_destinations.json')

// Manually edited mapping between destination names and Geoname IDs
// These are the destinations that can not be queried against Geonames API
// by the name only

var manualDestinations = [
    { id: 311, name: 'Ameerika Ühendriigid', geonameId: 6252001 },

    { id: 322, name: 'Iirimaa', geonameId: 2963597 },
    { id: 715, name: 'Sao Tome', geonameId: 2410758 },
    { id: 1111, name: 'Kiribati', geonameId: 4030945 },

    { id: 383, name: 'Fääri saared', geonameId: 2622320 },
    { id: 424, name: 'Tasmaania', geonameId: 2147291 },
    { id: 432, name: 'Olümpos', geonameId: 734890 },
    { id: 446, name: 'Kamtshatka', geonameId: 2125073 },
    { id: 447, name: 'Lapimaa', geonameId: 830603 },
    { id: 457, name: 'Madriid', geonameId: 3117732 },
    { id: 460, name: 'Šotimaa', geonameId: 2638360 },
    { id: 498, name: 'Brüssel', geonameId: 3337389 },
    { id: 510, name: 'Öland', geonameId: 2687204 },
    { id: 537, name: 'Lofoodid', geonameId: 3147088 },
    { id: 540, name: 'Veneetsia', geonameId: 3164600 },
    { id: 573, name: 'Himaalaja', geonameId: 1252558 },
    { id: 590, name: 'Suur Kanjon', geonameId: 5539912 },
    { id: 636, name: 'Victoria juga', geonameId: 879431 },
    { id: 663, name: 'Dalmaatsia', geonameId: 3202210 },
    { id: 669, name: 'Lihavõttesaar', geonameId: 4030726 },
    { id: 733, name: 'Tiibet', geonameId: 1279685 },
    { id: 771, name: 'München', geonameId: 6559171 },
    { id: 1103, name: 'Teravmäed', geonameId: 7535696 },
    { id: 1244, name: 'Milaano', geonameId: 6542283 },
    { id: 1300, name: 'Baierimaa', geonameId: 2951839 },
    { id: 1554, name: 'Köln', geonameId: 6553049 },
    { id: 1678, name: 'Tatrad', geonameId: 11102654 },
    { id: 1743, name: 'Kataloonia', geonameId: 3336901 },
    { id: 2095, name: 'Düsseldorf', geonameId: 6553022 },
    { id: 2511, name: 'Kilimandžaaro', geonameId: 157452 },
    { id: 3130, name: 'Kuldsed liivad', geonameId: 6355004 },
    { id: 3729, name: 'Patagoonia', geonameId: 3841798 },
    { id: 4344, name: 'Päikeserannik', geonameId: 2510850 },
    { id: 4348, name: 'Zürich', geonameId: 2657895 },
    { id: 4349, name: 'Markiisisaared', geonameId: 4019977 },
    { id: 4354, name: 'Kapadookia', geonameId: 8378488 },
    { id: 4365, name: 'Angeli juga', geonameId: 9957305 },
    { id: 4621, name: 'Göteborg', geonameId: 2711537 },
    { id: 4640, name: 'Gili saared', geonameId: 1631161 },
    { id: 4647, name: 'Biškek', geonameId: 1528334 },
    { id: 4664, name: 'Dušanbe', geonameId: 1221874 },
    { id: 4719, name: 'Alžiir', geonameId: 2507480 }
]

var citiesData = []

var continents = destinations
    .filter(continent => continent.parent_id == null)
    .map(c => {
        c.type = 'continent'
        return c
    })

var countries = destinations
    .filter(country => continents.find(continent => continent.id === country.parent_id))
    .map(c => {
        c.type = 'country'
        return c
    })

var a = destinations.filter(country => country.id == 338)

var cities = destinations
    .filter(city => countries.find(country => country.id === city.parent_id))
    .map(c => {
        c.type = 'city'
        return c
    })

var places = destinations
    .filter(place => cities.find(city => city.id === place.parent_id))
    .map(c => {
        c.type = 'place'
        return c
    })

async.each(
    [...continents, ...countries, ...cities, ...places],
    (city, cb) => {
        var cityData = {}
        var id = manualDestinations.find(result => result.id === city.id)

        // Query each destination from Geonames API by its name or Geoname ID

        var url = !!id
            ? 'http://api.geonames.org/getJSON?username=kristjanjansen&geonameId=' + id.geonameId
            : 'http://api.geonames.org/searchJSON?formatted=true&q=' +
              encodeURIComponent(city.name) +
              '&maxRows=1&username=kristjanjansen&style=full&lang=et'

        request({ url, json: true }, (err, res, body) => {
            if (body) {
                var data = body.geonames && body.geonames[0] ? body.geonames[0] : body

                citiesData.push({
                    type: city.type,
                    id: city.id,
                    name: city.name.replace('Ĩ', 'Š'),
                    ...data,
                    alternateNames: []
                })
            }
            setTimeout(cb, 1000)
        })
    },
    () => {
        console.log(JSON.stringify(citiesData, null, 2))
    }
)
