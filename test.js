const vars = require('./resources/views/styles/stylevars.js')

const stylevars = `<?php

return [
${Object.entries(vars)
    .map(
        ([key, value]) =>
            `      '${key}' => '${
                typeof value == 'string' ? value.replace(/'/g, '"') : value
            }'`
    )
    .join(',\n')}
];
`

console.log(stylevars)
