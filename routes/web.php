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

Route::get('/namads/import', function () {
    $json = json_decode(file_get_contents('https://core.tadbirrlc.com//StocksHandler.ashx?{%22Type%22:%22ALL21%22,%22Lan%22:%22Fa%22}&jsoncallback='), true);

    foreach ($json as $item) {

        $namad = new App\Namad();
        $namad->symbol = $item['sf'];
        $namad->id_code = $item['ic'];
        $namad->company_12_digit_name = $item['nc'];
        $namad->company_category_id = $item['sc'];
        $namad->company_name = $item['cn'];
        $namad->save();
    }

    return $json;
});
