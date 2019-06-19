<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
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


Route::get('/companies', 'CompanyController@apiGetAllCompanies');
Route::get('/companies/favorites', 'CompanyController@apiGetAllCompaniesAndFavoriteState');
Route::get('/users/favorites/companies', 'CompanyController@apiGetCurrentUserFavoriteCompanies');
Route::post('/users/favorites/companies/{company_id}', 'CompanyController@apiPostAddCompanyToCurrentUserFavorite');
Route::delete('/users/favorites/companies/{company_id}', 'CompanyController@apiDeleteRemoveCompanyFromCurrentUserFavorite');


