<?php

namespace Database\Seeders;

use App\Models\ShariyahCompany;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShariyahCompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Shari’a Supervisory Board', 'code' => 'SSB'],
            ['name' => 'Internal Shari’a Supervisory Committee', 'code' => 'ISSC'],
            ['name' => 'Shari’a Committee', 'code' => 'SC'],
            ['name' => 'Shari’a Review Committee', 'code' => 'SRC'],
            ['name' => 'Shari’a Advisor', 'code' => 'SA']
        ];

        foreach ($data as $datum) {
            ShariyahCompany::create([
                'name' => $datum['name'],
                'code' => $datum['code']
            ]);
        }
    }
}
