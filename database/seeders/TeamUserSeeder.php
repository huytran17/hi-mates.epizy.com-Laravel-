<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TeamUser;

class TeamUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TeamUser::factory()->count(30)->create();
    }
}
