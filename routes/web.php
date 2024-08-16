<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


## Site Root Index
Route::middleware(['web'])->group(function(){
    ## root
    Route::get('/', [
        \Jiny\Site\Http\Controllers\Site\SiteHome::class,
        "index"]);
});


Route::middleware(['web'])->group(function(){

    ## about 기능
    Route::get('/about', [
        \Jiny\Site\Http\Controllers\Site\SiteAbout::class,
        "index"]);

    ## contact 기능
    Route::get('/contact', [
            \Jiny\Site\Http\Controllers\Site\SitePartialsView::class,
            "index"]);

    ## help 기능
    Route::get('/help', [
        \Jiny\Site\Http\Controllers\Site\SitePartialsView::class,
        "index"]);
});
