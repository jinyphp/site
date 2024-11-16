<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Site Root Index
 */
Route::middleware(['web'])->group(function(){
    ## index
    Route::get('/', [
        \Jiny\Site\Http\Controllers\Site\SiteHome::class,
        "index"]);
});


Route::middleware(['web'])->group(function(){
    ## 동의서
    Route::get('/terms/{any?}', [
        \Jiny\Site\Http\Controllers\Site\SiteTermsUse::class,
        "index"])->where('any', '.*');

});

Route::middleware(['web'])->group(function(){
    ## about 기능
    // Route::get('/about', [
    //     \Jiny\Site\Http\Controllers\Site\SiteAbout::class,
    //     "index"]);
});
