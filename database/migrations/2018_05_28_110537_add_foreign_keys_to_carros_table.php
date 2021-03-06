<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToCarrosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('carros', function(Blueprint $table)
		{
			$table->foreign('id', 'PK_carros_rallys')->references('id')->on('rallys')->onUpdate('RESTRICT')->onDelete('RESTRICT');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('carros', function(Blueprint $table)
		{
			$table->dropForeign('PK_carros_rallys');
		});
	}

}
