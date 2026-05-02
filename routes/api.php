<?php

Route::get('/', function () {
    return "API ROOT OK";
});

Route::get('/test', function () {
    return response()->json([
        'message' => 'API funcionando desde Laravel'
    ]);
});