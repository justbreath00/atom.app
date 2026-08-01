<?php

return [

    'secret' => env('JWT_SECRET'),

    'algorithm' => env('JWT_ALGORITHM', 'HS256'),

];