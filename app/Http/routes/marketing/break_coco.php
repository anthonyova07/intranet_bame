<?php

Route::resource('break_coco', 'Marketing\Coco\CocoController', ['only' => [
    'index', 'store'
]]);

Route::group(['prefix' => 'break_coco'], function () {
    Route::resource('ideas', 'Marketing\Coco\IdeaController', ['only' => [
        'index', 'show'
    ]]);
});
