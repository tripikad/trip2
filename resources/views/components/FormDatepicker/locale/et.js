const locale = {
    lang: {
        name: 'et',
        weekdays: 'pühapäev_esmaspäev_teisipäev_kolmapäev_neljapäev_reede_laupäev'.split('_'), // Note weekdays are not capitalized in Estonian
        weekdaysShort: 'P_E_T_K_N_R_L'.split('_'), // There is no short form of weekdays in Estonian except this 1 letter format so it is used for both 'weekdaysShort' and 'weekdaysMin'
        weekdaysMin: 'P_E_T_K_N_R_L'.split('_'),
        months: 'jaanuar_veebruar_märts_aprill_mai_juuni_juuli_august_september_oktoober_november_detsember'.split('_'), // Note month names are not capitalized in Estonian
        monthsShort: 'jaan_veebr_märts_apr_mai_juuni_juuli_aug_sept_okt_nov_dets'.split('_'),
        weekStart: 1,
        formats: {
            LT: 'H:mm',
            LTS: 'H:mm:ss',
            L: 'DD.MM.YYYY',
            LL: 'D. MMMM YYYY',
            LLL: 'D. MMMM YYYY H:mm',
            LLLL: 'dddd, D. MMMM YYYY H:mm'
        },
        ordinal: n => `${n}º`,
        buttonValidate: 'Ok',
        buttonCancel: 'Tühista',
        rangeHeaderText: '%d kuni %d'
    }
}

export default locale
