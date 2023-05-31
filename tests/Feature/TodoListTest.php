<?php

namespace Tests\Feature;

use App\Models\TodoListModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodoListTest extends TestCase
{

    use RefreshDatabase;

    public $user;
    public $list;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = $this->authUser();
        $this->list = $this->createTodoList([
            "user_id" => $this->user->id
        ]);

    }

    public function test_get_all_user_todo_lists()
    {
        $res = $this->getJson(route("todo-list.index"));

        $this->assertEquals(1, count($res["data"]["lists"]));
        $this->assertEquals($this->list->list_title, $res["data"]["lists"][0]["list_title"]);
    }

    public function test_create_new_list()
    {

        $list = TodoListModel::factory()->make()->toArray();

        $res = $this->postJson(route("todo-list.store"), [
            "list_title" => $list["list_title"]
        ])
            ->assertCreated()->json();

        $this->assertEquals($res["data"]["list"]["list_title"], $list["list_title"]);
        $this->assertDatabaseHas("todo_lists", [
            "list_title" => $list["list_title"]
        ]);
    }

    public function test_create_new_list_check_validation()
    {

        $this->withExceptionHandling();

        $this->postJson(route("todo-list.store"), [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(["list_title"]);

    }

    public function test_update_list()
    {
        $res = $this->putJson(route("todo-list.update", $this->list->list_id), [
            "list_title" => "updated title"
        ])->assertOk();

        $this->assertDatabaseHas("todo_lists", [
            "list_id"    => $this->list->list_id,
            "list_title" => "updated title"
        ]);
    }

    public function test_update_list_check_validation()
    {

        $this->withExceptionHandling();

        $res = $this->putJson(route("todo-list.update", $this->list->list_id),[])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(["list_title"]);

    }

    public function test_show_list()
    {

        $res = $this->getJson(route("todo-list.show", $this->list->list_id))
            ->assertOk()
            ->json();

        $this->assertEquals($res["data"]["list"]["list_title"], $this->list->list_title);

    }

    public function test_delete_list()
    {

        $res = $this->deleteJson(route("todo-list.destroy", $this->list->list_id))
            ->assertNoContent();

        $this->assertDatabaseMissing("todo_lists", [
            "list_title" => $this->list->list_title
        ]);
    }


}
