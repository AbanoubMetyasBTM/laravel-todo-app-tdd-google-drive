<?php

namespace Database\Factories;

use App\Models\TodoListModel;
use App\Models\UserModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TodoListFactory extends Factory
{

    protected $model = TodoListModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "list_title" => $this->faker->text(50),
            "user_id" => function(){
                return UserModel::factory()->create()->id;
            }
        ];
    }


}
