<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class KeywordSearch extends Migration
{
    public function up()
    {
        Schema::create('keyword_search', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('keywords')->nullable();
            $table->integer('status')->nullable();
            $table->longText('api_result')->nullable();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->softDeletes(); 
            $table->index(['status']);
            $table->fulltext(['keywords']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keyword_search');
    }
}
