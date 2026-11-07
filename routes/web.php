<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/vocabularies', function(){
    return view('vocab.index');
});

Route::get('/vocabularies/create', function(){
    return view('vocab.create');
});

Route::get('/vocabularies/{id}/edit', function($id){
    return view('vocab.edit', ['id'=>$id]);
});
