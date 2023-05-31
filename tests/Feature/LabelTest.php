<?php

namespace Tests\Feature;

use App\Models\LabelModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LabelTest extends TestCase
{
    use RefreshDatabase;

    public $user;

    public function setUp():void
    {
        parent::setUp();
        $this->user = $this->authUser();
    }

    public function test_fetch_all_label_for_a_user()
    {
        $label = $this->createLabel([
            'user_id' => $this->user->id
        ]);

        $response = $this->getJson(route('label.index'))->assertOk()->json();

        $this->assertEquals(
            $response["data"]["labels"][0]['label_title'],
            $label->label_title
        );
    }

    public function test_user_can_create_new_label()
    {
        $label = LabelModel::factory()->raw();

        $this->postJson(route('label.store'), $label)
        ->assertCreated();

        $this->assertDatabaseHas('labels',[
            'label_title' => $label['label_title'],
            'label_color' => $label['label_color']
        ]);
    }

    public function test_user_can_update_label()
    {
        $label = $this->createLabel([
            "user_id" => $this->user->id
        ]);

        $this->patchJson(route('label.update',$label->label_id),[
            'label_color'=>'new-color',
            'label_title' => $label->label_title
        ])
        ->assertOk();

        $this->assertDatabaseHas('labels',['label_color' => 'new-color']);
    }

    public function test_user_can_delete_a_label()
    {
        $label = $this->createLabel([
            "user_id" => $this->user->id
        ]);

        $this->deleteJson(route('label.destroy',$label->label_id))->assertNoContent();

        $this->assertDatabaseMissing('labels',['label_title' => $label->label_title]);
    }

}
