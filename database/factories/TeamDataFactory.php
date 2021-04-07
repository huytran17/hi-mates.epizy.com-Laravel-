<?php

namespace Database\Factories;

use App\Models\TeamData;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamDataFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeamData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'team_id' => Team::factory(),
            'color' => $this->faker->hexcolor,
            'background' => $this->faker->imageUrl($width = 640, $height = 480),
        ];
    }
}
