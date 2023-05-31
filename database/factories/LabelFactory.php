<?php

namespace Database\Factories;

use App\Models\LabelModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class LabelFactory extends Factory
{

    protected $model = LabelModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'     => function () {
                return UserModel::factory()->create()->id;
            },
            'label_title' => $this->faker->text(50),
            'label_color' => $this->faker->colorName(),
        ];
    }


}
