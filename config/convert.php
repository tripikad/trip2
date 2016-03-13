<?php

return [

    'take'              => env('CONVERT_TAKE', 10),
    'skip'              => env('CONVERT_SKIP', 10),
    'copyFiles'         => env('CONVERT_FILES', false),
    'scrambleMessages'  => env('CONVERT_SCRAMBLE', true),
    'fileHash'          => env('CONVERT_FILEHASH', false),
    'overwriteFiles'    => env('CONVERT_OVERWRITE', false),
    'demoAccounts'      => env('CONVERT_DEMOACCOUNTS', false),

];
