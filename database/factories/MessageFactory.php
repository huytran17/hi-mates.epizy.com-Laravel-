<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'team_id' => Team::factory(),
            'parent_id' => $this->faker->numberBetween($min=0, $max=20),
            'content' => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
        ];
    }
}
