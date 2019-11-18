export const intersection = (arr1, arr2) => arr1.filter(n => arr2.includes(n))

export const chunk = (arr, length) =>
    Array.from({
        length: Math.ceil(arr.length / length)
    }).map((_, n) => arr.slice(n * length, n * length + length))

export const unique = arr => [...new Set(arr)]

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

export const snapToGrid = (value, gridsize) => {
    return value % gridsize < gridsize / 2
        ? value - (value % gridsize)
        : value + gridsize - (value % gridsize)
}
