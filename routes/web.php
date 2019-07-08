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


Route::get('test-rest', function(){


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://localhost/tse-notebook-back/public/api/auth/login",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER=>false,
        CURLOPT_SSL_VERIFYHOST=>false,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
        echo $response;
    }
    dd('end');
});

Route::get('/api-doc', function () {
    return view('api-doc');
});

Route::get('/files/{file}', 'FileController@webGet')->name('get_file');
Route::get('/files/{file}/thumb', 'FileController@webGetThumb')->name('get_file_thumb');

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
