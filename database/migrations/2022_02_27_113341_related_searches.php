<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RelatedSearches extends Migration
{
    public function up()
    {
        Schema::create('related_search', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('keyword_id')->nullable()->constrained('keyword_search');
            $table->string('keywords')->nullable();
            $table->softDeletes(); 
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->index(['id']);
            $table->index(['id', 'keywords']);
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('related_search');
        Schema::enableForeignKeyConstraints();
    }
}
