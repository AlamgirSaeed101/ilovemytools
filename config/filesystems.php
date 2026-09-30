<?php

/*
|--------------------------------------------------------------------------
| Filesystems
|--------------------------------------------------------------------------
| The site stores no files. Laravel's local disk would otherwise register
| signed /storage/{path} download and upload routes by default ("serve");
| they are switched off because nothing uses them.
*/

return [

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => false,
            'throw' => false,
            'report' => false,
        ],
    ],

];
