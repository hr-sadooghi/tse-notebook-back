<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $companies = DB::table('favorites')->select('company_id')->pluck('company_id');
        foreach ($companies as $company_id) {
            DB::table('events')->insert([
                'company_id' => $company_id,
                'user_id' => 1,
                'description' => (new Faker\Provider\fa_IR\Text(new Faker\Generator()))->realText(),
                'type'=>'text',
                'date'=>'2019-3-7',
                'detail_type'=>null,
                'detail_id'=>null
            ]);
        }
    }
}
