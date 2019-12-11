import { format, endOfWeek, endOfMonth, addMonths, getMonth, subMonths, addSeconds } from 'date-fns'
import { et } from 'date-fns/locale'

export const intersection = (arr1, arr2) => arr1.filter(n => arr2.includes(n))

export const chunk = (arr, length) =>
    Array.from({
        length: Math.ceil(arr.length / length)
    }).map((_, n) => arr.slice(n * length, n * length + length))

export const unique = arr => [...new Set(arr)]

// https://stackoverflow.com/a/39903069

export const uniqueFilter = (arr, getter = d => d) =>
    arr.filter((set => f => !set.has(getter(f)) && set.add(getter(f)))(new Set()))

export const toObject = arr =>
    arr.reduce((acc, el) => {
        acc[el[0]] = el[1]
        return acc
    }, {})

export const parseSheets = data => {
    return data.feed.entry.map(entry => {
        return Object.keys(entry)
            .map(field => {
                if (field.startsWith('gsx$')) {
                    return [field.split('$')[1], entry[field].$t]
                }
            })
            .filter(field => field)
            .reduce((field, item) => {
                field[item[0]] = item[1]
                return field
            }, {})
    })
}

export const random = (from, to) => {
    return from + Math.random() * (to - from)
}

export const snap = (value, gridsize = 1) => {
    return value % gridsize < gridsize / 2 ? value - (value % gridsize) : value + gridsize - (value % gridsize)
}

export const debounce = (fn, time) => {
    let timeout
    return function() {
        const functionCall = () => fn.apply(this, arguments)
        clearTimeout(timeout)
        timeout = setTimeout(functionCall, time)
    }
}

export const getCssVariable = (value, el = document.body) => getComputedStyle(el).getPropertyValue(value)

export const setCssVariable = (key, value, el = document.body.style) => el.setProperty(key, value)

export const slug = text => {
    text = text
        .toString()
        .toLowerCase()
        .trim()

    const sets = [
        { to: 'a', from: '[ÀÁÂÃÄÅÆĀĂĄẠẢẤẦẨẪẬẮẰẲẴẶ]' },
        { to: 'c', from: '[ÇĆĈČ]' },
        { to: 'd', from: '[ÐĎĐÞ]' },
        { to: 'e', from: '[ÈÉÊËĒĔĖĘĚẸẺẼẾỀỂỄỆ]' },
        { to: 'g', from: '[ĜĞĢǴ]' },
        { to: 'h', from: '[ĤḦ]' },
        { to: 'i', from: '[ÌÍÎÏĨĪĮİỈỊ]' },
        { to: 'j', from: '[Ĵ]' },
        { to: 'ij', from: '[Ĳ]' },
        { to: 'k', from: '[Ķ]' },
        { to: 'l', from: '[ĹĻĽŁ]' },
        { to: 'm', from: '[Ḿ]' },
        { to: 'n', from: '[ÑŃŅŇ]' },
        { to: 'o', from: '[ÒÓÔÕÖØŌŎŐỌỎỐỒỔỖỘỚỜỞỠỢǪǬƠ]' },
        { to: 'oe', from: '[Œ]' },
        { to: 'p', from: '[ṕ]' },
        { to: 'r', from: '[ŔŖŘ]' },
        { to: 's', from: '[ßŚŜŞŠ]' },
        { to: 't', from: '[ŢŤ]' },
        { to: 'u', from: '[ÙÚÛÜŨŪŬŮŰŲỤỦỨỪỬỮỰƯ]' },
        { to: 'w', from: '[ẂŴẀẄ]' },
        { to: 'x', from: '[ẍ]' },
        { to: 'y', from: '[ÝŶŸỲỴỶỸ]' },
        { to: 'z', from: '[ŹŻŽ]' },
        { to: '-', from: "[·/_,:;']" }
    ]

    sets.forEach(set => {
        text = text.replace(new RegExp(set.from, 'gi'), set.to)
    })

    return text
        .toString()
        .toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/&/g, '-and-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\--+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '')
}

export const formatCurrency = value => {
    return `${value}€`
}

export const titleCase = string =>
    string
        .split(' ')
        .map(([h, ...t]) => h.toUpperCase() + t.join('').toLowerCase())
        .join(' ')

export const localizedFormat = (date, dateFormat) => format(date, dateFormat, { locale: et })

export const localizedEndOfWeek = date => endOfWeek(date, { locale: et })

// Seasons

const seasons = [[12, 1, 2], [3, 4, 5], [6, 7, 8], [9, 10, 11]]

export const seasonNames = ['Talv', 'Kevad', 'Suvi', 'Sügis']

export const getSeason = date => {
    // getMonths returns 0 as Jan, 1 as Feb
    // so we make it more human-readable
    const month = getMonth(date) + 1
    // Find out to which subarray the month number belongs
    return seasons.findIndex(season => season.includes(month))
}

export const getMonthsToSeasonEnd = date => {
    const season = getSeason(date)
    return 2 - seasons[season].findIndex(month => month == getMonth(date) + 1)
}

export const seasonRange = (date = new Date(), length = 4) =>
    Array.from({ length })
        .map((_, i) => i * 3)
        .map(season => {
            const endDate = endOfMonth(addMonths(addMonths(date, getMonthsToSeasonEnd(date)), season))
            const startDate = addSeconds(subMonths(endDate, 3), 1)
            return [startDate, endDate]
        })

export const formatSeasonRange = range =>
    range.map(([_, endDate]) => {
        return `${seasonNames[getSeason(endDate)]} ${format(endDate, 'yyyy')}`
    })
