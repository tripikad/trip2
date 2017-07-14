/*

Routes schema
http://openflights.org/data.html
The data is ISO 8859-1 (Latin-1) encoded

0 Airline 2-letter (IATA) or 3-letter (ICAO) code of the airline.
1 Airline ID  Unique OpenFlights identifier for airline (see Airline).
2 Source airport  3-letter (IATA) or 4-letter (ICAO) code of the source airport.
3 Source airport ID   Unique OpenFlights identifier for source airport (see Airport)
4 Destination airport 3-letter (IATA) or 4-letter (ICAO) code of the destination airport.
5 Destination airport ID  Unique OpenFlights identifier for destination airport (see Airport)
6 Codeshare   "Y" if this flight is a codeshare (that is, not operated by Airline, but another carrier), empty otherwise.
7 Stops   Number of stops on this flight ("0" for direct)
8 Equipment   3-letter codes for plane type(s) generally used on this flight, separated by spaces

Airports schema
http://openflights.org/data.html
The data is ISO 8859-1 (Latin-1) encoded

0 Airport ID: Unique OpenFlights identifier for this airport.
1 Name:  Name of airport. May or may not contain the City name.
2 City: Main city served by airport. May be spelled differently from Name.
3 Country: Country or territory where airport is located. See countries.dat to cross-reference to ISO 3166-1 codes.
4 IATA: 3-letter IATA code. Null if not assigned/unknown.
5 ICAO: 4-letter ICAO code. Null if not assigned.
6 Latitude: Decimal degrees, usually to six significant digits. Negative is South, positive is North.
7 Longitude: Decimal degrees, usually to six significant digits. Negative is West, positive is East.
8 Altitude: In feet.
9 Timezone: Hours offset from UTC. Fractional hours are expressed as decimals, eg. India is 5.5.
10 DST: Daylight savings time. One of E (Europe), A (US/Canada), S (South America), O (Australia), Z (New Zealand), N (None) or U (Unknown). See also: Help: Time
11 Tz: database time zone   Timezone in "tz" (Olson) format, eg. "America/Los_Angeles".
12 Type: Type of the airport. Value "airport" for air terminals, "station" for train stations, "port" for ferry terminals and "unknown" if not known. In airports.csv, only type=airport is included.
13 Source: Source of this data. "OurAirports" for data sourced from OurAirports, "Legacy" for old data not matched to OurAirports (mostly DAFIF), "User" for unverified user contributions. In airports.csv, only source=OurAirports is included.

*/

var fs = require('fs')
var baby = require('babyparse')
var _ = require('lodash')

var routes = baby.parse(fs.readFileSync(__dirname + '/data/routes.csv').toString(), { header: false }).data
var airports = baby.parse(fs.readFileSync(__dirname + '/data/airports.csv').toString(), { header: false }).data

// We find all the unique airport codes that exist in the routes database
// so we can get only the airports there is a airline traffic

var airportKeys = []

routes.forEach(route => {
    airportKeys.push(route[2]) // Source airport IATA code
    airportKeys.push(route[4]) // Destination airport IATA code
})

airportKeys = _.uniq(airportKeys)

// Loop over airports and filter out all the airports not present in the
// airport codes array

airports = airports
    .filter(airport => {
        return airport[6] // Lat
            && airport[7] // Lon
            && airportKeys.indexOf(airport[4]) !== -1 // Airport IATA code
    })
    .map(airport => {
        return {
            iata: airport[4],
            lat: airport[6],
            lon: airport[7]
        }
    })

console.log('<?php\n\nreturn [\n')

airports.forEach(airport => {
    console.log(`    [
        'iata' => '${airport.iata}',
        'lat' => '${airport.lat}',
        'lon' => '${airport.lon}',
    ],`);
})

console.log('\n];\n')