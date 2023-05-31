<?php

namespace Database\Factories;

use App\Models\LabelModel;
use App\Models\TaskModel;
use App\Models\TodoListModel;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{

    protected $model = TaskModel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'list_id'     => function () {
                return TodoListModel::factory()->create()->list_id;
            },
            'task_title'  => $this->faker->text(50),
            'task_desc'   => $this->faker->sentence(10),
            'label_id'    => function () {
                return LabelModel::factory()->create()->label_id;
            },
            'task_status' => "not_started",

        ];
    }


}
