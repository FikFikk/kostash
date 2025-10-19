<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    \App\Http\Middleware\TrackVisitor::class,
];
