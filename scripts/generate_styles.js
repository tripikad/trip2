const { writeFileSync } = require('fs')
const { join } = require('path')

const styles = require('../resources/views/styles/styles')

const stylesOutput = `<?php

return [
${Object.entries(styles)
    .map(([key, value]) => `      '${key}' => '${String(value).replace(/'/g, '"')}'`)
    .join(',\n')}
];
`
writeFileSync(join(__dirname, '../config/styles.php'), stylesOutput)
