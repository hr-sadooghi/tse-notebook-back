<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json = json_decode(file_get_contents('https://core.tadbirrlc.com//StocksHandler.ashx?{%22Type%22:%22ALL21%22,%22Lan%22:%22Fa%22}&jsoncallback='), true);

        foreach ($json as $item) {
            DB::table('companies')
                ->insert([
                    'symbol' => $item['sf'],
                    'name' => $item['cn'],
                    'id_code' => $item['ic'],
                    'company_12_digit_name' => $item['nc'],
                    'category_id' => $item['sc']
                ]);
        }
    }
}
