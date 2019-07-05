<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FavoritesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $totalCompanies = DB::table('companies')->count();
        for ($i=0; $i < rand(8, 18); $i++) {
            $company_ids = [];
            do {
                $company_id = rand(1, $totalCompanies);
            } while (in_array($company_id, $company_ids));
            $company_ids[] = $company_id;
            DB::table('favorites')->insert([
                'company_id' => $company_id,
                'user_id' => 1
            ]);
        }
    }
}
