<?php

Route::resource('gallery', 'Marketing\Gallery\GalleryController');

Route::post('gallery/upload/{gallery}', 'Marketing\Gallery\GalleryController@upload')->name('marketing.gallery.upload');
Route::delete('gallery/delete_image/{gallery}/{image}', 'Marketing\Gallery\GalleryController@delete_image')->name('marketing.gallery.delete_image');
