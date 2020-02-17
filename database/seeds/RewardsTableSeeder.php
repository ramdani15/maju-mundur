<?php

use Illuminate\Database\Seeder;

use App\Rewards;

class RewardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rewards::insert([
            [
                'name' => 'Reward A',
                'poin' => 20
            ],
            [
                'name' => 'Reward B',
                'poin' => 40
            ]
        ]);
    }
}
