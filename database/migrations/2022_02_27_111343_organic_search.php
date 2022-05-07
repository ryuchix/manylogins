<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrganicSearch extends Migration
{
    public function up()
    {
        Schema::create('organic_result', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('keyword_id')->nullable()->constrained('keyword_search');
            $table->integer('pos')->nullable();
            $table->string('title')->nullable();
            $table->text('url')->nullable();
            $table->text('desc')->nullable();
            $table->text('url_shown')->nullable();
            $table->integer('pos_overall')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->softDeletes(); 
            $table->index(['id', 'keyword_id']);
            $table->fulltext(['url']);
            $table->fulltext(['desc']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('organic_result');
        Schema::enableForeignKeyConstraints();
    }
}
