<?php

class Create_Portfolios_Table {

	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('portfolios', function($table){

			$table->increments('id');

			$table->integer('order_id');
			$table->string('title');
			$table->text('description');
			$table->text('info');
			$table->string('img');

			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('portfolios');
	}

}