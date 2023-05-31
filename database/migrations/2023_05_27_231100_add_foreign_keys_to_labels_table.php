<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToLabelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    try{

            Schema::table('labels', function(Blueprint $table)
            {
                $table->foreign('user_id', 'labels_ibfk_1')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('CASCADE');
            });
        }
        catch (Exception $e){}

	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('labels', function(Blueprint $table)
		{
			$table->dropForeign('labels_ibfk_1');
		});
	}

}
