import { parseISO, isBefore, isAfter } from 'date-fns'

import { seasonRange } from '../../utils/utils'

const seasons = seasonRange(new Date())

export const filters = [
    {
        key: 'company',
        defaultTitle: 'Kõik reisifirmad',
        defaultState: 0,
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
    },
    {
        key: 'date',
        getId: null,
        getTitle: null,
        compare: (o, filterState) => {
            if (filterState == 0) {
                return true
            }
            const [seasonStartDate, seasonEndDate] = seasons[filterState - 1]
            const startAt = parseISO(o.start_at)
            const endAt = parseISO(o.end_at)
            return isAfter(startAt, seasonStartDate) && isBefore(endAt, seasonEndDate)
        }
    }
]
