<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterLocalStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('local_students', function (Blueprint $table){
            $table->enum('gender', ['male', 'female'])->after('age')->nullable();
        });
        Schema::table('foreign_students', function (Blueprint $table){
            $table->enum('gender', ['male', 'female'])->after('age')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('local_students', function (Blueprint $table){
            $table->dropColumn('gender');
        });
        Schema::table('foreign_students', function (Blueprint $table){
            $table->dropColumn('gender');
        });
    }
}