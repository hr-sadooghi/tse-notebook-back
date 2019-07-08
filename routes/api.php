<?php
//Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL3Rlc3Qtand0XC9wdWJsaWNcL2FwaVwvbG9naW4iLCJpYXQiOjE1NjI2MTQ3NjYsImV4cCI6MTU2MjYxODM2NiwibmJmIjoxNTYyNjE0NzY2LCJqdGkiOiI0OGZTMVRPTExtRDVlT0d0Iiwic3ViIjoxLCJwcnYiOiI4N2UwYWYxZWY5ZmQxNTgxMmZkZWM5NzE1M2ExNGUwYjA0NzU0NmFhIn0.Os1scsSTP8WLNNsaOGpn5CVFnLPJKNK0khgyh8VIwIQ
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| APIDoc Routes
|--------------------------------------------------------------------------
|
| Here is where you can register APIDoc routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your APIDoc!
|
*/

Route::post('login', 'Api\LoginController@login');

/**
 * @OA\Info(title="TSE Notebook APIDoc", description="This REST APIDoc provide backend for TSE Notebook Web Application.", version="0.1")
 * @OA\Server(url="http://127.0.0.1/tse-notebook-back/public/api")
 * @OA\Server(url=API_HOST)
 * @OA\Server(url="http://tseyar.ir/api/")
 */
//Route::middleware('jwt.auth')->get('/user', function () {
//    return [
//        'a'=>'0jkhjhk'
//    ];
//});
Route::middleware('jwt.auth')->get('/user', function () {
    return ['user_id'=>auth()->user()];
    $user_id = auth()->id();
    /** @var \App\User $user */
//    $user = App\User::find($user_id);
    return response($user, 200);
});

Route::middleware('jwt.auth')->prefix('companies')->group(function () {
    Route::get('', 'Api\CompanyController@getAll');
    Route::get('{company}', 'Api\CompanyController@getItem');
    Route::get('favorites', 'Api\CompanyController@getAllCompaniesAndFavoriteState');
    Route::get('{company}/events', 'Api\CompanyController@getEventList');
});

Route::middleware('jwt.auth')->prefix('events')->group(function () {
    Route::post('', 'Api\EventController@post');
    Route::put('{event}', 'Api\EventController@put');
    Route::post('link', 'Api\EventController@postLink');
    Route::post('trade', 'Api\EventController@postTrade');
});

Route::middleware('jwt.auth')->prefix('users')->group(function () {
    Route::get('favorites/companies', 'UserController@apiGetCurrentUserFavoriteCompanies');
    Route::post('favorites/companies/{company_id}', 'UserController@apiPostAddCompanyToCurrentUserFavorite');
    Route::delete('favorites/companies/{company_id}', 'UserController@apiDeleteRemoveCompanyFromCurrentUserFavorite');
});

Route::middleware('jwt.auth')->get('/links/meta-tag-extractor', 'LinkController@apiGetMetaTagExtractor');
Route::middleware('jwt.auth')->post('/files/{type?}', 'FileController@apiPost');

