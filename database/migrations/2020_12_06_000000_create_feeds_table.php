<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feed', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title', 255);
            $table->text('body')->default('');
            $table->string('image', 255)->nullable();
            $table->string('source', 255);
            $table->string('publisher', 255);
            $table->string('article_id', 255)->unique();
            $table->datetime('created_at')->nullable();
            $table->datetime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('feeds');
    }
}
