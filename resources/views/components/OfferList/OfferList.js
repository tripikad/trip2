export const filters = [
    {
        key: 'company',
        defaultTitle: 'Kõik reisifirmad',
        getId: o => o.user.id,
        getTitle: o => o.user.name,
        compare: (o, filterState) => o.user.id == filterState
    },
    {
        key: 'style',
        defaultTitle: 'Kõik reisistiilid',
        getId: o => o.style,
        getTitle: o => o.style_formatted,
        compare: (o, filterState) => o.style == filterState
    },
    {
        key: 'destination',
        defaultTitle: 'Kõik sihtkohad',
        getId: o => o.end_destinations[0].id,
        getTitle: o => o.end_destinations[0].name,
        compare: (o, filterState) => o.end_destinations[0].id == filterState
    },
    {
        key: 'minPrice',
        getId: o => o.price,
        getTitle: null,
        compare: (o, filterState) => parseFloat(o.price) >= filterState
    },
    {
        key: 'maxPrice',
        getId: o => o.price,
        getTitle: null,
        compare: (o, filterState) => parseFloat(o.price) <= filterState
    }
]
