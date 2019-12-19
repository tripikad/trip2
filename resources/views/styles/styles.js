const spacer = '12px'

const colors = {
  blue: 'hsl(205, 82%, 57%)',
  'blue-hover': 'hsl(205, 82%, 47%)',

  'cyan-lighter': 'hsl(189, 46%, 92%)',
  'cyan-light': 'hsl(190, 73%, 80%)',

  cyan: 'hsl(190, 73%, 59%)',
  'cyan-hover': 'hsl(190, 73%, 49%)',
  'cyan-dark': 'hsl(193, 100%, 34%)',

  'green-dark': '#288f18',
  green: 'hsl(105, 52%, 58%)',
  'green-hover': 'hsl(105, 52%, 48%)',

  'orange-light': 'hsl(29, 100%, 82%)',
  orange: 'hsl(29, 100%, 62%)',
  'orange-hover': 'hsl(29, 100%, 52%)',
  'orange-dark': 'hsl(29, 100%, 48%)',

  purple: 'hsl(245, 51%, 68%)',
  'purple-dark': 'hsl(245, 49%, 52%)',

  red: 'hsl(0, 79%, 66%)',
  'red-hover': 'hsl(0, 79%, 56%)',

  'red-dark': 'hsl(0, 56%, 54%)',
  'red-darker': 'hsl(0, 53%, 45%)',

  'yellow-light': 'hsl(45, 100%, 68%)',
  yellow: 'hsl(45, 100%, 48%)',
  'yellow-hover': 'hsl(45, 100%, 38%)',

  'yellow-dark': 'hsl(35, 100%, 32%)',

  'pink-light': 'hsl(7, 100%, 96%)',
  pink: 'hsl(7, 72%, 89%)',
  'pink-dark': 'hsl(7, 15%, 57%)',

  white: 'hsl(0, 0%, 100%)',
  'white-hover': 'hsla(0, 0%, 100%, 0.9)',

  'gray-lighter': 'hsl(204, 6%, 95%)',
  'gray-lighter-hover': 'hsl(204, 6%, 75%)',

  'gray-light': 'hsl(204, 6%, 83%)',
  'gray-light-hover': 'hsl(204, 6%, 73%)',

  gray: 'hsl(204, 6%, 45%)',
  'gray-hover': 'hsl(204, 6%, 35%)',

  'gray-dark': 'hsl(204, 6%, 35%)',
  'gray-dark-hover': 'hsl(204, 6%, 20%)',

  'gray-darker': 'hsl(204, 6%, 25%)',
  'gray-darker-hover': 'hsl(204, 6%, 15%)',

  black: 'hsl(0,0%,0%)'
}

const socialColors = {
  facebook: '#3b5998',
  twitter: '#00aced',
  google: '#dd4b39'
}

const fontFamilies = {
  'font-family': 'Sailec',
  'font-family-code': 'Cousine'
}

const fontSizes = {
  'font-size-xs': '13px',
  'font-size-sm': '14px',
  'font-size-md': '16px',
  'font-size-lg': '19px',
  'font-size-xl': '21px',
  'font-size-xxl': '30px',
  'font-size-xxxl': '48px',
  'font-size-xxxxl': '64px'
}

const fontWeights = {
  'font-weight-normal': 'normal',
  'font-weight-semibold': 600,
  'font-weight-bold': 'bold'
}

const lineHeights = {
  'line-height-xs': '100%',
  'line-height-sm': '120%',
  'line-height-md': '135%',
  'line-height-lg': '145%',
  'line-height-xl': '200%',
  'line-height-xxl': '220%'
}

const fonts = {
  /* prettier-ignore */
  'font-text-xs': `${fontWeights['font-weight-normal']} ${fontSizes['font-size-xs']} / ${lineHeights['line-height-lg']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-text-sm': `${fontWeights['font-weight-normal']} ${fontSizes['font-size-sm']} / ${lineHeights['line-height-lg']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-text-md': `${fontWeights['font-weight-normal']} ${fontSizes['font-size-md']} / ${lineHeights['line-height-lg']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-text-lg': `${fontWeights['font-weight-normal']} ${fontSizes['font-size-lg']} / ${lineHeights['line-height-lg']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-heading-xs': `${fontWeights['font-weight-semibold']} ${fontSizes['font-size-sm']} / ${lineHeights['line-height-lg']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-heading-sm': `${fontWeights['font-weight-semibold']} ${fontSizes['font-size-md']} / ${lineHeights['line-height-lg']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-heading-md': `${fontWeights['font-weight-semibold']} ${fontSizes['font-size-lg']} / ${lineHeights['line-height-lg']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-heading-lg': `${fontWeights['font-weight-semibold']} ${fontSizes['font-size-xl']} / ${lineHeights['line-height-md']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-heading-xl': `${fontWeights['font-weight-bold']} ${fontSizes['font-size-xxl']} / ${lineHeights['line-height-sm']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-heading-xxl': `${fontWeights['font-weight-bold']} ${fontSizes['font-size-xxxl']} / ${lineHeights['line-height-xs']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-heading-xxxl': `${fontWeights['font-weight-bold']} ${fontSizes['font-size-xxxxl']} / ${lineHeights['line-height-xs']} ${fontFamilies['font-family']}, sans-serif`,
  /* prettier-ignore */
  'font-code-sm': `${fontWeights['font-weight-normal']} ${fontSizes['font-size-sm']} / ${lineHeights['line-height-md']} ${fontFamilies['font-family-code']}, monospace`,
  /* prettier-ignore */
  'font-code-md': `${fontWeights['font-weight-normal']} ${fontSizes['font-size-md']} /  ${lineHeights['line-height-md']} ${fontFamilies['font-family-code']}, monospace`
}

const paddings = {
  'padding-xxxs': `calc(${spacer} / 4)`,
  'padding-xxs': `calc(${spacer} / 3)`,
  'padding-xs': `calc(${spacer} / 2)`,
  'padding-sm': `${spacer}`,
  'padding-md': `calc(${spacer} * 2)`,
  'padding-lg': `calc(${spacer} * 3)`,
  'padding-xl': `calc(${spacer} * 5)`,
  'padding-xxl': `calc(${spacer} * 7)`,
  'padding-xxxl': `calc(${spacer} * 16)`
}

const fullPaddings = {
  'padding-top-xs': `${paddings['padding-xs']} 0 0 0`,
  'padding-top-sm': `${paddings['padding-sm']} 0 0 0`,
  'padding-top-md': `${paddings['padding-md']} 0 0 0`,
  'padding-top-lg': `${paddings['padding-lg']} 0 0 0`,
  'padding-top-xl': `${paddings['padding-xl']} 0 0 0`,
  'padding-right-xs': `${paddings['padding-xs']} 0 0`,
  'padding-right-sm': `${paddings['padding-sm']} 0 0`,
  'padding-right-md': `${paddings['padding-md']} 0 0`,
  'padding-right-lg': `${paddings['padding-lg']} 0 0`,
  'padding-right-xl': `${paddings['padding-xl']} 0 0`,
  'padding-bottom-xs': `0 0 ${paddings['padding-xs']} 0`,
  'padding-bottom-sm': `0 0 ${paddings['padding-sm']} 0`,
  'padding-bottom-md': `0 0 ${paddings['padding-md']} 0`,
  'padding-bottom-lg': `0 0 ${paddings['padding-lg']} 0`,
  'padding-bottom-xl': `0 0 ${paddings['padding-xl']} 0`,
  'padding-left-xs': `0 0 0 ${paddings['padding-xs']}`,
  'padding-left-sm': `0 0 0 ${paddings['padding-sm']}`,
  'padding-left-md': `0 0 0 ${paddings['padding-md']}`,
  'padding-left-lg': `0 0 0 ${paddings['padding-lg']}`,
  'padding-left-xl': `0 0 0 ${paddings['padding-xl']}`,
  'padding-leftright-xs': `0 ${paddings['padding-xs']}`,
  'padding-leftright-sm': `0 ${paddings['padding-sm']}`,
  'padding-leftright-md': `0 ${paddings['padding-md']}`,
  'padding-leftright-lg': `0 ${paddings['padding-lg']}`,
  'padding-leftright-xl': `0 ${paddings['padding-xl']}`,
  'padding-topbottom-xs': `${paddings['padding-xs']} 0`,
  'padding-topbottom-sm': `${paddings['padding-sm']} 0`,
  'padding-topbottom-md': `${paddings['padding-md']} 0`,
  'padding-topbottom-lg': `${paddings['padding-lg']} 0`,
  'padding-topbottom-xl': `${paddings['padding-xl']} 0`
}

const margins = {
  'margin-xxxs': `calc(${spacer} / 4)`,
  'margin-xxs': `calc(${spacer} / 3)`,
  'margin-xs': `calc(${spacer} / 2)`,
  'margin-sm': `${spacer}`,
  'margin-md': `calc(${spacer} * 2)`,
  'margin-lg': `calc(${spacer} * 3)`,
  'margin-xl': `calc(${spacer} * 5)`,
  'margin-xxl': `calc(${spacer} * 7)`,
  'margin-xxxl': `calc(${spacer} * 16)`
}

const fullMargins = {
  'margin-top-xs': `${margins['margin-xs']} 0 0 0`,
  'margin-top-sm': `${margins['margin-sm']} 0 0 0`,
  'margin-top-md': `${margins['margin-md']} 0 0 0`,
  'margin-top-lg': `${margins['margin-lg']} 0 0 0`,
  'margin-top-xl': `${margins['margin-xl']} 0 0 0`,
  'margin-right-xs': `${margins['margin-xs']} 0 0`,
  'margin-right-sm': `${margins['margin-sm']} 0 0`,
  'margin-right-md': `${margins['margin-md']} 0 0`,
  'margin-right-lg': `${margins['margin-lg']} 0 0`,
  'margin-right-xl': `${margins['margin-xl']} 0 0`,
  'margin-bottom-xs': `0 0 ${margins['margin-xs']} 0`,
  'margin-bottom-sm': `0 0 ${margins['margin-sm']} 0`,
  'margin-bottom-md': `0 0 ${margins['margin-md']} 0`,
  'margin-bottom-lg': `0 0 ${margins['margin-lg']} 0`,
  'margin-bottom-xl': `0 0 ${margins['margin-xl']} 0`,
  'margin-left-xs': `0 0 0 ${margins['margin-xs']}`,
  'margin-left-sm': `0 0 0 ${margins['margin-sm']}`,
  'margin-left-md': `0 0 0 ${margins['margin-md']}`,
  'margin-left-lg': `0 0 0 ${margins['margin-lg']}`,
  'margin-left-xl': `0 0 0 ${margins['margin-xl']}`,
  'margin-leftright-xs': `0 ${margins['margin-xs']}`,
  'margin-leftright-sm': `0 ${margins['margin-sm']}`,
  'margin-leftright-md': `0 ${margins['margin-md']}`,
  'margin-leftright-lg': `0 ${margins['margin-lg']}`,
  'margin-leftright-xl': `0 ${margins['margin-xl']}`,
  'margin-topbottom-xs': `${margins['margin-xs']} 0`,
  'margin-topbottom-sm': `${margins['margin-sm']} 0`,
  'margin-topbottom-md': `${margins['margin-md']} 0`,
  'margin-topbottom-lg': `${margins['margin-lg']} 0`,
  'margin-topbottom-xl': `${margins['margin-xl']} 0`
}

const widths = {
  'width-xxs': `calc(${spacer} / 2)`,
  'width-xs': `calc(${spacer})`,
  'width-sm': `calc(${spacer} * 2)`,
  'width-md': `calc(${spacer} * 4)`,
  'width-lg': `calc(${spacer} * 6)`,
  'width-xl': `calc(${spacer} * 12)`,
  'width-xxl': `calc(${spacer} * 15)`,
  'width-xxxl': `calc(${spacer} * 24)`,
  'width-xxxxl': `calc(${spacer} * 32)`
}

const heights = {
  'height-xxs': `calc(${spacer} / 2)`,
  'height-xs': `calc(${spacer})`,
  'height-sm': `calc(${spacer} * 2)`,
  'height-md': `calc(${spacer} * 4)`,
  'height-lg': `calc(${spacer} * 6)`,
  'height-xl': `calc(${spacer} * 12)`,
  'height-xxl': `calc(${spacer} * 15)`,
  'height-xxxl': `calc(${spacer} * 24)`,
  'height-xxxxl': `calc(${spacer} * 32)`
}

const borders = {
  'border-gray-sm': `1px solid ${colors['gray-light']}`,
  'border-gray-md': `2px solid  ${colors['gray-light']}`,
  'border-gray-lg': `4px solid ${colors['gray-light']}`,
  'border-green-md': `2px solid  ${colors['green']}`,
  'border-white-md': `2px solid  ${colors['white']}`,
  'border-dotted-gray-md': `2px dotted ${colors['gray-light']}`
}

const borderRadiuses = {
  'border-radius-md': `3px`,
  'border-radius-lg': `${spacer}`,
  'border-radius-xl': `calc(${spacer} * 1.5)`,
  'border-radius-xxl': `calc(${spacer} * 100)`
}

const textShadows = {
  'text-shadow-md': `0 1px 0 rgba(0, 0, 0, 0.3)`
}

const boxShadows = {
  'box-shadow-left': `0 0 ${paddings['padding-md']} 0 rgba(0, 0, 0, 0.1)`,
  'box-shadow-bottom': `0 0 ${paddings['padding-md']} 0 rgba(0, 0, 0, 0.1)`
}

const mediaWidths = {
  'mobile-width': `22em`,
  'mobile-large-width': `32em`,
  'tablet-width': `48em` /* was 56em; */,
  'desktop-width': `62em`,
  'largedesktop-width': `74em`
}

const medias = {
  mobile: `media (max-width: ${mediaWidths['mobile-width']})`,
  tablet: `media (max-width: ${mediaWidths['tablet-width']})`,
  desktop: `media (max-width: ${mediaWidths['desktop-width']})`,
  largedesktop: `media (max-width:${mediaWidths['largedesktop-width']})`
}

const legacyMedias = {
  ie: `media (-ms-high-contrast: none), (-ms-high-contrast: active)`
}

const opacitites = {
  'opacity-xxs': `0.05`,
  'opacity-xs': `0.1`,
  'opacity-sm': `0.3`,
  'opacity-md': `0.5`,
  'opacity-lg': `0.7`,
  'opacity-xl': `0.9`
}

const transitions = {
  'transition-md': 'all 0.2s'
}

module.exports = {
  spacer,
  ...colors,
  ...socialColors,
  ...fontFamilies,
  ...fontSizes,
  ...fontWeights,
  ...lineHeights,
  ...fonts,
  ...paddings,
  ...fullPaddings,
  ...margins,
  ...fullMargins,
  ...widths,
  ...heights,
  ...borders,
  ...borderRadiuses,
  ...textShadows,
  ...boxShadows,
  ...mediaWidths,
  ...medias,
  ...legacyMedias,
  ...opacitites,
  ...transitions
}
