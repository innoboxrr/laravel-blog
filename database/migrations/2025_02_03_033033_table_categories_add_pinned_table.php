<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection(config('laravel-blog.database.connection'))->table('blog_categories', function (Blueprint $table) {
            $table->boolean('pinned')->default(false)->after('slug');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection(config('laravel-blog.database.connection'))->table('blog_categories', function (Blueprint $table) {
            $table->dropColumn('pinned');
        });
    }
};
