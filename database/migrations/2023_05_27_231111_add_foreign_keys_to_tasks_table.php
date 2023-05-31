<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToTasksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
			$table->foreign('list_id', 'tasks_ibfk_1')->references('list_id')->on('todo_lists')->onUpdate('CASCADE')->onDelete('CASCADE');
			$table->foreign('label_id', 'tasks_ibfk_2')->references('label_id')->on('labels')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('tasks', function(Blueprint $table)
		{
			$table->dropForeign('tasks_ibfk_1');
			$table->dropForeign('tasks_ibfk_2');
		});
	}

}
