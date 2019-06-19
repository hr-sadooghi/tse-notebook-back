<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/companies/import', function () {
    $json = json_decode(file_get_contents('https://core.tadbirrlc.com//StocksHandler.ashx?{%22Type%22:%22ALL21%22,%22Lan%22:%22Fa%22}&jsoncallback='), true);

    foreach ($json as $item) {

        $namad = new App\Company();
        $namad->symbol = $item['sf'];
        $namad->name = $item['cn'];
        $namad->id_code = $item['ic'];
        $namad->company_12_digit_name = $item['nc'];
        $namad->category_id = $item['sc'];
        $namad->save();
    }

    return $json;
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
