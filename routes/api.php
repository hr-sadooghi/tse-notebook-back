<?php

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


/**
 * @OA\Info(title="TSE Notebook APIDoc", description="This REST APIDoc provide backend for TSE Notebook Web Application.", version="0.1")
 * @OA\Server(url="http://127.0.0.1/tse-notebook-back/public/api")
 * @OA\Server(url=API_HOST)
 * @OA\Server(url="http://tseyar.ir/api/")
 */
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/user', function () {
    $user_id = auth()->id();
    /** @var \App\User $user */
    $user = App\User::find($user_id);
    return response($user, 200);
});

Route::prefix('companies')->group(function () {
    Route::get('', 'CompanyController@apiGetAllCompanies');
//Route::get('/companies/{id}', 'CompanyController@apiGetCompaniesItem');
    Route::get('favorites', 'CompanyController@apiGetAllCompaniesAndFavoriteState');
    Route::get('{company}/events', 'CompanyController@apiGetEventList');
});

Route::prefix('events')->group(function () {
    Route::post('', 'EventController@apiPost');
    Route::post('link', 'EventController@apiPostLink');
    Route::post('trade', 'EventController@apiPostTrade');
});

Route::prefix('users')->group(function () {
    Route::get('favorites/companies', 'UserController@apiGetCurrentUserFavoriteCompanies');
    Route::post('favorites/companies/{company_id}', 'UserController@apiPostAddCompanyToCurrentUserFavorite');
    Route::delete('favorites/companies/{company_id}', 'UserController@apiDeleteRemoveCompanyFromCurrentUserFavorite');
});

Route::get('/links/meta-tag-extractor', 'LinkController@apiGetMetaTagExtractor');
Route::post('/files/{type?}', 'FileController@apiPost');

