<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TipQueryEloquentController;
use App\Helpers\ExternalApiHelper;
use App\Helpers\Logger;

Route::get('/', function () {
//    $apiHelper = new ExternalApiHelper('Hello World!');
//    return $apiHelper->foo();

//    return app(ExternalApiHelper::class)->foo();

//    return ExternalApiHelper::bar();

//    $externalApi = ExternalApiHelper::setFoo('Hello Foo');
//    $externalApiAgain = ExternalApiHelper::setFoo('Hello Foo again!');
//    return sprintf('%s -|- %s', $externalApi->foo(), $externalApiAgain->foo());

//    $externalApi = ExternalApiHelper::setFoo('Hello Foo');
//    $externalApiAgain = ExternalApiHelper::setFoo('Hello Foo again!');
//    $externalApiAgain33 = ExternalApiHelper::setFoo('Hello Foo 33!');
//    return sprintf('%s -|- %s -|- %s', $externalApi->foo(), $externalApiAgain->foo(), $externalApiAgain33->foo());

    return Logger::log('My app is broken');

});

Route::prefix('query')->group(function() {
    Route::get('posts/{role_name?}', [TipQueryEloquentController::class, 'getPostByUserHasRole'])
        ->name('posts.role');
});
