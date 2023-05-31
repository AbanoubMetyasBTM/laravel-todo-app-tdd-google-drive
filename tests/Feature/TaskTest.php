<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->authUser();
    }

    private function createTodoListForUser()
    {
        return $this->createTodoList([
            "user_id" => $this->user->id
        ]);
    }

    private function createLabelForUser()
    {
        return $this->createLabel([
            "user_id" => $this->user->id
        ]);
    }

    public function test_fetch_all_tasks_of_a_todo_list()
    {
        $list = $this->createTodoListForUser();

        $task = $this->createTask([
            'list_id' => $list->list_id
        ]);

        $response = $this->getJson(route('task.index', $list->list_id))->assertOk()->json();

        $this->assertEquals(1, count($response["data"]["tasks"]));
        $this->assertEquals($task->task_title, $response["data"]["tasks"][0]['task_title']);
        $this->assertEquals($response["data"]["tasks"][0]['list_id'], $list->list_id);
    }

    public function test_store_a_task_for_a_todo_list()
    {
        $list  = $this->createTodoListForUser();
        $task  = TaskModel::factory()->make();
        $label = $this->createLabelForUser();

        $this->postJson(route('task.store', $list->list_id), [
            'task_title' => $task->task_title,
            'label_id'   => $label->label_id
        ])->
        assertCreated();

        $this->assertDatabaseHas('tasks', [
            'task_title' => $task->task_title,
            'list_id'    => $list->list_id,
            'label_id'   => $label->label_id
        ]);
    }

    public function test_store_a_task_for_a_todo_list_without_a_label()
    {

        $list = $this->createTodoListForUser();
        $task = TaskModel::factory()->make();

        $this->
        postJson(route('task.store', $list->list_id), [
            'task_title' => $task->task_title
        ])->
        assertCreated();

        $this->assertDatabaseHas('tasks', [
            'task_title' => $task->task_title,
            'list_id'    => $list->list_id,
            'label_id'   => null
        ]);
    }

    public function test_delete_a_task_from_database()
    {
        $list = $this->createTodoListForUser();
        $task = $this->createTask([
            "list_id" => $list->list_id
        ]);

        $this->deleteJson(route('task.destroy', [$list->list_id, $task->task_id]))->assertNoContent();

        $this->assertDatabaseMissing('tasks', ['task_title' => $task->task_title]);
    }

    public function test_update_a_task_of_a_todo_list()
    {
        $list = $this->createTodoListForUser();
        $task = $this->createTask([
            "list_id" => $list->list_id
        ]);

        $this->
        putJson(route('task.update', [$list->list_id, $task->task_id]), [
            'task_title' => 'updated title'
        ])->
        assertOk();

        $this->assertDatabaseHas('tasks', ['task_title' => 'updated title']);
    }

    public function test_a_task_status_can_be_changed()
    {
        $list = $this->createTodoListForUser();
        $task = $this->createTask([
            "list_id" => $list->list_id
        ]);

        $this->
        putJson(route('task.update', [$list->list_id, $task->task_id]), [
            'task_status' => TaskModel::$statues["done"]
        ])->
        assertOk();

        $this->assertDatabaseHas('tasks', ['task_status' => TaskModel::$statues["done"]]);
    }
}
